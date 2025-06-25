<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanDetailsController;
use App\Http\Controllers\EmiDetailsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/loan-details', [LoanDetailsController::class, 'index'])->name('loan_details.index');
    Route::get('/emi-details', [EmiDetailsController::class, 'index'])->name('emi_details.index');
    Route::post('/emi-details/process', [EmiDetailsController::class, 'process'])->name('emi_details.process');
});

require __DIR__ . '/auth.php';
