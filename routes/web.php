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


Auth::routes();

Route::get('/', 'HomeController@index')->name('index')->middleware('auth');;
Route::get('/enregistrements','RecordsController@index')->name('enregistrements')->middleware('auth');;
Route::get('/syntheses/{id}','SynthesisController@index')->name('syntheses')->middleware('auth');;
