<?php

use CodeCoz\AimAdmin\Http\Controllers\Auth\RegistrationController;
use Illuminate\Support\Facades\Route;
use CodeCoz\AimAdmin\Http\Controllers\Auth\LoginController;
use CodeCoz\AimAdmin\Http\Controllers\MenuController;
use CodeCoz\AimAdmin\Http\Controllers\PermissionController;
use CodeCoz\AimAdmin\Http\Controllers\RoleController;
use CodeCoz\AimAdmin\Http\Controllers\TinyMceFileController;
use CodeCoz\AimAdmin\Http\Controllers\UserController;
use CodeCoz\AimAdmin\Http\Middleware\ForcePasswordChange;

Route::group(['middleware' => config('aim-admin.middleware', ['guest', 'web'])], function () {

    Route::get(config('aim-admin.auth.url', 'login'), [config('aim-admin.auth.controller', LoginController::class), 'login'])->name('login');
    Route::post(config('aim-admin.auth.url', 'login'), [config('aim-admin.auth.controller', LoginController::class), 'authenticate']);

    Route::get('forget-password', [LoginController::class, 'passwordReset'])->name('forget.password');
    Route::get('password/reset/{token}', [LoginController::class, 'passwordReset'])->name('password.reset');
    Route::post('password/reset', [LoginController::class, 'reset'])->name('password.reset.update');

    Route::get('registration', [config('aim-admin.registration.controller', RegistrationController::class), 'registration'])->name('registration');
    Route::post('registration', [config('aim-admin.registration.controller', RegistrationController::class), 'register']);

});

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::prefix('users')->group(function () {
        Route::get("/", [UserController::class, 'user'])->name('user_list')->middleware('acl:users');
        Route::get("/show/{id}", [UserController::class, 'show'])->name('user_detail')->middleware('acl:users');
        Route::get("/create", [UserController::class, 'create'])->name('user_create')->middleware('acl:users-create');
        Route::post("/save", [UserController::class, 'store'])->name('user_store')->middleware('acl:users-create');
        Route::get("/edit/{id}", [UserController::class, 'edit'])->name('user_edit')->middleware('acl:users-update');
        Route::post("/update", [UserController::class, 'update'])->name('user_update')->middleware('acl:users-update');
        Route::get("/delete/{id}", [UserController::class, 'delete'])->name('user_delete')->middleware('acl:users-delete');
    });

    Route::prefix('menu')->group(function () {
        Route::get("/", [MenuController::class, 'menu'])->name('menu_list')->middleware('acl:menu');
        Route::get("/show/{id}", [MenuController::class, 'show'])->name('menu_detail')->middleware('acl:menu');
        Route::get("/edit/{id}", [MenuController::class, 'edit'])->name('menu_edit')->middleware('acl:menu-update');
        Route::get("/create", [MenuController::class, 'create'])->name('menu_create')->middleware('acl:menu-create');
        Route::post("/save", [MenuController::class, 'store'])->name('menu_store')->middleware('acl:menu-create');
        Route::post("/update", [MenuController::class, 'update'])->name('menu_update')->middleware('acl:menu-update');
        Route::post("/delete/{id}", [MenuController::class, 'delete'])->name('menu_delete')->middleware('acl:menu-delete');
    });

    Route::prefix('permission')->group(function () {
        Route::get("/", [PermissionController::class, 'permission'])->name('permission_list')->middleware('acl:permission');
        Route::get("/show/{id}", [PermissionController::class, 'show'])->name('permission_detail')->middleware('acl:permission');
        Route::get("/edit/{id}", [PermissionController::class, 'edit'])->name('permission_edit')->middleware('acl:permission-update');
        Route::get("/create", [PermissionController::class, 'create'])->name('permission_create')->middleware('acl:permission-create');
        Route::post("/save", [PermissionController::class, 'store'])->name('permission_store')->middleware('acl:permission-create');
        Route::post("/update", [PermissionController::class, 'update'])->name('permission_update')->middleware('acl:permission-create');
        Route::get("/delete/{id}", [PermissionController::class, 'delete'])->name('permission_delete')->middleware('acl:permission-delete');
    });

    Route::prefix('role')->group(function () {
        Route::get("/", [RoleController::class, 'role'])->name('role_list')->middleware('acl:role');
        Route::get("/show/{id}", [RoleController::class, 'show'])->name('role_detail')->middleware('acl:role');
        Route::get("/create", [RoleController::class, 'create'])->name('role_create')->middleware('acl:role-create');
        Route::get("/edit/{id}", [RoleController::class, 'edit'])->name('role_edit')->middleware('acl:role-update');
        Route::get("/edit-menu-permission/{id}", [RoleController::class, 'menuPermissionEdit'])->name('role_edit_menu_permission')->middleware('acl:role-update');
        Route::get("/edit-role-permission/{id}", [RoleController::class, 'rolePermissionEdit'])->name('role_edit_role_permission')->middleware('acl:role-update');
        Route::get("/edit/{id}", [RoleController::class, 'edit'])->name('role_edit')->middleware('acl:role-update');
        Route::post("/save", [RoleController::class, 'store'])->name('role_store')->middleware('acl:role-create');
        Route::post("/update", [RoleController::class, 'update'])->name('role_update')->middleware('acl:role-update');
        Route::get("/delete/{id}", [RoleController::class, 'delete'])->name('role_delete')->middleware('acl:role-delete');
    });

    Route::prefix('profile')->group(function () {
        Route::get("password/change", [UserController::class, 'passwordChange'])->name('password.change');
        Route::post("password/update", [UserController::class, 'passwordUpdate'])->name('password.update')
            ->withoutMiddleware([ForcePasswordChange::class]);
    });

    Route::post("/editor-file-upload", [TinyMceFileController::class, 'fileUpload'])->name('editor.file.upload');
    Route::get(config('aim-admin.auth.logout_url', 'logout'), [config('aim-admin.auth.controller', LoginController::class), 'logout'])
        ->name('logout');

});
