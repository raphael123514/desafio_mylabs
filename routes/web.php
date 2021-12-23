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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();


//ROTAS ADMIN AUTH

Route::get('/admin/aula', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [App\Http\Controllers\Auth\RegisterAdminController::class, 'index'])->name('admin.register');
Route::post('/admin/register', [App\Http\Controllers\Auth\RegisterAdminController::class, 'create'])->name('admin.register.submit');
// Route::post('/admin/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout.submit');

// ROTAS AULAS ADMIN

Route::get('admin/aula/novo', [App\Http\Controllers\AulaController::class, 'create'])->name('aula.create');
Route::post('admin/aula/store', [App\Http\Controllers\AulaController::class, 'store'])->name('aula.store');
Route::get('admin/aula/listar', [App\Http\Controllers\AulaController::class, 'listar'])->name('aula.listar');
Route::get('admin/aula/edit/{id}', [App\Http\Controllers\AulaController::class, 'edit'])->name('aula.edit');
Route::patch('admin/aula/update/{id}', [App\Http\Controllers\AulaController::class, 'update'])->name('aula.update');
Route::delete('admin/aula/delete/{id}', [App\Http\Controllers\AulaController::class, 'destroy'])->name('aula.delete');

// ROTAS ALUNO

Route::get('aula/listar', [App\Http\Controllers\AlunoController::class, 'listar'])->name('aluno.aula.listar');
Route::post('aluno/checkin', [App\Http\Controllers\AlunoController::class, 'checkin'])->name('aluno.checkin');
