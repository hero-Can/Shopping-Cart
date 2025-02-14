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

// Route::get('/product-cards', function () {
//     return view('product-cards');
// });

// Route::get('/shopping-cart', function () {
//     return view('shopping-cart');
// });

Route::get('/product-cards', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/shopping-cart', [App\Http\Controllers\CartController::class, 'cart'])->name('cart');
Route::get('/add-products-to-cart/{product_id}', [App\Http\Controllers\CartController::class, 'addProductsToCart'])->name('add-products-to-cart');
Route::get('/increment-qtty/{product_id}', [App\Http\Controllers\CartController::class, 'incrementQuantity'])->name('increment-qtty');
Route::get('/decrement-qtty/{product_id}', [App\Http\Controllers\CartController::class, 'decrementQuantity'])->name('decrement-qtty');
Route::get('/remove-product-from-cart/{product_id}', [App\Http\Controllers\CartController::class, 'removeProductFromCart'])->name('remove-product-from-cart');

