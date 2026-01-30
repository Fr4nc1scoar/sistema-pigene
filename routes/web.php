<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('employees', EmployeeController::class); // Ya permite create, store, edit, update, destroy

Route::get('/social-welfare', [App\Http\Controllers\SocialWelfareController::class, 'index'])->name('social-welfare.index');

Route::post('/employees/{employee}/dependents', [App\Http\Controllers\DependentController::class, 'store'])->name('dependents.store');
Route::put('/dependents/{dependent}', [App\Http\Controllers\DependentController::class, 'update'])->name('dependents.update'); // Ya existía, verificar funcionab.
Route::delete('/dependents/{dependent}', [App\Http\Controllers\DependentController::class, 'destroy'])->name('dependents.destroy');

Route::post('/employees/{employee}/bank-accounts', [App\Http\Controllers\BankAccountController::class, 'store'])->name('bank-accounts.store');
Route::put('/bank-accounts/{bankAccount}', [App\Http\Controllers\BankAccountController::class, 'update'])->name('bank-accounts.update'); // Faltaba esta
Route::delete('/bank-accounts/{bankAccount}', [App\Http\Controllers\BankAccountController::class, 'destroy'])->name('bank-accounts.destroy');

Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('positions', App\Http\Controllers\PositionController::class);
Route::resource('salary-scales', App\Http\Controllers\SalaryScaleController::class);
