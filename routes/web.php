<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\PrecinctController;
use App\Http\Controllers\VotersProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\VotersGroupController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\LegislativeDistrictController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TaggingController;


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

Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('auth.login');
});




Route::middleware(['check.user'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //Route for CRUDE
    Route::resource('barangay', BarangayController::class);
    Route::resource('purok', PurokController::class);
    Route::resource('sitio', SitioController::class);
    Route::resource('precinct', PrecinctController::class);
    Route::resource('voters_profile', VotersProfileController::class);
    Route::resource('group', GroupController::class);
    Route::resource('voters_group', VotersGroupController::class);
    Route::resource('province', ProvinceController::class);
    Route::resource('legislative_district', LegislativeDistrictController::class);
    Route::resource('city', CityController::class);
    Route::resource('tagging', TaggingController::class);

    //Route for the Name List
    Route::get('namelist', [VotersProfileController::class, 'namelist'])->name('voter_profile.namelist');

    //Route for Search
    Route::get('/leaders/search', [VotersProfileController::class, 'search'])->name('leaders.search');

    //Route for Managing a Leader
    Route::get('manageleader/{manageleader}', [VotersProfileController::class, 'manageleader'])->name('voter_profile.manageleader');

    //Route for Adding Subordinate
    Route::post('/subordinates/store', [VotersProfileController::class, 'storeSubordinate'])->name('storeSubordinate');



});