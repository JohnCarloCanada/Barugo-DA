<?php

use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\PersonnelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminControlPanelController;
use App\Http\Controllers\AdminDogVaccinationController;
use App\Http\Controllers\AdminPersonalInformationController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminSeedDistributionController;
use App\Http\Controllers\AreaInformationController;
use App\Http\Controllers\DogVaccinationinformationController;
use App\Http\Controllers\ExcelExportsController;
use App\Http\Controllers\GeoMappingController;
use App\Http\Controllers\LiveStockInformationController;
use App\Http\Controllers\MachineryInformationController;
use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\PoultryInformationController;
use App\Http\Controllers\SeedInventoryController;
use App\Http\Controllers\UserPersonalInformationController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserSeedDistributionController;
use Maatwebsite\Excel\Facades\Excel;

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
    Route::controller(AdminController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::get('/farmers/details/{personalInformation}/{currentRoute}', 'farmerDetails')->name('admin.farmerDetails');
    });

    Route::controller(GeoMappingController::class)->group(function() {
        Route::get('/location', 'adminShowMap')->name('adminLocation.index');
        Route::get('/location/{personalInformation}', 'adminShowSpecificFarmerMap')->name('geoMapping.adminShowSpecificFarmerMap');
    });

    Route::controller(AdminSeedDistributionController::class)->group(function() {
        Route::get('/seedDistribution', 'adminIndex')->name('adminSeedDistribution.index');
        Route::put('/seedDistribution', 'adminSeedClaiming')->name('adminSeedDistribution.claim');
    });

    Route::controller(AdminPersonalInformationController::class)->group(function() {
        Route::get('/farmers', 'farmer')->name('adminPersonalInformation.index');
        Route::put('/farmers/{personalInformation}', 'approved')->name('adminPersonalInformation.approved');
        Route::delete('/farmers/{personalInformation}', 'delete')->name('adminPersonalInformation.delete');
        Route::get('/farmers/needApproval', 'needApproval')->name('adminPersonalInformation.needApproval');
        Route::get('/farmers/needUpdate', 'needUpdate')->name('adminPersonalInformation.needUpdate');
        Route::put('/farmers/{personalInformation}/acceptUpdate', 'acceptUpdate')->name('adminPersonalInformation.acceptUpdate');
        Route::get('/farmers/create', 'create')->name('adminPersonalInformation.create');
        Route::post('/farmers/store', 'store')->name('adminPersonalInformation.store');
        Route::get('/farmers/{personalInformation}/edit', 'edit')->name('adminPersonalInformation.edit');
        Route::put('/farmers/{personalInformation}/update', 'update')->name('adminPersonalInformation.update');
        Route::patch('/farmers/{currentRoute}', 'updateRSBSANumber')->name('adminPersonalInformation.updateRSBSANO');
    });

    Route::controller(AreaInformationController::class)->group(function() {
        Route::get('/areaInformation/{personalInformation}', 'adminIndex')->name('adminAreaInformation.index');
        Route::post('/areaInformation/{personalInformation}', 'adminStore')->name('adminAreaInformation.store');
        Route::delete('/areaInformation/{area}', 'adminDestroy')->name('adminAreaInformation.destroy');
    });

    Route::controller(LiveStockInformationController::class)->group(function() {
        Route::get('/liveStockInformation/{personalInformation}', 'adminIndex')->name('adminLiveStockInformation.index');
        Route::post('/liveStockInformation/{personalInformation}', 'adminStore')->name('adminLiveStockInformation.store');
        Route::delete('/liveStockInformation/{livestock}', 'adminDestroy')->name('adminLiveStockInformation.destroy');
    });

    Route::controller(MachineryInformationController::class)->group(function() {
        Route::get('/machineryInformation/{personalInformation}', 'adminIndex')->name('adminMachineryInformation.index');
        Route::post('/machineryInformation/{personalInformation}', 'adminStore')->name('adminMachineryInformation.store');
        Route::delete('/machineryInformation/{machinery}', 'adminDestroy')->name('adminMachineryInformation.destroy');
    });

    Route::controller(PoultryInformationController::class)->group(function() {
        Route::get('/poultryInformation/{personalInformation}', 'adminIndex')->name('adminPoultryInformation.index');
        Route::post('/poultryInformation/{personalInformation}', 'adminStore')->name('adminPoultryInformation.store');
        Route::delete('/poultryInformation/{poultry}', 'adminDestroy')->name('adminPoultryInformation.destroy');
    });

    Route::controller(AdminControlPanelController::class)->group(function() {
        Route::get('/adminControlPanel/{currentRoute}/survey', 'surveyQuestionsIndex')->name('adminControlPanelSurvey.survey');
        Route::post('/adminControlPanel/survey', 'surveyQuestionsStore')->name('adminControlPanelSurvey.store');
        Route::delete('/adminControlPanel/{id}/survey', 'surveyQuestionsDestroy')->name('adminControlPanelSurvey.destroy');
        Route::delete('/adminControlPanel/{option}/survey/disable', 'surveyQuestionsDisable')->name('adminControlPanelSurvey.disable');
        Route::put('/adminControlPanel/{id}/survey/restore', 'surveyQuestionsRestore')->name('adminControlPanelSurvey.restore');

        Route::get('/adminControlPanel/season', 'seasonDistrubutionIndex')->name('adminControlPanelSeason.season');
        Route::post('/adminControlPanel/season', 'seasonDistrubutionStore')->name('adminControlPanelSeason.store');
        Route::put('/adminControlPanel/{season}/seed/end', 'seasonDistrubutionEnd')->name('adminControlPanelSeason.end');
        Route::put('/adminControlPanel/season/edit', 'seasonDistrubutionEdit')->name('adminControlPanelSeason.edit');
    });

    Route::controller(SeedInventoryController::class)->group(function() {
        Route::get('/adminControlPanel/seed/inventory', 'seedInventoryIndex')->name('adminControlPanelSeed.index');
        Route::post('/adminControlPanel/seed/inventory', 'seedInventoryStore')->name('seedInventoryStore.store');
        Route::delete('/adminControlPanel/seed/inventory/{seedInventory}/destroy', 'seedInventoryDestroy')->name('seedInventoryDestroy.destroy');
        Route::put('/adminControlPanel/seed/inventory/update', 'seedInventoryUpdate')->name('seedInventoryUpdate.update');
    });

    Route::controller(AdminDogVaccinationController::class)->group(function() {
        Route::get('/dogVaccinationInformation', 'index')->name('adminDogVaccinationInformation.index');
        Route::get('/dogVaccinationInformation/create', 'create')->name('adminDogVaccinationInformation.create');
        Route::post('/dogVaccinationInformation/store', 'store')->name('adminDogVaccinationInformation.store');
        Route::get('/dogVaccinationInformation/vaccination/{dogInformation}', 'vaccination')->name('adminDogVaccinationInformation.vaccination');
        Route::delete('/dogVaccinationInformation/destroy/{dogInformation}', 'destroy')->name('adminDogVaccinationInformation.destroy');
        Route::get('/dogVaccinationInformation/{dogInformation}/edit', 'edit')->name('adminDogVaccinationInformation.edit');
        Route::put('/dogVaccinationInformation/{dogInformation}/update', 'update')->name('adminDogVaccinationInformation.update');
    });

    Route::controller(AdminProfileController::class)->group(function() {
        Route::get('/profile', 'index')->name('adminProfile.index');
        Route::patch('/profile/update', 'update')->name('adminProfile.update');
    });

    Route::controller(ExcelExportsController::class)->group(function() {
        Route::get('/download/farmers', 'adminDownloadAllFarmersRecord')->name('adminDownloadAllFarmersRecord');
    });

    Route::controller(ActivityLogsController::class)->group(function() {
        Route::get('/activity-logs', 'index')->name('activityLogs.index');
    });
});


