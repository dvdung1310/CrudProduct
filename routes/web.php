<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ProductController;

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

Route::get('/', [ProductController::class, 'ListProduct'])->name('list.product');
Route::post('/store-product', [ProductController::class, 'StoreProduct'])->name('store.product');
Route::post('/update-product', [ProductController::class, 'UpdateProduct'])->name('update.product');
Route::get('/destroy-product/{productId}', [ProductController::class, 'DestroyProduct'])->name('destroy.product');
Route::get('/search-product', [ProductController::class, 'SearchProduct'])->name('search.product');
Route::post('/store-ckeditor-images',[ProductController::class,'StoreCkeditorImages'])->name('store_ckeditor_images');
