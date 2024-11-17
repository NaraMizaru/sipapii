<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Pengelolaan\AdminInstansiController;
use App\Http\Controllers\Admin\Pengelolaan\AdminKelasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('post.login');

    Route::get('/logout', 'logout')->name('logout')->middleware('auth');
});

// Route Path Admin
Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
    });

    Route::prefix('/pengelolaan')->group(function () {
        Route::controller(AdminKelasController::class)->group(function () {
            Route::prefix('/kelas')->group(function () {
                Route::get('/', 'index')->name('admin.pengelolaan.kelas');
                Route::post('/add', 'addKelas')->name('admin.pengelolaan.kelas.add');
                Route::post('/{id}/edit', 'editKelas')->name('admin.pengelolaan.kelas.edit');
                Route::get('/{id}/delete', 'deleteKelas')->name('admin.pengelolaan.kelas.delete');
                Route::get('/data', 'data')->name('admin.pengelolaan.kelas.data');
                Route::get('/data/{id}', 'dataById')->name('admin.pengelolaan.kelas.data.id');
                Route::post('/import', 'importKelas')->name('admin.pengelolaan.kelas.import');
            });
        });

        Route::controller(AdminInstansiController::class)->group(function () {
            Route::prefix('/instansi')->group(function () {
                Route::get('/', 'index')->name('admin.pengelolaan.instansi');
                Route::get('/form/{id?}', 'form')->name('admin.pengelolaan.instansi.form');
                Route::post('/form/{id?}', 'store')->name('admin.pengelolaan.instansi.form.store');
                Route::get('/data', 'data')->name('admin.pengelolaan.instansi.data');
                Route::get('/{id}/delete', 'delete')->name('admin.pengelolaan.instansi.delete');
            });
        });
    });
});
