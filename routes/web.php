<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\GajiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutiController;


// Auth routes
Route::get('/', [AuthController::class,'showRegistration'])->name('registration.show');
Route::get('/registration', [AuthController::class,'showRegistration'])->name('registration.show');
Route::post('/registration/submit', [AuthController::class,'submitRegistration'])->name('registration.submit');
Route::get('/login', [AuthController::class,'showLogin'])->name('login.show');
Route::post('/login/submit', [AuthController::class,'submitLogin'])->name('login.submit');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', function () {return view('dashboard.home', ['totalUser' => \App\Models\User::count(),]);})->name('dashboard.home');

// User routes
Route::get('/user', [UserController::class,'index'])->name('user.index');
Route::get('/user/add', [UserController::class,'add'])->name('user.add');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// Lembur

Route::get('/lembur', [LemburController::class,'index'])->name('lembur.index');
Route::get('/lembur/create', [LemburController::class,'create'])->name('lembur.create');
Route::get('lembur/{user_id}/{tanggal}/edit', [LemburController::class, 'edit'])->name('lembur.edit');
Route::delete('/lembur/{user_id}/{tanggal}', [LemburController::class, 'destroy'])->name('lembur.destroy');
Route::post('/lembur/store', [LemburController::class,'store'])->name('lembur.store');
Route::patch('lembur/{user_id}/{tanggal}', [LemburController::class, 'update'])->name('lembur.update');
Route::patch('/lembur/{user_id}/{tanggal}/approve', [LemburController::class, 'approve'])->name('lembur.approve');
Route::patch('/lembur/{user_id}/{tanggal}/reject', [LemburController::class, 'reject'])->name('lembur.reject');

// Absen
Route::get('/absen', [AbsenController::class,'index'])->name('absen.index');
Route::get('/absen/create', [AbsenController::class,'create'])->name('absen.create');
Route::post('/absen/store', [AbsenController::class, 'store'])->name('absen.store'); 
Route::post('/absen/checkin', [AbsenController::class, 'checkIn'])->name('absen.checkin');
Route::put('/absen/{id}/checkout', [AbsenController::class, 'checkOut'])->name('absen.checkout');
Route::get('/absen/{id}/edit', [AbsenController::class,'edit'])->name('absen.edit');
Route::put('/absen/{id}', [AbsenController::class,'update'])->name('absen.update');
Route::delete('/absen/{id}', [AbsenController::class,'destroy'])->name('absen.destroy');

// Gaji
Route::get('/gaji', [GajiController::class,'index'])->name('gaji.index');
Route::get('/gaji/add', [GajiController::class,'create'])->name('gaji.create');
Route::post('/gaji/store', [GajiController::class,'store'])->name('gaji.store');
Route::delete('/gaji/{user_id}', [GajiController::class, 'destroy'])->name('gaji.destroy');
Route::get('/gaji/{user_id}/edit', [GajiController::class, 'edit'])->name('gaji.edit');
Route::get('/gaji/{user_id}/download', [GajiController::class, 'download'])->name('gaji.download');
Route::patch('/gaji/{user_id}/update', [GajiController::class, 'update'])->name('gaji.update');

// Cuti
Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index'); 
Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');  
Route::post('/cuti/store', [CutiController::class, 'store'])->name('cuti.store');  
Route::patch('/cuti/{user_id}/{jenis_cuti}/{tanggal}/approve', [CutiController::class, 'approve'])->name('cuti.approve');
Route::patch('/cuti/{user_id}/{jenis_cuti}/{tanggal}/reject', [CutiController::class, 'reject'])->name('cuti.reject');