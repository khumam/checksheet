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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/saveUser', [SettingController::class, 'saveUser'])->name('setting.save.user');
        Route::post('/savePassword', [SettingController::class, 'savePassword'])->name('setting.save.password');
        Route::post('/savePhotoProfile', [SettingController::class, 'savePhotoProfile'])->name('setting.save.photo.profile');
    });

    Route::prefix('admin')->group(function () {
        Route::resource('user', UserController::class)->only(['index', 'show', 'destroy']);
        Route::post('list', [UserController::class, 'list'])->name('admin.admin.user.list');
    });
});
