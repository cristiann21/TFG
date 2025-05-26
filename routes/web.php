<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeacherRequestController;
use App\Http\Controllers\CartController;

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
// ** RUTAS DE PÁGINAS ESTÁTICAS **
// ==================================================
Route::controller(PageController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/terms', 'terms')->name('terms');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});

// ==================================================
// ** RUTAS PROTEGIDAS **
// ==================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::controller(CourseController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses.index');
        Route::get('/courses/{course}', 'show')->name('courses.show');
        Route::get('/courses/create', 'create')->name('courses.create');
        Route::post('/courses', 'store')->name('courses.store');
        Route::get('/courses/{course}/edit', 'edit')->name('courses.edit');
        Route::put('/courses/{course}', 'update')->name('courses.update');
        Route::delete('/courses/{course}', 'destroy')->name('courses.destroy');
    });
    
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/my-courses', 'courses')->name('my-courses');
    });
    
    Route::controller(PurchaseController::class)->group(function () {
        Route::post('/purchase/{course}', 'store')->name('purchase.store');
    });
    
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('/subscriptions', 'index')->name('subscriptions.index');
        Route::post('/subscriptions', 'store')->name('subscriptions.store');
    });
    
    Route::get('/teacher-request', [TeacherRequestController::class, 'show'])->name('teacher-request.show');
    Route::post('/teacher-request', [TeacherRequestController::class, 'store'])->name('teacher-request.store');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas del carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{course}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});
