<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Auth::routes([
//     'login' => true,
//     'logout' => true,
//     'register' => true,
//     'reset' => true, // for resetting passwords
//     'confirm' => false, // for additional password confirmations
//     'verify' => false, // for email verification
// ]);


Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::controller(AuthController::class)->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/password', 'passwordCreate')->name('forgot.password');
    Route::post('/password/reset', 'passwordReset')->name('password.reset');
});

Route::get('/send-email', function () {
    $details = [
        'title' => 'Test Email',
        'body' => 'This is a test email sent from Laravel using Gmail SMTP.'
    ];

    Mail::to('saikathosen444@gmail.com')->send(new TestEmail($details));

    return 'Email sent successfully!';
});

Route::middleware(['auth', 'user.status'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');



    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


