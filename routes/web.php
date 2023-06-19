<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("pengajuan", [App\http\Controllers\PengajuanController::class, 'index'])->name('pengajuan.index');
Route::get("pengajuan/{bukuId}/create", [App\http\Controllers\PengajuanController::class, 'create'])->name('pengajuan.create');
Route::post("pengajuan/{bukuId}/store", [App\http\Controllers\PengajuanController::class, 'store'])->name('pengajuan.store');
Route::put("pengajuan/{id}/status/{status}", [App\http\Controllers\PengajuanController::class, 'status'])->name('pengajuan.status');

Route::resource("anggota", App\http\Controllers\UserController::class)->except(['show']);
Route::resource("buku", App\http\Controllers\BukuController::class)->except(['show', 'store', 'update', 'destroy']);
