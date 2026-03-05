<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraduationPdf;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\StudentManager;
use App\Livewire\Admin\SubjectManager;
use App\Livewire\Admin\GradeManager;
use App\Livewire\Admin\SystemSettings;
use App\Livewire\Admin\AccessLogViewer;
use App\Livewire\Student\SearchResult;

// Public routes - Student Portal
Route::view('/', 'welcome')->name('home');
Route::get('cek-kelulusan', SearchResult::class)->name('student.search');
Route::get('download/{hash}', [GraduationPdf::class, 'download'])->name('graduation.download');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('students', StudentManager::class)->name('admin.students');
    Route::get('students/{student}/grades', GradeManager::class)->name('admin.grades');
    Route::get('subjects', SubjectManager::class)->name('admin.subjects');
    Route::get('settings', SystemSettings::class)->name('admin.settings');
    Route::get('logs', AccessLogViewer::class)->name('admin.logs');
});

// Redirect old dashboard to admin dashboard
Route::middleware(['auth'])->group(function () {
    Route::redirect('dashboard', '/admin/dashboard');
});

require __DIR__ . '/settings.php';
