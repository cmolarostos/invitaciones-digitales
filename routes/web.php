<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventPhotoController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RsvpController;
use App\Models\Template;
use Illuminate\Support\Facades\Route;

// ─── Autenticación ────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);

    Route::get('/forgot-password',  [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',        [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Catálogo público ────────────────────────────────────────────────────────

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogo/{slug}', [CatalogController::class, 'byType'])->name('catalog.by-type');

// ─── Invitación pública ───────────────────────────────────────────────────────

Route::get('/i/{slug}', [InvitationController::class, 'show'])->name('invitation.show');

// ─── RSVP (sin autenticación) ─────────────────────────────────────────────────

Route::prefix('rsvp')->name('rsvp.')->group(function () {
    Route::get('/{token}',         [RsvpController::class, 'show'])->name('show');
    Route::post('/{token}',        [RsvpController::class, 'confirm'])->name('confirm');
    Route::get('/{token}/gracias', [RsvpController::class, 'thankyou'])->name('thankyou');
});

// ─── Panel del usuario (requiere autenticación) ───────────────────────────────

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Wizard nuevo evento
    Route::get('events/select-type',                  [EventController::class, 'create'])->name('events.create');
    Route::get('events/select-template',              [EventController::class, 'selectTemplate'])->name('events.select-template');
    Route::get('events/new/{template}',               [EventController::class, 'createWithTemplate'])->name('events.create-with-template');

    // Eventos (sin create porque lo reemplazamos arriba)
    Route::resource('events', EventController::class)->except('create');
    Route::post('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::post('events/{id}/restore',    [EventController::class, 'restore'])->name('events.restore')->withTrashed();

    // Invitados (anidado bajo evento)
    Route::prefix('events/{event}/guests')->name('events.guests.')->group(function () {
        Route::get('/',           [GuestController::class, 'index'])->name('index');
        Route::post('/',          [GuestController::class, 'store'])->name('store');
        Route::put('/{guest}',    [GuestController::class, 'update'])->name('update');
        Route::delete('/{guest}', [GuestController::class, 'destroy'])->name('destroy');
        Route::post('/import',    [GuestController::class, 'import'])->name('import');
    });

    // Fotos (anidado bajo evento)
    Route::prefix('events/{event}/photos')->name('events.photos.')->group(function () {
        Route::post('/',              [EventPhotoController::class, 'store'])->name('store');
        Route::post('/reorder',       [EventPhotoController::class, 'reorder'])->name('reorder');
        Route::post('/{photo}/cover', [EventPhotoController::class, 'setCover'])->name('cover');
        Route::delete('/{photo}',     [EventPhotoController::class, 'destroy'])->name('destroy');
    });
});
