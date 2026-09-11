<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UserController;

Route::get('/', fn () => redirect('/login'));

Route::middleware('guest')->group(function () {

    Route::get('/login', [Authcontroller::class, 'index'])
        ->name('login');

    Route::post('/auth', [Authcontroller::class, 'auth'])
        ->name('auth');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [Authcontroller::class, 'logout'])
        ->name('logout');

    Route::middleware('role:admin,kasir')->group(function () {

        Route::resource('/produk', ProdukController::class);

        Route::resource('/penjualan', PenjualanController::class);

        Route::resource('/itempenjualan', ItemPenjualanController::class);

        Route::resource('/jenis', JenisController::class)
            ->except(['show'])
            ->parameters([
                'jenis' => 'jenis'
            ]);

        Route::get('/tentang', [TentangController::class, 'index'])
            ->name('tentang.index');
    });

    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/users', [UserController::class, 'index'])
            ->name('admin.users');

        Route::get('/admin/users/create', [UserController::class, 'create'])
            ->name('admin.users.create');

        Route::post('/admin/users/store', [UserController::class, 'store'])
            ->name('admin.users.store');

        Route::get('/admin/users/edit/{user}', [UserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/admin/users/update/{user}', [UserController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/admin/users/destroy/{user}', [UserController::class, 'destroy'])
            ->name('admin.users.destroy');
    });
});