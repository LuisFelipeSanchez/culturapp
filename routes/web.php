<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\Admin\AdminSedeController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;

// Ruta de inicio (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// RUTAS PÚBLICAS PARA CIUDADANOS
// Esto crea automáticamente sedes.index y sedes.show
Route::resource('sedes', SedeController::class)->only(['index', 'show']);

// RUTAS PROTEGIDAS PARA ADMINISTRADORES
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard con datos reales
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // La ruta que creamos para el Super Admin y Admins
    Route::get('/admin/manage/{sede?}', [AdminSedeController::class, 'manage'])->name('admin.manage');
    Route::get('/admin/manage/{sede}/editar', [AdminSedeController::class, 'edit'])->name('admin.manage.edit');
    Route::put('/admin/manage/{sede}', [AdminSedeController::class, 'update'])->name('admin.manage.update');

    // Cursos - CRUD para super admin 
    Route::resource('admin/cursos', CourseController::class)
        ->names('admin.cursos')
        ->parameters(['cursos' => 'course']);

    // Noticias - CRUD para super admin 
    Route::resource('admin/noticias', \App\Http\Controllers\Admin\NewsController::class)
        ->names('admin.noticias')
        ->parameters(['noticias' => 'news']);

    // Rutas públicas de Noticias
    Route::get('/noticias', [\App\Http\Controllers\NewsController::class, 'indexPublic'])->name('noticias.index');

    // Rutas del perfil de Breeze (si las dejaste)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
