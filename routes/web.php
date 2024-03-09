<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboardView'])->name('home');
    Route::get('/management-users', [UserController::class, 'managementUser'])->name('managementUser');
    Route::get('/add-users', [UserController::class, 'createUser'])->name('addUser');
    Route::post('/store', [UserController::class, 'storeUser'])->name('storeUser');
    Route::get('/edit-users/{id}', [UserController::class, 'editUser'])->name('editUser');
});
