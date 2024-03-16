<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DoctorScheduleController;
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
    // user
    Route::get('/management-users', [UserController::class, 'managementUser'])->name('managementUser');
    Route::get('/add-user', [UserController::class, 'createUser'])->name('addUser');
    Route::post('/store-user', [UserController::class, 'storeUser'])->name('storeUser');
    Route::get('/edit-user/{id}', [UserController::class, 'editUser'])->name('editUser');
    Route::post('/update-user', [UserController::class, 'updateUser'])->name('updateUser');
    Route::post('/delete-user', [UserController::class, 'deleteUser'])->name('deleteUser');
    // doctor
    Route::get('/management-doctors', [DoctorController::class, 'managementDoctor'])->name('managementDoctor');
    Route::get('/add-doctor', [DoctorController::class, 'createDoctor'])->name('addDoctor');
    Route::post('/store-doctor', [DoctorController::class, 'storeDoctor'])->name('storeDoctor');
    Route::get('/edit-doctor/{id}', [DoctorController::class, 'editDoctor'])->name('editDoctor');
    Route::post('/update-doctor', [DoctorController::class, 'updateDoctor'])->name('updateDoctor');
    Route::post('/delete-doctor', [DoctorController::class, 'deleteDoctor'])->name('deleteDoctor');
    // doctor_schedule
    Route::get('/management-doctors-schedule', [DoctorScheduleController::class, 'managementDoctorSchedule'])->name('managementDoctorSchedule');
    // Route::get('/add-doctor', [DoctorController::class, 'createDoctor'])->name('addDoctor');
    // Route::post('/store-doctor', [DoctorController::class, 'storeDoctor'])->name('storeDoctor');
    // Route::get('/edit-doctor/{id}', [DoctorController::class, 'editDoctor'])->name('editDoctor');
    // Route::post('/update-doctor', [DoctorController::class, 'updateDoctor'])->name('updateDoctor');
    // Route::post('/delete-doctor', [DoctorController::class, 'deleteDoctor'])->name('deleteDoctor');

});
