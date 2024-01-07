<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

// Test Route
Route::get('/test', function(){
    function generateRandomCode() {
        $validDigits = [7, 6, 5, 3]; // Define valid digits
        $code = '';
    
        for ($i = 0; $i < 4; $i++) {
            $code .= $validDigits[array_rand($validDigits)]; // Append a random valid digit
        }
    
        return $code;
    }
    
    $randomCode = generateRandomCode();
    return $randomCode; // Output the generated random 4-digit code containing only 7, 6, 5, and 3
    
});

Route::get('/link', function () {
    Artisan::call('storage:link');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
})->name('clear.cache');

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

    Route::controller(UserController::class)->group(function(){
        Route::get('/user/create', 'create')->name('user.create');
    });


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


