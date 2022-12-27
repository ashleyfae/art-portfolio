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

Route::get('/{year?}/{month?}', [\App\Http\Controllers\ArtworkController::class, 'index'])
    ->where([
        'year'  => '^\d{4}$',
        'month' => '^[0-9]+$',
    ])
    ->name('home');

Route::get('/artwork/{artwork:uuid}', [\App\Http\Controllers\ArtworkController::class, 'show'])
    ->name('artworks.show');

Route::resource('artworks', \App\Http\Controllers\ArtworkController::class)->except([
    'index', 'show',
]);

Route::get('/deviantart/redirect', \App\Http\Controllers\ImportProviders\DeviantArt\DeviantArtRedirectController::class)
    ->name('deviantart.redirect')
    ->middleware('auth');
