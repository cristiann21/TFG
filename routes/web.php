<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// ==================================================
// ** RUTAS DE RESTABLECIMIENTO **
// ==================================================
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('forgot-password', 'showForgetPasswordForm')->name('password.request');
    Route::post('forgot-password', 'submitForgetPasswordForm')->name('password.email');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('reset-password', 'submitResetPasswordForm')->name('password.update');
});

// ==================================================
// ** RUTAS PÚBLICAS **
// ==================================================
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('/register', 'showRegisterForm')->name('register');
        Route::post('/register', 'register');
    });
});

// ==================================================
// ** RUTAS PROTEGIDAS **
// ==================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::controller(CourseController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses.index');
        Route::get('/courses/{course}', 'show')->name('courses.show');
    });
    
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile');
        Route::get('/my-courses', 'courses')->name('my-courses');
    });
    
    Route::controller(PurchaseController::class)->group(function () {
        Route::post('/purchase/{course}', 'store')->name('purchase.store');
    });
    
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('/subscriptions', 'index')->name('subscriptions.index');
        Route::post('/subscriptions', 'store')->name('subscriptions.store');
    });
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
