<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $penjualan = Penjualan::with('user')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%")
                        ->orWhere('metode_pembayaran', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%")
                        ->orWhereHas('user', fn($u) =>
                            $u->where('name', 'like', "%$search%")
                        );
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        return view('penjualan.create', [
            'produks' => Produk::where('stok', '>', 0)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produk,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $total = collect($request->items)
                ->sum(fn($item) => $item['harga'] * $item['qty']);

            $penjualan = Penjualan::create([
                'user_id' => Auth::id() ?? 1,
                'total_pembayaran' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'COMPLETED',
            ]);

            foreach ($request->items as $item) {
                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id' => $item['produk_id'],
                    'kuantitas' => $item['qty'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['qty'],
                ]);

                Produk::findOrFail($item['produk_id'])
                    ->decrement('stok', $item['qty']);
            }

            DB::commit();

            return redirect()
                ->route('penjualan.show', $penjualan->id)
                ->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'Gagal memproses transaksi: ' . $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with([
            'user',
            'itemPenjualan.produk'
        ])->findOrFail($id);

        return view('penjualan.show', compact('penjualan'));
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with([
            'user',
            'itemPenjualan.produk'
        ])->findOrFail($id);

        if (strtoupper($penjualan->status) !== 'PENDING') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah COMPLETED tidak dapat diedit.');
        }

        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'produks' => Produk::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::with('itemPenjualan')->findOrFail($id);

        if (strtoupper($penjualan->status) !== 'PENDING') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah COMPLETED tidak dapat diubah.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|string',
            'status' => 'required|in:PENDING,COMPLETED',
        ]);

        $penjualan->update($request->only([
            'metode_pembayaran',
            'status'
        ]));

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::with('itemPenjualan')->findOrFail($id);

        if (strtoupper($penjualan->status) !== 'PENDING') {
            return redirect()
                ->route('penjualan.index')
                ->with('error', 'Transaksi yang sudah COMPLETED tidak dapat dihapus.');
        }

        DB::beginTransaction();

        try {
            foreach ($penjualan->itemPenjualan as $item) {
                Produk::find($item->produk_id)?->increment(
                    'stok',
                    $item->kuantitas
                );
            }

            $penjualan->itemPenjualan()->delete();
            $penjualan->delete();

            DB::commit();

            return redirect()
                ->route('penjualan.index')
                ->with('success', 'Transaksi PENDING berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('penjualan.index')
                ->with(
                    'error',
                    'Gagal menghapus transaksi: ' . $e->getMessage()
                );
        }
    }
}