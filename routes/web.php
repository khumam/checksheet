<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
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
        Route::get('/', [SettingController::class, 'index'])->name('setting_page');
        Route::post('/saveUser', [SettingController::class, 'saveUser'])->name('save_user');
        Route::post('/savePassword', [SettingController::class, 'savePassword'])->name('save_password');
        Route::post('/savePhotoProfile', [SettingController::class, 'savePhotoProfile'])->name('save_photo_profile');
    });

    Route::prefix('admin')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin_user_page');
            Route::post('detail', [UserController::class, 'detail'])->name('admin_user_detail');
            Route::post('list', [UserController::class, 'list'])->name('admin_user_list');
            Route::post('update', [UserController::class, 'update'])->name('admin_user_update');
            Route::delete('delete', [UserController::class, 'delete'])->name('admin_user_delete');
        });
    });
});
