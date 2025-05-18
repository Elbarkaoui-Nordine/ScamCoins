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
    return view('pages.home');
})->name('home');

Route::get('/crypto/{id}', function ($id) {
    return view('pages.cryptos.show', ['id' => $id]);
})->name('crypto.show');

Route::get('/nfts', function () {
    return view('pages.nfts');
})->name('nfts');

Route::get('/nft/{id}', function ($id) {
    return view('pages.nfts.show', ['id' => $id]);
})->name('nft.show');

