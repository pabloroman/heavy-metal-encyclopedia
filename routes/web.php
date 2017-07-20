<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/bands/{slug}/{band}', 'BandController@show')->name('showBand');
Route::get('/albums/{slug}/{album}', 'AlbumController@show')->name('showAlbum');
