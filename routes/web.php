<?php

use App\Http\Controllers\PersonnelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LiveStockInformationController;
use App\Http\Controllers\MachineryInformationController;
use App\Http\Controllers\PersonalInformationController;

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
    Route::get('/dashboard',[AdminController:: class, 'index'])->name('admin.dashboard');
    Route::get('/farmers', [AdminController::class, 'farmer'])->name('admin.farmer');
    Route::get('/farmers/details/{personalInformation}/{currentRoute}', [AdminController::class, 'farmerDetails'])->name('admin.farmerDetails');
    Route::get('/location', [AdminController::class, 'location'])->name('admin.location');
    Route::get('/location/map', [AdminController::class, 'mapLocation'])->name('admin.map');
    Route::put('/dashboard/{personalInformation}', [AdminController::class, 'approved'])->name('admin.approved');
    Route::delete('/dashboard/{personalInformation}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::resource('personnel', PersonnelController::class)->only(['index','destroy','store','update']);
    Route::put('personnel', [PersonnelController::class,'edit'])->name('personnel.edit');


    Route::delete('/liveStockInformation/{livestock}', [LiveStockInformationController::class, 'destroy'])->name('liveStockInformation.destroy');
    Route::delete('/machineryInformation/{machinery}', [MachineryInformationController::class, 'destroy'])->name('machineryInformation.destroy');
});


Route::prefix('/user')->middleware(['auth', 'verified', 'isUser'])->group(function() {
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/managedFarmers/details/{personalInformation}/{currentRoute}', [UserController::class, 'managedFarmerDetails'])->name('user.managedFarmersDetails');
    
    Route::resource('personalInformation', PersonalInformationController::class)->only([
        'index', 'create', 'store', 'destroy', 'edit', 'update',
    ]);

    Route::get('/liveStockInformation/{personalInformation}', [LiveStockInformationController::class, 'index'])->name('liveStockInformation.index');
    Route::post('/liveStockInformation/{personalInformation}', [LiveStockInformationController::class, 'store'])->name('liveStockInformation.store');

    Route::get('/machineryInformation/{personalInformation}', [MachineryInformationController::class, 'index'])->name('machineryInformation.index');
    Route::post('/machineryInformation/{personalInformation}', [MachineryInformationController::class, 'store'])->name('machineryInformation.store');
});


Route::redirect('/', '/login');



require __DIR__.'/auth.php';
?>