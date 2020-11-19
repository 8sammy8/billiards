<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['auth'],
    'as' => 'admin.',
], function() {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->name('home');

    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)
        ->except('show')->names('categories');

    /** Need admin middleware */
    Route::resource('/hall-groups', \App\Http\Controllers\Admin\HallGroupController::class)
        ->except('show')->names('hall-groups');
    Route::resource('/tables', \App\Http\Controllers\Admin\TableController::class)
        ->except('show')->names('tables');
    Route::resource('/rates', \App\Http\Controllers\Admin\RateController::class)
        ->except('show')->names('rates');
    /** Need admin middleware end */
});

