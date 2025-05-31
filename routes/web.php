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
use App\Http\Controllers\StripeController;
use App\Http\Controllers\QuizController;

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
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
});

// ==================================================
// ** RUTAS PROTEGIDAS **
// ==================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/profile/courses', [ProfileController::class, 'courses'])->name('profile.courses');
    Route::get('/profile/enrolled-courses', [ProfileController::class, 'enrolledCourses'])->name('profile.enrolled-courses');
    
    Route::middleware('teacher')->group(function () {
        Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    });

    Route::controller(CourseController::class)->group(function () {
        Route::get('/courses', 'index')->name('courses.index');
        Route::get('/courses/{course}', 'show')->name('courses.show');
        Route::post('/courses/{course}/obtain', 'obtain')->name('courses.obtain');
        Route::post('/courses/{course}/addToFavorites', 'addToFavorites')->name('courses.addToFavorites');
        Route::post('/courses/{course}/removeFromFavorites', 'removeFromFavorites')->name('courses.removeFromFavorites');
        Route::get('/courses/create', 'create')->name('courses.create');
        Route::post('/courses', 'store')->name('courses.store');
        Route::get('/courses/{course}/edit', 'edit')->name('courses.edit');
        Route::put('/courses/{course}', 'update')->name('courses.update');
        Route::delete('/courses/{course}', 'destroy')->name('courses.destroy');
    });
    
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::put('/profile', 'update')->name('profile.update');
        Route::get('/profile/courses', 'courses')->name('profile.courses');
        Route::get('/profile/enrolled-courses', 'enrolledCourses')->name('profile.enrolled-courses');
    });
    
    Route::controller(PurchaseController::class)->group(function () {
        Route::post('/purchase/{course}', 'store')->name('purchase.store');
    });
    
    Route::controller(SubscriptionController::class)->group(function () {
        Route::get('/subscriptions', 'index')->name('subscriptions.index');
        Route::post('/subscriptions', 'store')->name('subscriptions.store');
        Route::post('/subscriptions/subscribe', 'subscribe')->name('subscriptions.subscribe');
        Route::post('/subscriptions/cancel', 'cancel')->name('subscriptions.cancel');
        Route::post('/subscriptions/upgrade', [SubscriptionController::class, 'upgrade'])->name('subscriptions.upgrade');
        Route::post('/subscriptions/downgrade', [SubscriptionController::class, 'downgrade'])->name('subscriptions.downgrade');
    });
    
    Route::get('/teacher-request', [TeacherRequestController::class, 'show'])->name('teacher-request.show');
    Route::post('/teacher-request', [TeacherRequestController::class, 'store'])->name('teacher-request.store');
    Route::get('/teacher-request/{teacherRequest}/approve', [TeacherRequestController::class, 'approve'])->name('teacher-request.approve');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas del carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{course}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/success', [CartController::class, 'success'])->name('cart.success');
    Route::get('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Rutas de Stripe
    Route::get('/stripe/checkout/{course}', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success/{course}', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

    // Rutas del test
    Route::get('/courses/{course}/quiz', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/courses/{course}/quiz', [QuizController::class, 'submit'])->name('quiz.submit');

    // Rutas para tests
    Route::get('/courses/{course}/quiz/create', [QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/courses/{course}/quiz', [QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/courses/{course}/quiz/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::post('/courses/{course}/quiz/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
});

Route::get('/practica-html', function() {
    return view('practica-html');
});
