<?php

use App\Http\Controllers\CheckSheetController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\LossController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
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
        Route::get('/', [UserSettingController::class, 'index'])->name('user.setting.index');
        Route::post('/saveUser', [UserSettingController::class, 'saveUser'])->name('user.setting.save.user');
        Route::post('/savePassword', [UserSettingController::class, 'savePassword'])->name('user.setting.save.password');
        Route::post('/saveProfilePicture', [UserSettingController::class, 'saveProfilePicture'])->name('user.setting.save.profile.picture');
    });

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::resource('user', UserController::class)->only(['index', 'show', 'destroy', 'edit']);
        Route::post('user/list', [UserController::class, 'list'])->name('user.list');

        Route::resource('equipment', EquipmentController::class);
        Route::post('equipment/list', [EquipmentController::class, 'list'])->name('equipment.list');

        Route::resource('checksheet', CheckSheetController::class);
        Route::post('checksheet/list', [CheckSheetController::class, 'list'])->name('checksheet.list');
        Route::post('checksheet/updatetimerow', [CheckSheetController::class, 'updateTimeRow'])->name('checksheet.updatetimerow');
        Route::post('checksheet/updateketerangan', [CheckSheetController::class, 'updateKeterangan'])->name('checksheet.updateketerangan');
        Route::get('checksheet/{id}/upload', [CheckSheetController::class, 'uploadPage'])->name('checksheet.uploadpage');
        Route::post('checksheet/{id}/upload', [CheckSheetController::class, 'upload'])->name('checksheet.upload');
        Route::post('checksheet/{id}/list', [CheckSheetController::class, 'listPhoto'])->name('checksheet.photo.list');
        Route::delete('checksheet/{id}/photo/destroy', [CheckSheetController::class, 'destroyPhoto'])->name('checksheet.destroy.photo');

        Route::resource('grading', GradingController::class)->except('index');
        Route::get('grading/{year?}/{month?}', [GradingController::class, 'index'])->name('grading.index');
        Route::post('grading/list', [GradingController::class, 'list'])->name('grading.list');

        Route::resource('loss', LossController::class);
        Route::post('loss/list', [LossController::class, 'list'])->name('loss.list');
        Route::post('loss/updaterow', [LossController::class, 'updateRow'])->name('loss.updaterow');
    });
});
