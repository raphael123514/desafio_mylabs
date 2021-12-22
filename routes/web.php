<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ROTAS ADMIN

Route::get('/admin/aula', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
// Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout.submit');


// ROTAS AULAS

Route::get('admin/aula/novo', [App\Http\Controllers\AulaController::class, 'create'])->name('aula.create');
Route::post('admin/aula/store', [App\Http\Controllers\AulaController::class, 'store'])->name('aula.store');
Route::get('admin/aula/listar', [App\Http\Controllers\AulaController::class, 'listar'])->name('aula.listar');


