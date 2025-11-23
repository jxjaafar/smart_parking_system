<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SlotController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\ServiceRatingController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// =============================================
//              PUBLIC / DEFAULT ROUTES
// =============================================

// Homepage → Landing page (the marketing page with Get Started/Sign In buttons)
Route::get('/', function () {
    return view('welcome'); // Your landing page with hero section
})->name('home');

require __DIR__.'/auth.php';

// =========================
// USER ROUTES (FRONTEND)
// =========================

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - Shows Image 1 (Quick Actions, Why Choose Smart Parking)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Slots - Shows Image 2 (Available Parking Slots listing)
    Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::get('/view-slots', [SlotController::class, 'index'])->name('view-slots'); // Alias for backward compatibility

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Book slot (requires login)
    Route::get('/slots/{id}/book', [SlotController::class, 'bookForm'])->name('user.slots.book');
    Route::post('/slots/{id}/book', [SlotController::class, 'storeBooking'])->name('user.slots.book.store');

    // Reservations
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('user.reservations.index');
    Route::post('/my-reservations/{id}/end', [ReservationController::class, 'endReservation'])->name('user.reservations.end');
    Route::post('/my-reservations/{id}/pay', [ReservationController::class, 'processPayment'])->name('user.reservations.pay');
    Route::delete('/my-reservations/{id}', [ReservationController::class, 'destroy'])->name('user.reservations.cancel');

    // Payments
    Route::resource('payments', PaymentController::class)->except(['create', 'edit']);

    // Feedback
    Route::resource('feedback', FeedbackController::class)->except(['create', 'edit']);

    // Service Ratings
    Route::resource('ratings', ServiceRatingController::class)->except(['create', 'edit']);

    // Vehicles
    Route::resource('vehicles', VehicleController::class)->except(['create', 'edit']);

    // User management (if needed)
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});


// =============================================
//          ADMIN AUTHENTICATION ROUTES 
// =============================================

// Public admin login routes
Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.submit');

// =============================================
//          PROTECTED ADMIN ROUTES 
// =============================================
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Logout
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    // Parking Slot Management
    Route::resource('parking-slots', App\Http\Controllers\Admin\ParkingSlotController::class)->names([
        'index' => 'parking-slots.index',
        'create' => 'parking-slots.create',
        'store' => 'parking-slots.store',
        'show' => 'parking-slots.show',
        'edit' => 'parking-slots.edit',
        'update' => 'parking-slots.update',
        'destroy' => 'parking-slots.destroy',
    ]);
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::delete('/users/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Reservation Management
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class)->names([
        'index' => 'admin.reservations.index',
        'show' => 'admin.reservations.show',
        'edit' => 'admin.reservations.edit',
        'update' => 'admin.reservations.update',
        'destroy' => 'admin.reservations.destroy',
    ]);
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
});