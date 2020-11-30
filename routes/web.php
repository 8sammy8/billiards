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

    /** Order tables */
    Route::get('/order-tables', [\App\Http\Controllers\Admin\OrderTableController::class, 'index'])
        ->name('order-tables.index');
    Route::get('/order-tables/create/{id}', [\App\Http\Controllers\Admin\OrderTableController::class, 'create'])
        ->name('order-tables.create');
    Route::post('/order-tables/create/', [\App\Http\Controllers\Admin\OrderTableController::class, 'store'])
        ->name('order-tables.store');
    Route::get('/order-tables/show/{id}', [\App\Http\Controllers\Admin\OrderTableController::class, 'show'])
        ->name('order-tables.show');
    Route::get('/order-tables/checkout/{id}', [\App\Http\Controllers\Admin\OrderTableController::class, 'checkout'])
        ->name('order-tables.checkout');

    /** Order products */
    Route::get('/order-products', [\App\Http\Controllers\Admin\OrderProductController::class, 'index'])
        ->name('order-products.index');
    Route::get('/order-products/create/{order_id?}', [\App\Http\Controllers\Admin\OrderProductController::class, 'create'])
        ->name('order-products.create');
    Route::get('/order-products/edit/{id}', [\App\Http\Controllers\Admin\OrderProductController::class, 'edit'])
        ->name('order-products.edit');
    Route::post('/order-products/store/', [\App\Http\Controllers\Admin\OrderProductController::class, 'store'])
        ->name('order-products.store');
    Route::get('/order-products/refund/{id}', [\App\Http\Controllers\Admin\OrderProductController::class, 'refund'])
        ->name('order-products.refund');
    Route::get('/order-products/checkout/{id}', [\App\Http\Controllers\Admin\OrderProductController::class, 'checkout'])
        ->name('order-products.checkout');

    /** Product categories and products */
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)
        ->except('show')->names('categories');
    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class)
        ->except('show')->names('products');
    Route::post('/product/{id}/image-delete', [\App\Http\Controllers\Admin\ProductController::class, 'imageDelete'])
        ->name('products.image.delete');

    Route::group(['middleware' => ['checkAdmin'],
        ], function() {
        /** Need admin middleware */
        Route::resource('/hall-groups', \App\Http\Controllers\Admin\HallGroupController::class)
            ->except('show')->names('hall-groups');
        Route::resource('/tables', \App\Http\Controllers\Admin\TableController::class)
            ->except('show')->names('tables');
        Route::resource('/rates', \App\Http\Controllers\Admin\RateController::class)
            ->except('show')->names('rates');
        /** Need admin middleware end */
    });
});

