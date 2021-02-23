<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting_page');
        Route::post('/saveUser', [SettingController::class, 'saveUser'])->name('save_user');
        Route::post('/savePassword', [SettingController::class, 'savePassword'])->name('save_password');
        Route::post('/savePhotoProfile', [SettingController::class, 'savePhotoProfile'])->name('save_photo_profile');
    });
});
