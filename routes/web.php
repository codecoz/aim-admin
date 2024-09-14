<?php

use CodeCoz\AimAdmin\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;
use CodeCoz\AimAdmin\Http\Controllers\Auth\LoginController;

Route::group(['middleware' => config('aim-admin.middleware', ['guest', 'web'])], function () {
    Route::get(config('aim-admin.auth.url', 'login'), [config('aim-admin.auth.controller', LoginController::class), 'login'])->name('login');
    Route::post(config('aim-admin.auth.url', 'login'), [config('aim-admin.auth.controller', LoginController::class), 'authenticate']);

    Route::get('forget-password', [LoginController::class, 'passwordReset'])->name('forget.password');
    Route::get('password/reset/{token}', [LoginController::class, 'passwordReset'])->name('password.reset');
    Route::post('password/reset', [LoginController::class, 'reset'])->name('password.reset.update');

    Route::get('registration', [config('aim-admin.registration.controller', RegistrationController::class), 'registration'])->name('registration');
    Route::post('registration', [config('aim-admin.registration.controller', RegistrationController::class), 'register']);
    Route::get(config('aim-admin.auth.logout_url', 'logout'), [config('aim-admin.auth.controller', LoginController::class), 'logout'])
        ->name('logout');
});
