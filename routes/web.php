<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\PermissionController;

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
    Route::get('/users/hak-akses', [PermissionController::class, 'index'])->name('users.hak_akses');
    Route::post('/users/hak-akses/update', [PermissionController::class, 'update'])->name('users.hak_akses.update');

    //* Aset
    Route::get('/aset', [AsetController::class, 'index'])->name('aset.index');
    Route::get('/aset/tambah',[AsetController::class, 'tambah'])->middleware('permission:Inventory,tambah')
    ->name('aset.tambah');
    Route::post('/aset', [AsetController::class, 'simpan'])->middleware('permission:Inventory,tambah')->name('aset.simpan');
    Route::get('/aset/{id}', [AsetController::class, 'detail'])->name('aset.detail');
    Route::get('/aset/{id}/ubah', [AsetController::class, 'ubah'])->middleware('permission:Inventory,ubah')->name('aset.ubah');
    Route::put('/aset/{id}', [AsetController::class, 'update'])->middleware('permission:Inventory,ubah')
    ->name('aset.update');
    Route::delete('/aset/{id}', [AsetController::class, 'hapus'])->middleware('permission:Inventory,hapus')
    ->name('aset.hapus');

    // Tes route
    // Route::view('/aset/ubah', 'aset.ubah')->name('aset.ubah');
    // CRUD --resource
    // Route::resource('asets', AsetController::class);

    //* 404 Not Found
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});

