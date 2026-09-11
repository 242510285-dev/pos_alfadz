<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_produk', 'like', '%' . $search . '%');
            });
        })
            ->latest()
            ->paginate(10)
            ->appends([
                'search' => $search
            ]);

        return view('produk.index', compact('produks'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $jenis = Jenis::orderBy('nama_jenis', 'asc')->get();

        return view('produk.create', compact('jenis'));
    }

    /**
     * Menyimpan produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',

            'jenis_produk' => [
                'required',
                'string',
                'exists:jenis,nama_jenis'
            ],

            'harga_beli' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'harga_jual' => [
                'required',
                'numeric',
                'min:0'
            ],

            'stok' => [
                'required',
                'integer',
                'min:0'
            ],

            'foto' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ], [
            'nama.required' => 'Nama produk wajib diisi.',

            'jenis_produk.required' => 'Jenis produk wajib dipilih.',
            'jenis_produk.exists' => 'Jenis produk yang dipilih tidak valid.',

            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 0.',

            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',

            'foto.file' => 'File foto tidak valid.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')
                ->store('products', 'public');
        }

        Produk::create([
            'user_id' => Auth::id() ?? 1,
            'nama' => $request->nama,
            'jenis_produk' => $request->jenis_produk,
            'harga_beli' => $request->harga_beli ?? 0,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'foto' => $fotoPath,
        ]);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Detail produk
     */
    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return view('produk.show', compact('produk'));
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        $jenis = Jenis::orderBy('nama_jenis', 'asc')->get();

        return view('produk.edit', compact('produk', 'jenis'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',

            'jenis_produk' => [
                'required',
                'string',
                'exists:jenis,nama_jenis'
            ],

            'harga_beli' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'harga_jual' => [
                'required',
                'numeric',
                'min:0'
            ],

            'stok' => [
                'required',
                'integer',
                'min:0'
            ],

            'foto' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
        ], [
            'nama.required' => 'Nama produk wajib diisi.',

            'jenis_produk.required' => 'Jenis produk wajib dipilih.',
            'jenis_produk.exists' => 'Jenis produk yang dipilih tidak valid.',

            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh kurang dari 0.',

            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.numeric' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual tidak boleh kurang dari 0.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',

            'foto.file' => 'File foto tidak valid.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = $produk->foto;

        if ($request->hasFile('foto')) {

            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            $fotoPath = $request->file('foto')
                ->store('products', 'public');
        }

        $produk->update([
            'nama' => $request->nama,
            'jenis_produk' => $request->jenis_produk,
            'harga_beli' => $request->harga_beli ?? 0,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'foto' => $fotoPath,
        ]);

        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);

            if (
                $produk->foto &&
                Storage::disk('public')->exists($produk->foto)
            ) {
                Storage::disk('public')->delete($produk->foto);
            }

            $produk->delete();

            return redirect()
                ->route('produk.index')
                ->with('success', 'Produk berhasil dihapus!');

        } catch (QueryException $e) {

            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('produk.index')
                    ->with(
                        'error',
                        'Gagal menghapus! Produk ini sudah tercatat dalam riwayat transaksi penjualan.'
                    );
            }

            return redirect()
                ->route('produk.index')
                ->with(
                    'error',
                    'Terjadi kesalahan saat menghapus produk.'
                );
        }
    }
}
