<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
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

    Route::prefix('item')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('item_page');
        Route::get('/list', [ItemController::class, 'list'])->name('item_list');
        Route::post('store', [ItemController::class, 'store'])->name('item_store');
        Route::post('update', [ItemController::class, 'update'])->name('item_update');
        Route::delete('delete', [ItemController::class, 'delete'])->name('item_delete');
        Route::get('{id}/detail', [ItemController::class, 'show'])->name('item_show');
    });

    Route::prefix('stock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('stock_page');
        Route::get('/list', [StockController::class, 'list'])->name('stock_list');
        Route::post('store', [StockController::class, 'store'])->name('stock_store');
        Route::post('update', [StockController::class, 'update'])->name('stock_update');
        Route::delete('delete', [StockController::class, 'delete'])->name('stock_delete');
    });
});
