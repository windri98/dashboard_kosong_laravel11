<?php

use App\Models\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\auth\LoginRegisterController;

// Route::get('/q', function () {
//     return view('dashboard.main.role.role');
// });


// Register
// Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginRegisterController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');

// Route::get('/register', [LoginRegisterController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [LoginRegisterController::class, 'register'])->name('register.post');

// Route::middleware(['auth'])->group(function () {
// });

// Dashboard
Route::get('/dashboard', [DashboardController::class,'dashboard']);

// roles
Route::get('/showrole', [RolesController::class, 'showrole'])->name('show.role');
Route::get('/addrole', [RolesController::class, 'addrole'])->name('add.role');
Route::get('/role/{id}/edit', [RolesController::class, 'editrole'])->name('edit.role');

// create, update, delete(role)
Route::post('/create/role', [RolesController::class, 'createrole'])->name('create.role');
Route::put('/role/update/{id}', [RolesController::class, 'updaterole'])->name('update.role');
Route::delete('/role/delete/{id}', [RolesController::class, 'deleterole'])->name('delete.role');

// user
Route::get('/showuser', [UserController::class, 'showuser'])->name('show.user');
Route::get('/addtuser', [UserController::class, 'adduser'])->name('add.user');
Route::get('/edituser/{id}/edit', [UserController::class, 'edituser'])->name('edit.user');
Route::get('/user/password', [UserController::class, 'ubahpassword'])->name('ubah.password');

// create, update, delete(user)
Route::post('/create/user', [UserController::class, 'createuser'])->name('create.user');
Route::put('/user/update/{id}', [UserController::class, 'updateuser'])->name('update.user');
Route::delete('/user/delete/{id}', [UserController::class, 'deleteuser'])->name('delete.user');
Route::put('/update/password', [UserController::class, 'updatepassword'])->name('update.password');

// absensi


