<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Register');
});
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
Route::get('/dashboard/{token}', [AuthenticatedController::class, 'store'])->name('dashboard');

Route::middleware(['auth', 'verified.token'])->group(function () {
    Route::patch('/token', [TokenController::class, 'update'])->name('token.update');
    Route::get('/game', [GameController::class, 'index'])->name('game');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
});
