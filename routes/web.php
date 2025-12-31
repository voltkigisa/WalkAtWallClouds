<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\GuestRedirectController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\SocialAuthController;
use App\Models\Artist;
use App\Models\Event;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\DownloadPDFController;
use App\Http\Controllers\Admin\SearchDashboardController;


/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $artists = Artist::all();
    $event = Event::where('status', 'published')->with('artists')->first();
    $ticketTypes = $event ? $event->ticketTypes()->orderBy('price')->get() : collect();
    return view('home', compact('artists', 'event', 'ticketTypes'));
});

// ===== ARTIST LINE-UP =====

//admin
Route::get('/artist/{artist}', [ArtistController::class, 'showPublic'])->name('artist.show');

//landingpage 
Route::get('/guest/artist/{artist}', [GuestRedirectController::class, 'redirectToArtist'])->name('guest.artist');

// ===== EVENT LIST WITH FILTER (Public) =====
Route::get('/event-list', [EventListController::class, 'index'])->name('events.list');

// ===== TICKET PURCHASE =====
Route::get('/ticket', [CheckoutController::class, 'index'])->name('purchase.index');
Route::get('/ticket/{ticketType}', [CheckoutController::class, 'show'])->name('purchase.show');

// ===== CART =====
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{itemId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// ===== CHECKOUT (Requires Auth) =====
use App\Http\Controllers\MyTicketController;
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    
    // My Tickets
    Route::get('/my-tickets', [MyTicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/my-tickets/{order}', [MyTicketController::class, 'show'])->name('my-tickets.show');
});

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

    // ===== CHECKOUT =====
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/downloadpdf', [DownloadPDFController::class, 'downloadpdf'])->name('downloadpdf');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin');

    //  LIVE SEARCH DASHBOARD (AJAX)
    Route::get('/admin/search', [SearchDashboardController::class, 'index'])
        ->name('admin.search');

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

    // ===== USER MANAGEMENT (Admin only) =====
    Route::resource('users', UserController::class)->except(['edit', 'update', 'show']);
});

// User Profile - accessible by authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

/*
|--------------------------------------------------------------------------
| Social Auth
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [SocialAuthController::class, 'redirectGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'callbackGoogle']);

Route::get('/auth/github', [SocialAuthController::class, 'redirectGithub']);
Route::get('/auth/github/callback', [SocialAuthController::class, 'callbackGithub']);

// ===== GOOGLE CALENDAR INTEGRATION =====
Route::middleware(['auth'])->group(function () {
    // Google Calendar OAuth
    Route::get('/auth/google-calendar', [GoogleCalendarController::class, 'redirectToGoogle'])
        ->name('google-calendar.auth');
    Route::get('/auth/google-calendar/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])
        ->name('google-calendar.callback');
    
    // Add event to calendar
    Route::post('/calendar/add-event', [GoogleCalendarController::class, 'addEventToCalendar'])
        ->name('calendar.add-event');
    
    // Disconnect
    Route::post('/calendar/disconnect', [GoogleCalendarController::class, 'disconnect'])
        ->name('calendar.disconnect');
});


// ===== PAYMENT ROUTES =====

Route::middleware(['auth'])->group(function () {
    // Payment routes
    Route::get('/payment/{order}', [PaymentController::class, 'createPayment'])
        ->name('payment.create');
    Route::get('/payment/finish', [PaymentController::class, 'finish'])
        ->name('payment.finish');
    Route::post('/payment/check-status/{order}', [PaymentController::class, 'checkStatus'])
        ->name('payment.check-status');
});

// Webhook untuk Midtrans notification (TANPA AUTH!)
Route::post('/payment/notification', [PaymentController::class, 'notification'])
    ->name('payment.notification');

   Route::get('/my-tickets/{id}/download', [TicketController::class, 'downloadPdf'])
    ->name('my-tickets.download')
    ->middleware('auth');