<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Inventory Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('vtt')->group(function () {

    //    Livewire
    Route::middleware('auth')->group(function () {

        Route::view('trips', 'livewire.vtt.trips.trips')->name('vtt.trips');
        Route::view('topups', 'livewire.vtt.topups.topups')->name('vtt.topups');
        Route::view('vehicles', 'livewire.vtt.vehicles.vehicles')->name('vtt.vehicles');

    });

});
