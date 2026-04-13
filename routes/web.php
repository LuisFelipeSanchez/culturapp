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

Route::get('/cursos/{course}', [\App\Http\Controllers\CourseController::class, 'show'])->name('cursos.show');

// RUTAS PROTEGIDAS PARA ADMINISTRADORES Y USUARIOS
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Enrollment para cursos
    Route::post('/cursos/{course}/enroll', [\App\Http\Controllers\EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::delete('/cursos/{course}/unenroll', [\App\Http\Controllers\EnrollmentController::class, 'destroy'])->name('enrollments.destroy');

    // Mis Cursos & Gestión de Profesores
    Route::get('/mis-cursos', [\App\Http\Controllers\MyCoursesController::class, 'index'])->name('my-courses.index');
    Route::get('/mis-cursos/gestion/{course}', [\App\Http\Controllers\MyCoursesController::class, 'manage'])->name('my-courses.manage');
    Route::patch('/mis-cursos/enrollments/{enrollment}/inhabilitar', [\App\Http\Controllers\MyCoursesController::class, 'disableStudent'])->name('my-courses.disable');
    Route::patch('/mis-cursos/enrollments/{enrollment}/aprobar', [\App\Http\Controllers\MyCoursesController::class, 'approveStudent'])->name('my-courses.approve');
    Route::patch('/mis-cursos/enrollments/{enrollment}/rechazar', [\App\Http\Controllers\MyCoursesController::class, 'rejectStudent'])->name('my-courses.reject');
    Route::patch('/mis-cursos/enrollments/{enrollment}/reintegrar', [\App\Http\Controllers\MyCoursesController::class, 'restoreStudent'])->name('my-courses.restore');

    // LMS Activities and SpeedGrader
    Route::post('/mis-cursos/{course}/actividades', [\App\Http\Controllers\CourseActivityController::class, 'store'])->name('activities.store');
    Route::delete('/mis-cursos/{course}/actividades/{activity}', [\App\Http\Controllers\CourseActivityController::class, 'destroy'])->name('activities.destroy');

    Route::get('/mis-cursos/{course}/actividades/{activity}/speedgrader', [\App\Http\Controllers\SpeedGraderController::class, 'show'])->name('speedgrader.show');
    Route::post('/mis-cursos/{course}/actividades/{activity}/speedgrader/grabar', [\App\Http\Controllers\SpeedGraderController::class, 'saveGrade'])->name('speedgrader.save');

    // Dashboard con datos reales
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de usuarios - Solo SuperAdmin
    Route::get('/admin/usuarios', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users.index');

    // La ruta que creamos para el Super Admin y Admins
    Route::get('/admin/manage/{sede?}', [AdminSedeController::class, 'manage'])->name('admin.manage');
    Route::get('/admin/manage/{sede}/editar', [AdminSedeController::class, 'edit'])->name('admin.manage.edit');
    Route::put('/admin/manage/{sede}', [AdminSedeController::class, 'update'])->name('admin.manage.update');

    // Cursos - CRUD para super admin 
    Route::resource('admin/cursos', CourseController::class)
        ->names('admin.cursos')
        ->parameters(['cursos' => 'course']);

    // Exportación de certificados por usuario
    Route::get('/admin/cursos/{course}/certificado/{user}', [\App\Http\Controllers\Admin\CourseController::class, 'exportCertificate'])->name('admin.cursos.certificado');

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
