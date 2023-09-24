<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagedController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->middleware(['auth', 'verified', 'isAdmin'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::put('/dashboard/{personalInformation}', [AdminController::class, 'approved'])->name('admin.approved');
    Route::delete('/dashboard/{personalInformation}', [AdminController::class, 'delete'])->name('admin.delete');
});

Route::prefix('/user')->middleware(['auth', 'verified', 'isUser'])->group(function() {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    Route::resource('personalInformation', PersonalInformationController::class)->only([
        'index', 'create', 'store', 'destroy', 'edit', 'update',
    ]);
});

Route::redirect('/', '/login');

require __DIR__.'/auth.php';
?>