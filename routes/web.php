<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
});

Route::middleware('auth')->group(function () {
    //* Dashboard
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //* User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/tambah',[UserController::class, 'tambah'])->middleware('permission:User,tambah')
    ->name('users.tambah');
    Route::post('/users', [UserController::class, 'simpan'])->middleware('permission:User,tambah')
    ->name('users.simpan');
    Route::get('/users/{id}/ubah', [UserController::class, 'ubah'])->middleware('permission:User,ubah')
    ->name('users.ubah');
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('permission:User,ubah')
    ->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'hapus'])->middleware('permission:User,hapus')
    ->name('users.hapus');

    //* Permissions
    Route::get('/users/hak-akses', [PermissionController::class, 'index'])->name('users.hak-akses');
    Route::post('/users/hak-akses/update', [PermissionController::class, 'update'])->name('users.hak-akses.update');

    //* Aset
    Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('/aset/tambah',[AsetController::class, 'tambah'])->middleware('permission:Inventori,tambah')
    ->name('aset.tambah');
    Route::post('/aset', [AsetController::class, 'simpan'])->middleware('permission:Inventori,tambah')->name('aset.simpan');
    Route::get('/aset/{id}', [AsetController::class, 'detail'])->name('aset.detail');
    Route::get('/aset/{id}/ubah', [AsetController::class, 'ubah'])->middleware('permission:Inventori,ubah')->name('aset.ubah');
    Route::put('/aset/{id}', [AsetController::class, 'update'])->middleware('permission:Inventori,ubah')
    ->name('aset.update');
    Route::delete('/aset/{id}', [AsetController::class, 'hapus'])->middleware('permission:Inventori,hapus')
    ->name('aset.hapus');

    //* Stok Barang
    // Route::prefix('stok-barang')->group(function () {
    Route::get('/stok', [StokBarangController::class, 'index'])->name('stok.index');
    Route::get('/stok/tambah',[StokBarangController::class, 'tambah'])->middleware('permission:Stok,tambah')->name('stok.tambah');
    Route::post('/stok',[StokBarangController::class, 'simpan']) ->middleware('permission:Stok,tambah')->name('stok.simpan');
    Route::get('/stok/{id}/ubah', [StokBarangController::class, 'ubah'])->middleware('permission:Stok,ubah')->name('stok.ubah');
    Route::put('/stok/{id}', [StokBarangController::class, 'update'])->middleware('permission:Stok,ubah')->name('stok.update');
    Route::delete('/stok/{id}', [StokBarangController::class, 'hapus'])->middleware('permission:Stok,hapus')->name('stok.hapus');
    // });

    //* Transaksi
    // Route::prefix('transaksi')->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])
        // ->middleware('permission:Stok,index') // Menyesuaikan modul Anda
        ->name('transaksi.index');

    // Route::get('/tambah', [TransaksiController::class, 'tambah'])
    //     ->middleware('permission:Stok,tambah')
    //     ->name('transaksi.tambah');

    // Route::post('/simpan', [TransaksiController::class, 'simpan'])
    //     ->middleware('permission:Stok,simpan')
    //     ->name('transaksi.simpan');
    // });

    // Tes route
    // Route::view('/aset/ubah', 'aset.ubah')->name('aset.ubah');
    // CRUD --resource
    // Route::resource('asets', AsetController::class);

    //* 404 Not Found
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});

