<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisController extends Controller
{
    /**
     * Menampilkan semua jenis.
     */
    public function index(Request $request)
    {
        $query = Jenis::with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama_jenis', 'like', '%' . $search . '%');
        }

        $jenis = $query
            ->orderBy('nama_jenis', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('jenis.index', compact('jenis'));
    }

    /**
     * Menampilkan form tambah jenis.
     */
    public function create()
    {
        return view('jenis.create');
    }

    /**
     * Menyimpan jenis baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis,nama_jenis',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.max' => 'Nama jenis maksimal 100 karakter.',
            'nama_jenis.unique' => 'Jenis tersebut sudah ada.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ]);

        Jenis::create([
            'nama_jenis' => $validated['nama_jenis'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Jenis $jenis)
    {
        return view('jenis.edit', compact('jenis'));
    }

    /**
     * Mengubah jenis.
     */
    public function update(Request $request, Jenis $jenis)
    {
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis,nama_jenis,' . $jenis->id,
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.max' => 'Nama jenis maksimal 100 karakter.',
            'nama_jenis.unique' => 'Jenis tersebut sudah ada.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ]);

        $jenis->update([
            'nama_jenis' => $validated['nama_jenis'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil diperbarui.');
    }

    /**
     * Menghapus jenis.
     */
    public function destroy(Jenis $jenis)
    {
        $jenis->delete();

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil dihapus.');
    }
}