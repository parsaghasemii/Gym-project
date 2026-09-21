<?php

use App\Http\Controllers\Admin\ExerciseController as AdminExerciseController;
use App\Http\Controllers\Admin\MealController as AdminMealController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FitnessProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth', 'onboarding.incomplete'])->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('/step-1', [OnboardingController::class, 'step1'])->name('step1');
    Route::post('/step-1', [OnboardingController::class, 'storeStep1'])->name('step1.store');
    Route::get('/step-2', [OnboardingController::class, 'step2'])->name('step2');
    Route::post('/step-2', [OnboardingController::class, 'storeStep2'])->name('step2.store');
    Route::get('/step-3', [OnboardingController::class, 'step3'])->name('step3');
    Route::post('/step-3', [OnboardingController::class, 'storeStep3'])->name('step3.store');
    Route::get('/step-4', [OnboardingController::class, 'step4'])->name('step4');
    Route::post('/step-4', [OnboardingController::class, 'storeStep4'])->name('step4.store');
});

Route::middleware(['auth', 'onboarding.completed'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/program', [ProgramController::class, 'show'])->name('program.show');
    Route::post('/program/regenerate', [ProgramController::class, 'regenerate'])->name('program.regenerate');
    Route::get('/fitness-profile', [FitnessProfileController::class, 'edit'])->name('fitness-profile.edit');
    Route::patch('/fitness-profile', [FitnessProfileController::class, 'update'])->name('fitness-profile.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/exercises');
    Route::resource('exercises', AdminExerciseController::class)->except(['show']);
    Route::get('meals', [AdminMealController::class, 'index'])->name('meals.index');
    Route::get('members', [AdminMemberController::class, 'index'])->name('members.index');
    Route::get('members/create', [AdminMemberController::class, 'create'])->name('members.create');
    Route::post('members', [AdminMemberController::class, 'store'])->name('members.store');
});

require __DIR__.'/auth.php';
