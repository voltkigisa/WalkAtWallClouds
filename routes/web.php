<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\SearchLandingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\SocialAuthController;
use App\Models\Artist;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $artists = Artist::all();
    return view('home', compact('artists'));
});

// ===== TICKET PURCHASE =====
Route::get('/ticket', [CheckoutController::class, 'index'])->name('purchase.index');
Route::get('/ticket/{ticketType}', [CheckoutController::class, 'show'])->name('purchase.show');

/*
|--------------------------------------------------------------------------
| Search Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/search', [SearchLandingController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Guest Only
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // ===== LOGIN =====
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // ===== REGISTER =====
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // ===== FORGOT PASSWORD =====
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password sudah dikirim ke email')
            : back()->withErrors(['email' => 'Email tidak terdaftar']);
    })->name('password.email');

    // ===== RESET PASSWORD =====
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password berhasil diubah')
            : back()->withErrors(['email' => 'Token tidak valid atau expired']);
    })->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // ===== CHECKOUT - Only for authenticated users =====
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin');
    
    // ===== ARTIST CRUD =====
    Route::resource('artists', ArtistController::class);
    
    // ===== EVENT CRUD =====
    Route::resource('events', EventController::class);
    
    // ===== ORDER CRUD =====
    Route::resource('orders', OrderController::class);
    
    // ===== ORDER ITEM CRUD =====
    Route::resource('order-items', OrderItemController::class);
    
    // ===== PAYMENT CRUD =====
    Route::resource('payments', PaymentController::class);
    
    // ===== TICKET CRUD =====
    Route::resource('tickets', TicketController::class);
    
    // ===== TICKET TYPE CRUD =====
    Route::resource('ticket-types', TicketTypeController::class);
});



Route::get('/auth/google', [SocialAuthController::class, 'redirectGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'callbackGoogle']);

Route::get('/auth/github', [SocialAuthController::class, 'redirectGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'callbackGithub']);
