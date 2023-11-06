<?php

use App\Http\Controllers\AuthenticatedSesionController;

use Illuminate\Support\Facades\Route;




Route::middleware(['isAuth', 'guest'])->controller(AuthenticatedSesionController::class)->group(function () {
    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'loginPost')->name('login.store');
});

Route::middleware('auth')->controller(AuthenticatedSesionController::class)->group(function() {
    Route::post('logout', 'destroy')->name('logout');
});

?>