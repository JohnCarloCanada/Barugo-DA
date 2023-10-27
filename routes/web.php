<?php

use App\Http\Controllers\PersonnelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminControlPanelController;
use App\Http\Controllers\AdminDogVaccinationController;
use App\Http\Controllers\AreaInformationController;
use App\Http\Controllers\DogVaccinationinformationController;
use App\Http\Controllers\LiveStockInformationController;
use App\Http\Controllers\MachineryInformationController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\PoultryInformationController;

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

    /* Route::resource('personnel', PersonnelController::class)->only(['index','destroy','store','update']);
    Route::put('personnel', [PersonnelController::class,'edit'])->name('personnel.edit'); */

    Route::controller(AdminController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::get('/farmers', 'farmer')->name('admin.farmer');
        Route::get('/farmers/details/{personalInformation}/{currentRoute}', 'farmerDetails')->name('admin.farmerDetails');
        Route::get('/location', 'showMap')->name('adminLocation.index');
        Route::put('/dashboard/{personalInformation}', 'approved')->name('admin.approved');
        Route::delete('/dashboard/{personalInformation}', 'delete')->name('admin.delete');
    });

    Route::controller(AreaInformationController::class)->group(function() {
        Route::delete('/areaInformation/{area}', 'destroy')->name('areaInformation.destroy');
    });

    Route::controller(LiveStockInformationController::class)->group(function() {
        Route::delete('/liveStockInformation/{livestock}', 'destroy')->name('liveStockInformation.destroy');
    });

    Route::controller(MachineryInformationController::class)->group(function() {
        Route::delete('/machineryInformation/{machinery}', 'destroy')->name('machineryInformation.destroy');
    });

    Route::controller(PoultryInformationController::class)->group(function() {
        Route::delete('/poultryInformation/{poultry}', 'destroy')->name('poultryInformation.destroy');
    });

    Route::controller(AdminControlPanelController::class)->group(function() {
        Route::get('/adminControlPanel/{currentRoute}', 'index')->name('adminControlPanel.index');
        Route::post('/adminControlPanel', 'store')->name('adminControlPanel.store');
        Route::delete('/adminControlPanel/{option}', 'destroy')->name('adminControlPanel.destroy');
    });

    Route::controller(AdminDogVaccinationController::class)->group(function() {
        Route::get('/dogVaccinationInformation', 'index')->name('adminDogVaccinationInformation.index');
    });
});


Route::prefix('/user')->middleware(['auth', 'verified', 'isUser'])->group(function() {

    Route::controller(UserController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('user.dashboard');
        Route::get('/managedFarmers/details/{personalInformation}/{currentRoute}', 'managedFarmerDetails')->name('user.managedFarmersDetails');
        Route::get('/location', 'showMap')->name('userLocation.index');
    });
    
    Route::resource('personalInformation', PersonalInformationController::class)->only([
        'index', 'create', 'store', 'destroy', 'edit', 'update',
    ]);

    Route::controller(AreaInformationController::class)->group(function() {
        Route::get('/areaInformation{personalInformation}', 'index')->name('areaInformation.index');
        Route::post('/areaInformation/{personalInformation}', 'store')->name('areaInformation.store');
    });

    Route::controller(LiveStockInformationController::class)->group(function() {
        Route::get('/liveStockInformation/{personalInformation}', 'index')->name('liveStockInformation.index');
        Route::post('/liveStockInformation/{personalInformation}', 'store')->name('liveStockInformation.store');
    });

    Route::controller(MachineryInformationController::class)->group(function() {
        Route::get('/machineryInformation/{personalInformation}', 'index')->name('machineryInformation.index');
        Route::post('/machineryInformation/{personalInformation}', 'store')->name('machineryInformation.store');
    });

    Route::controller(PoultryInformationController::class)->group(function() {
        Route::get('/poultryInformation/{personalInformation}', 'index')->name('poultryInformation.index');
        Route::post('/poultryInformation/{personalInformation}', 'store')->name('poultryInformation.store');
    });

    Route::controller(DogVaccinationinformationController::class)->group(function() {
        Route::get('/dogVaccinationInformation', 'index')->name('dogVaccinationInformation.index');
        Route::get('/dogVaccinationInformation/create', 'create')->name('dogVaccinationInformation.create');
        Route::post('/dogVaccinationInformation/store', 'store')->name('dogVaccinationInformation.store');
        Route::get('/dogVaccinationInformation/vaccination/{dogInformation}', 'vaccination')->name('dogVaccinationInformation.vaccination');
    });
});


Route::redirect('/', '/login');



require __DIR__.'/auth.php';
?>