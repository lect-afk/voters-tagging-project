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
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;


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
    Route::resource('candidates', CandidateController::class);
    Route::resource('votes', VoteController::class);

    //Route for the Name List
    Route::get('namelist', [VotersProfileController::class, 'namelist'])->name('voter_profile.namelist');

    //Route for Search
    Route::get('/leaders/search', [VotersProfileController::class, 'leadersearch'])->name('leaders.search');
    Route::get('/voters/search', [VotersProfileController::class, 'votersearch'])->name('voters.search');

    //Route for Managing a Leader
    Route::get('manageleader/{manageleader}', [VotersProfileController::class, 'manageleader'])->name('voter_profile.manageleader');

    //Route for Managing a Leader
    Route::get('viewhierarchy/{viewhierarchy}', [VotersProfileController::class, 'viewhierarchy'])->name('voter_profile.viewhierarchy');

    //Route for Adding Subordinate
    Route::post('/subordinates/store', [VotersProfileController::class, 'storeSubordinate'])->name('storeSubordinate');

    //Remove Successor
    Route::delete('/successor/{id}', [VotersProfileController::class, 'successorDestroy'])->name('successor.destroy');

    //Route for partial updates
    Route::patch('/voters_profile/{votersProfile}/update-leader', [VotersProfileController::class, 'updateLeader'])->name('voters_profile.update_leader');

    //Route for showing the right purok and sitio
    Route::get('/getPurok/{barangayID}', [VotersProfileController::class, 'getPurok']);
    Route::get('/getPurok4Sitio/{barangayID}', [SitioController::class, 'getPurok4Sitio']);
    Route::get('/getSitio/{purokID}', [VotersProfileController::class, 'getSitio']);
    Route::get('/getPrecinct/{barangayID}', [VotersProfileController::class, 'getPrecinct']);

    //Route for showing the right province,district, and city
    Route::get('/getDistrict/{provinceID}', [CandidateController::class, 'getDistrict']);
    Route::get('/getDistrict4City/{provinceID}', [CityController::class, 'getDistrict4City']);
    Route::get('/getCity/{districtID}', [CandidateController::class, 'getCity']);

    //Route for the Summary
    Route::get('barangaysummary', [VotersProfileController::class, 'barangaysummary'])->name('voters.barangaysummary');
    Route::get('precinctsummary', [VotersProfileController::class, 'precinctsummary'])->name('voters.precinctsummary');



});