Route::prefix('/user')->middleware(['auth', 'verified', 'isUser'])->group(function() {
    Route::controller(UserController::class)->group(function() {
        Route::get('/dashboard', 'index')->name('user.dashboard');
        Route::get('/managedFarmers/details/{personalInformation}/{currentRoute}', 'managedFarmerDetails')->name('user.managedFarmersDetails');
    });

    Route::controller(GeoMappingController::class)->group(function() {
        Route::get('/location', 'userShowMap')->name('userLocation.index');
        Route::get('/location/{personalInformation}', 'userShowSpecificFarmerMap')->name('geoMapping.userShowSpecificFarmerMap');
    });

    Route::controller(UserSeedDistributionController::class)->group(function() {
        Route::get('/seedDistribution', 'userIndex')->name('userSeedDistribution.index');
        Route::put('/seedDistribution', 'userSeedClaiming')->name('userSeedDistribution.claim');
    });

    Route::controller(UserPersonalInformationController::class)->group(function() {
        Route::get('/personalInformation', 'index')->name('userPersonalInformation.index');
        Route::get('/personalInformation/create', 'create')->name('userPersonalInformation.create');
        Route::post('/personalInformation/store', 'store')->name('userPersonalInformation.store');
        Route::get('/personalInformation/{personalInformation}/edit', 'edit')->name('userPersonalInformation.edit');
        Route::put('/personalInformation/{personalInformation}/update', 'update')->name('userPersonalInformation.update');
        Route::patch('/farmers/{currentRoute}', 'updateRSBSANumber')->name('userPersonalInformation.updateRSBSANO');
    });

    Route::controller(AreaInformationController::class)->group(function() {
        Route::get('/areaInformation/{personalInformation}', 'userIndex')->name('userAreaInformation.index');
        Route::post('/areaInformation/{personalInformation}', 'userStore')->name('userAreaInformation.store');
        Route::delete('/areaInformation/{area}', 'userDestroy')->name('userAreaInformation.destroy');
    });

    Route::controller(LiveStockInformationController::class)->group(function() {
        Route::get('/liveStockInformation/{personalInformation}', 'userIndex')->name('userLiveStockInformation.index');
        Route::post('/liveStockInformation/{personalInformation}', 'userStore')->name('userLiveStockInformation.store');
        Route::delete('/liveStockInformation/{livestock}', 'userDestroy')->name('userLiveStockInformation.destroy');
    });

    Route::controller(MachineryInformationController::class)->group(function() {
        Route::get('/machineryInformation/{personalInformation}', 'userIndex')->name('userMachineryInformation.index');
        Route::post('/machineryInformation/{personalInformation}', 'userStore')->name('userMachineryInformation.store');
        Route::delete('/machineryInformation/{machinery}', 'userDestroy')->name('userMachineryInformation.destroy');
    });

    Route::controller(PoultryInformationController::class)->group(function() {
        Route::get('/poultryInformation/{personalInformation}', 'userIndex')->name('userPoultryInformation.index');
        Route::post('/poultryInformation/{personalInformation}', 'userStore')->name('userPoultryInformation.store');
        Route::delete('/poultryInformation/{poultry}', 'userDestroy')->name('userPoultryInformation.destroy');
    });

    Route::controller(DogVaccinationinformationController::class)->group(function() {
        Route::get('/dogVaccinationInformation', 'index')->name('dogVaccinationInformation.index');
        Route::get('/dogVaccinationInformation/create', 'create')->name('dogVaccinationInformation.create');
        Route::post('/dogVaccinationInformation/store', 'store')->name('dogVaccinationInformation.store');
        Route::get('/dogVaccinationInformation/vaccination/{dogInformation}', 'vaccination')->name('dogVaccinationInformation.vaccination');
        Route::delete('/dogVaccinationInformation/destroy/{dogInformation}', 'destroy')->name('dogVaccinationInformation.destroy');
        Route::get('/dogVaccinationInformation/{dogInformation}/edit', 'edit')->name('dogVaccinationInformation.edit');
        Route::put('/dogVaccinationInformation/{dogInformation}/update', 'update')->name('dogVaccinationInformation.update');
    });

    Route::controller(UserProfileController::class)->group(function() {
        Route::get('/profile', 'index')->name('userProfile.index');
        Route::patch('/profile/update', 'update')->name('userProfile.update');
    });

    Route::controller(ExcelExportsController::class)->group(function() {
        Route::get('/download/farmers', 'userDownloadAllFarmersRecord')->name('userDownloadAllFarmersRecord');
    });
});


Route::redirect('/', '/login');



require __DIR__.'/auth.php';
?>