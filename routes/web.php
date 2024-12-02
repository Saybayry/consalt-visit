<?php

use App\Http\Controllers\Api\GroupController;
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
Route::get('/api/groups', [GroupController::class, 'index'])->middleware(['auth'])->name('api.disciplines');; // Получить все группы
Route::get('/api/groups/{id}', [GroupController::class, 'show'])->middleware(['auth'])->name('api.disciplines');; // Получить группу по ID
Route::post('/api/groups', [GroupController::class, 'store'])->middleware(['auth'])->name('api.disciplines');; // Создать новую группу
Route::put('/api/groups/{id}', [GroupController::class, 'update'])->middleware(['auth'])->name('api.disciplines');; // Обновить группу
Route::delete('/api/groups/{id}', [GroupController::class, 'destroy'])->middleware(['auth'])->name('api.disciplines'); // Удалить группу

require __DIR__.'/auth.php';
