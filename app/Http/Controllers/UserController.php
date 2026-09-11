<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ==============================
    // INDEX USER
    // ==============================
    public function index(SearchRequest $request)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $users = User::whereRaw(
                "MATCH(name, email) AGAINST(? IN BOOLEAN MODE)",
                [$keyword]
            )
                ->paginate(10)
                ->withQueryString();
        } else {
            $users = User::latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('users.index', compact('users'));
    }


    // ==============================
    // CREATE USER
    // ==============================
    public function create()
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }


    // ==============================
    // STORE USER
    // ==============================
    public function store(StoreRequest $request)
    {
        $dataReq = $request->validated();

        User::create([
            'name' => $dataReq['name'],
            'email' => $dataReq['email'],
            'password' => Hash::make($dataReq['password']),
            'role_id' => $dataReq['role_id'],
        ]);

        return redirect()
            ->route('admin.users')
            ->with('success', 'User berhasil dibuat');
    }


    // ==============================
    // EDIT USER
    // ==============================
    public function edit(User $user)
    {
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }


    // ==============================
    // UPDATE USER
    // ==============================
    public function update(UpdateRequest $request, User $user)
    {
        $dataReq = $request->validated();

        $user->name = $dataReq['name'];

        $user->email = $dataReq['email'];

        $user->role_id = $dataReq['role_id'];

        // Password hanya diubah jika diisi
        if (!empty($dataReq['password'])) {
            $user->password = Hash::make($dataReq['password']);
        }

        // Jika is_active dikirim dari form
        if (isset($dataReq['is_active'])) {
            $user->is_active = $dataReq['is_active'];
        }

        $user->save();

        return redirect()
            ->route('admin.users.edit', $user->id)
            ->with('success', 'User berhasil diperbarui');
    }


    // ==============================
    // DELETE USER
    // ==============================
    public function destroy(User $user)
    {
        // Hapus item penjualan yang berhubungan
        $penjualanIds = Penjualan::where('user_id', $user->id)->pluck('id');

        if ($penjualanIds->isNotEmpty()) {
            \App\Models\ItemPenjualan::whereIn('penjualan_id', $penjualanIds)->delete();

            Penjualan::whereIn('id', $penjualanIds)->delete();
        }

        // Hapus produk yang dibuat oleh user
        Produk::where('user_id', $user->id)->delete();

        // Hapus user
        $user->delete();

        return back()
            ->with('success', 'User berhasil dihapus');
    }
}