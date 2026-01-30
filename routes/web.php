<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DependentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryScaleController;
use App\Http\Controllers\SocialWelfareController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de Autenticación (Públicas)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// RUTA TEMPORAL: Reseteo de Base de Datos (Ya que no sale la terminal)
Route::get('/magic-seed', function () {
    set_time_limit(300); // Aumentar tiempo a 5 minutos para evitar timeouts
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed --force');
        return "¡Listo! Base de datos reseteada con 11 empleados nuevos y usuario admin.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

// Rutas Protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    
    Route::get('/social-welfare', [SocialWelfareController::class, 'index'])->name('social-welfare.index');

    Route::post('/employees/{employee}/dependents', [DependentController::class, 'store'])->name('dependents.store');
    Route::put('/dependents/{dependent}', [DependentController::class, 'update'])->name('dependents.update');
    Route::delete('/dependents/{dependent}', [DependentController::class, 'destroy'])->name('dependents.destroy');

    Route::post('/employees/{employee}/bank-accounts', [BankAccountController::class, 'store'])->name('bank-accounts.store');
    Route::put('/bank-accounts/{bankAccount}', [BankAccountController::class, 'update'])->name('bank-accounts.update');
    Route::delete('/bank-accounts/{bankAccount}', [BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');

    Route::resource('users', UserController::class);
    Route::resource('positions', PositionController::class);
    Route::resource('salary-scales', SalaryScaleController::class);
});
