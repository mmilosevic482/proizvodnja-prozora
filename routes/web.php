<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KlijentController;
use App\Http\Controllers\ProizvodController;
use App\Http\Controllers\NarudzbinaController;
use App\Http\Controllers\MaterijalController;
use App\Http\Controllers\ProizvodniZadatakController;
use App\Http\Controllers\KatalogController;

// Početna strana
Route::get('/', function () {
    return view('welcome');
});

// Test ruta za role
Route::get('/test-role', function () {
    return '✅ Role middleware radi! Samo admin/menadžer može da vidi ovo.';
})->middleware(['auth', 'role:admin,menadzer']);

// AUTH RUTE (javne)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// KATALOG (dostupan svima, čak i neulogovanima)
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{proizvod}', [KatalogController::class, 'show'])->name('katalog.show');

// ZAŠTIĆENE RUTE (samo za ulogovane)
Route::middleware('auth')->group(function () {

    // Dashboard (za sve ulogovane)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Odjava (za sve ulogovane)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ================== KLIJENTI ==================
    // CRUD za admin/menadzer
    Route::middleware('auth')->group(function () {

    // Pregled klijenata za sve ulogovane
    Route::get('/clients', [KlijentController::class, 'index'])->name('clients.index');


    // CRUD samo za admin/menadzer
    Route::middleware('role:admin,menadzer')->group(function () {
        Route::get('/clients/create', [KlijentController::class, 'create'])->name('clients.create');
        Route::post('/clients', [KlijentController::class, 'store'])->name('clients.store');
        Route::get('/clients/{klijent}/edit', [KlijentController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{klijent}', [KlijentController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{klijent}', [KlijentController::class, 'destroy'])->name('clients.destroy');
    });
});
    Route::get('/clients/{klijent}', [KlijentController::class, 'show'])->name('clients.show');


    // Pregled klijenata za sve ulogovane
    Route::get('/clients', [KlijentController::class, 'index'])->name('clients.index');
    Route::get('/clients/{klijent}', [KlijentController::class, 'show'])->name('clients.show');

    // ================== PROIZVODI ==================
    Route::get('/proizvods', [ProizvodController::class, 'index'])->name('proizvods.index');

    Route::middleware('role:admin,menadzer')->group(function () {
        Route::get('/proizvods/create', [ProizvodController::class, 'create'])->name('proizvods.create');
        Route::post('/proizvods', [ProizvodController::class, 'store'])->name('proizvods.store');
        Route::get('/proizvods/{proizvod}/edit', [ProizvodController::class, 'edit'])->name('proizvods.edit');
        Route::put('/proizvods/{proizvod}', [ProizvodController::class, 'update'])->name('proizvods.update');
        Route::delete('/proizvods/{proizvod}', [ProizvodController::class, 'destroy'])->name('proizvods.destroy');
        Route::get('/proizvods/{proizvod}', [ProizvodController::class, 'show'])->name('proizvods.show');
    });

    // ================== NARUDŽBINE ==================

// 1. CREATE i STORE - NEMA MIDDLEWARE UOPŠTE
Route::get('/narudzbine/create', [NarudzbinaController::class, 'create'])->name('narudzbine.create');
Route::post('/narudzbine', [NarudzbinaController::class, 'store'])->name('narudzbine.store');

// 2. SVI MOGU - index i show (takođe bez middleware)
Route::get('/narudzbine', [NarudzbinaController::class, 'index'])->name('narudzbine.index');
Route::get('/narudzbine/{narudzbina}', [NarudzbinaController::class, 'show'])->name('narudzbine.show');

// 3. EDIT, UPDATE, DELETE - samo admin/menadžer (OVO OSTAVI SA MIDDLEWARE-OM)
Route::middleware('role:admin,menadzer')->group(function () {
    Route::get('/narudzbine/{narudzbina}/edit', [NarudzbinaController::class, 'edit'])->name('narudzbine.edit');
    Route::put('/narudzbine/{narudzbina}', [NarudzbinaController::class, 'update'])->name('narudzbine.update');
    Route::delete('/narudzbine/{narudzbina}', [NarudzbinaController::class, 'destroy'])->name('narudzbine.destroy');
});
    // ================== MATERIJALI ==================

// Static ruta mora prvo
Route::get('/materijali', [MaterijalController::class, 'index'])->name('materijali.index');

// CRUD za admin/menadžer
Route::middleware('role:admin,menadzer')->group(function () {
    Route::get('/materijali/create', [MaterijalController::class, 'create'])->name('materijali.create');
    Route::post('/materijali', [MaterijalController::class, 'store'])->name('materijali.store');
    Route::get('/materijali/{materijal}/edit', [MaterijalController::class, 'edit'])->name('materijali.edit');
    Route::put('/materijali/{materijal}', [MaterijalController::class, 'update'])->name('materijali.update');
    Route::delete('/materijali/{materijal}', [MaterijalController::class, 'destroy'])->name('materijali.destroy');
});

// Dynamic ruta mora na kraju
Route::get('/materijali/{materijal}', [MaterijalController::class, 'show'])->name('materijali.show');

    // ================== ZADACI ==================
    Route::get('/proizvodni-zadaci', [ProizvodniZadatakController::class, 'index'])->name('proizvodni-zadaci.index');
    Route::get('/proizvodni-zadaci/{proizvodni_zadatak}', [ProizvodniZadatakController::class, 'show'])->name('proizvodni-zadaci.show');

    Route::middleware('role:admin,menadzer')->group(function () {
        Route::get('/proizvodni-zadaci/create', [ProizvodniZadatakController::class, 'create'])->name('proizvodni-zadaci.create');
        Route::post('/proizvodni-zadaci', [ProizvodniZadatakController::class, 'store'])->name('proizvodni-zadaci.store');
        Route::get('/proizvodni-zadaci/{proizvodni_zadatak}/edit', [ProizvodniZadatakController::class, 'edit'])->name('proizvodni-zadaci.edit');
        Route::put('/proizvodni-zadaci/{proizvodni_zadatak}', [ProizvodniZadatakController::class, 'update'])->name('proizvodni-zadaci.update');
        Route::delete('/proizvodni-zadaci/{proizvodni_zadatak}', [ProizvodniZadatakController::class, 'destroy'])->name('proizvodni-zadaci.destroy');
    });

});
