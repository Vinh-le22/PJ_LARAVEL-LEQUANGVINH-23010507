<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes cho quản lý công việc
    Route::resource('tasks', TaskController::class);
    
    // Routes cho quản lý danh mục
    Route::resource('categories', CategoryController::class);
    
    // Routes cho lịch
    Route::get('/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');
    
    // Routes cho thống kê
    Route::get('/statistics', [TaskController::class, 'statistics'])->name('tasks.statistics');
    Route::post('/tasks/{task}/update-date', [TaskController::class, 'updateDate'])->name('tasks.update-date');
});

require __DIR__.'/auth.php';
