<?php

use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\ConsultationRegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/consalt', function () {
    return Inertia::render('Consalt');
})->middleware(['auth', 'verified'])->name('consalt');

Route::get('/consalt/{id}', function ($id) {
    return Inertia::render('ConsaltPage', [
        'consultationId' => $id, // Передаем id как пропс
    ]);
})->middleware(['auth', 'verified']);


Route::get('/teacher', function () {
    return Inertia::render('Teacher');
})->middleware(['auth', 'verified'])->name('teacher');


Route::get('/student-groups', function () {
    return Inertia::render('StudentGroups');
})->middleware(['auth', 'verified'])->name('student-groups');


Route::get('/disciplines', function () {
    return Inertia::render('Disciplines');
})->middleware(['auth', 'verified'])->name('disciplines');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// консультации
Route::get('/api/consultationswithregistration', [ConsultationController::class, 'showWithRegistrations'])->middleware(['auth'])->name('api.consultationswithregistration');; // Получить все группы


Route::post('/api/consultations', [ConsultationController::class, 'store'])->middleware(['auth'])->name('api.consultations');; // Получить все группы

Route::get('/api/consultations', [ConsultationController::class, 'index'])->middleware(['auth'])->name('api.consultations');; // Получить все группы
Route::get('/api/consultations/{id}', [ConsultationController::class, 'show'])->middleware(['auth'])->name('api.consultations.show');; // Получить группу по ID
Route::put('/api/consultations/{id}', [ConsultationController::class, 'update'])->middleware(['auth'])->name('api.consultations.update');; // Обновить группу
Route::delete('/api/consultations/{id}', [ConsultationController::class, 'destroy'])->middleware(['auth'])->name('api.consultations.destroy');



// Route::middleware(['auth'])->group(function () {
//     Route::post('/api/consultation_registrations', [ConsultationController::class, 'store'])->name('api.consultation_registrations'); // Создать новую записть на конс
//     Route::get('/api/consultation_registrations', [ConsultationController::class, 'index'])->name('api.consultation_registrations.index');
//     Route::get('/api/consultation_registrations/{id}', [ConsultationController::class, 'show'])->name('api.consultation_registrations.show');
//     Route::put('/api/consultation_registrations/{id}', [ConsultationController::class, 'update'])->name('api.consultation_registrations.update');
//     Route::delete('/api/consultation_registrations/{id}', [ConsultationController::class, 'destroy'])->name('api.consultation_registrations.destroy');
    
// });

// Консультации
Route::get('/api/visitings/{id}', [ConsultationRegistrationController::class, 'showByConsalt'])->middleware(['auth'])->name('api.visiting.showByConsalt');

Route::post('/api/visiting', [ConsultationRegistrationController::class, 'store'])->middleware([])->name('api.visiting');; // Создать новую группу
Route::get('/api/visiting', [ConsultationRegistrationController::class, 'index'])->middleware(['auth'])->name('api.visiting.index');
Route::get('/api/visiting/{id}', [ConsultationRegistrationController::class, 'show'])->middleware(['auth'])->name('api.visiting.show');
Route::put('/api/visiting/{id}', [ConsultationRegistrationController::class, 'update'])->middleware(['auth'])->name('api.visiting.update');
Route::delete('/api/visiting/{id}', [ConsultationRegistrationController::class, 'destroy'])->middleware(['auth'])->name('api.visiting.destroy');



// группы
Route::get('/api/groups', [GroupController::class, 'index'])->middleware(middleware: ['auth'])->name('api.disciplines');; // Получить все группы
Route::get('/api/groups/{id}', [GroupController::class, 'show'])->middleware(['auth'])->name('api.disciplines');; // Получить группу по ID

Route::post('/api/groups', [GroupController::class, 'store'])->middleware(['auth','admin'])->name('api.disciplines');; // Создать новую группу
Route::put('/api/groups/{id}', [GroupController::class, 'update'])->middleware(['auth','admin'])->name('api.disciplines');; // Обновить группу
Route::delete('/api/groups/{id}', [GroupController::class, 'destroy'])->middleware(['auth','admin'])->name('api.disciplines'); // Удалить группу
// учителя
Route::get('/api/teachers', [TeacherController::class, 'index'])->middleware(['auth'])->name('api.teachers');; // Получить все группы
Route::get('/api/teachers/{id}', [TeacherController::class, 'show'])->middleware(['auth'])->name('api.teachers');; // Получить группу по ID

Route::post('/api/teachers', [TeacherController::class, 'store'])->middleware(['auth','admin'])->name('api.teachers');; // Создать новую группу
Route::put('/api/teachers/{id}', [TeacherController::class, 'update'])->middleware(['auth','admin'])->name('api.teachers');; // Обновить группу
Route::delete('/api/teachers/{id}', [TeacherController::class, 'destroy'])->middleware(['auth','admin'])->name('api.teachers'); // Удалить группу


require __DIR__.'/auth.php';
