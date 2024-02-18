<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;

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

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Storage Link Successfully';
});

Route::get('/clear', function(){
    Artisan::call('optimize:clear');
    return 'Optimize Clear!.';
})->name('clear');

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

Route::controller(TestController::class)->group(function() {
    Route::post('/language', 'languageUpdate')->name('language');
});


Route::controller(AuthController::class)->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/password', 'passwordCreate')->name('forgot.password');
    Route::get('/send/mail', 'sendOtpMail')->name('send.mail');
    Route::get('/otp/{email}/{code}', 'otpForm')->name('otp');
    Route::post('/otp/store', 'otpStore')->name('otp.store');
    Route::get('/update/password', 'editPassword')->name('update.password');
    Route::post('edit/password', 'updatePassword')->name('password.edit');
    Route::post('/password/reset', 'passwordReset')->name('password.reset');
});

Route::middleware(['auth', 'user.status'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::controller(UserController::class)->group(function(){
        Route::get('/user/create', 'create')->name('user.create');
        Route::post('/user/store', 'store')->name('user.store');
        Route::get('/user/detail/{id}', 'userDetails')->name('user.detail');
    });

    Route::controller(RoleController::class)->group(function(){
        Route::get('/role/list', 'index')->name('role.list');
        Route::get('/permission/list', 'permissionIndex')->name('permission.list');
        Route::get('/create/role', 'create')->name('role.create');
        Route::post('/role/store', 'store')->name('role.store');
        Route::get('/role/edit/{id}', 'edit')->name('role.edit');
        Route::post('/role/update', 'update')->name('role.update');
        Route::get('/get-permissions/{id}', 'getPermissions')->name('get.permissions');
        Route::get('/role/delete/{id}', 'destroy');
    });


    Route::controller(SettingController::class)->group(function(){
        Route::get('/setting', 'create')->name('setting.store');
    });


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});