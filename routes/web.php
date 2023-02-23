<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/orders', 'App\Http\Controllers\OrderController');
Route::resource('/products', 'App\Http\Controllers\ProductController');
Route::resource('/suppliers', 'App\Http\Controllers\SupplierController');
Route::resource('/users',  'App\Http\Controllers\UserController');
Route::resource('/companies', 'App\Http\Controllers\CompanyController');
Route::resource('/transactions', 'App\Http\Controllers\TransactionController');
Route::get('/barcode', 'App\Http\Controllers\ProductController@GetProductBarcodes')->name('products.barcode');
// Route::get('barcodes', function(){
//     return  $products = Product::select('barcode')->get();
//     return view('products.barcode.index');

// })->name('products.barcode');
