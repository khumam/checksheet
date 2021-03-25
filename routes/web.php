<?php

use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\ServerBag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'welcome']);

Auth::routes();

Route::prefix('resetpassword')->group(function () {
    Route::get('/confirm', [ResetPasswordController::class, 'confirm'])->name('reset_password_confirm');
    Route::post('/send', [ResetPasswordController::class, 'send'])->name('reset_password_send');
    Route::post('/reset', [ResetPasswordController::class, 'changePassword'])->name('reset_password');
    Route::get('/{token}', [ResetPasswordController::class, 'index'])->where('token', '(.*)')->name('reset_password_page');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting_page');
        Route::post('/saveUser', [SettingController::class, 'saveUser'])->name('save_user');
        Route::post('/savePassword', [SettingController::class, 'savePassword'])->name('save_password');
        Route::post('/savePhotoProfile', [SettingController::class, 'savePhotoProfile'])->name('save_photo_profile');
    });

    Route::prefix('admin')->group(function () {
        Route::resource('user', UserController::class)->only(['index', 'show', 'destroy']);
        Route::post('list', [UserController::class, 'list'])->name('admin_user_list');

    });
});
