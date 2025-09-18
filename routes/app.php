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

Route::prefix('app')->group(function () {

    //    Livewire
    Route::middleware('auth')->group(function () {
        Route::view('reports', 'livewire.app.reports.reports')->name('app.reports');
        Route::view('employees', 'livewire.app.employees.employees')->name('app.employees');
    });

});
