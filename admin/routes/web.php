<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GraphicController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() && auth()->user()->is_admin
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/api/site', SiteController::class)->name('api.site');
Route::post('/api/contact', [ContactMessageController::class, 'store'])->name('api.contact');

Route::middleware(['auth', 'admin'])->prefix('panel')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('sections/{section}', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update');

    Route::redirect('content', '/panel/sections')->name('content.index');
    Route::redirect('settings', '/panel/sections')->name('settings.edit');

    Route::get('content/{group}', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('content/{group}', [ContentController::class, 'update'])->name('content.update');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('graphics', GraphicController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::resource('partners', PartnerController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);

    Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
