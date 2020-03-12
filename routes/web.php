<?php

use Illuminate\Http\Request;
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
    return view('install');
})->name('home');

Route::post('/install', 'ShopifyController@install')->name('shopify.install.post');
Route::get('/callback', 'ShopifyController@handleCallback')->name('shopify.callback.get');

Route::middleware('store.installed')->group(function () {
    Route::get('/products', 'ProductController@index')->name('shopify.products.index');
});

Route::get('/not-support', function () {
    return view('not-support');
})->name('shopify.not-support.get');
