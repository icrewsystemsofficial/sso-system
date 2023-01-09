<?php

use Icrewsystems\SsoLogin\Http\Controllers\SsoLoginController;
use Illuminate\Support\Facades\Route;


Route::get('callback', [SsoLoginController::class, 'sso_callback'])->name('sso.callback');
Route::get('login', [SsoLoginController::class, 'sso_login'])->name('sso.login');
