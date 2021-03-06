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
Route::get('/', 'HomeController@index')->name('index')->middleware('auth');



Route::group(['middleware' => 'auth'], function() {
    Route::resource('enregistrements', 'RecordsController', ['names' => [
            'index' => 'enregistrements.index',
            'show' => 'enregistrements.show',
            'update' => 'enregistrements.update',
            'edit' => 'enregistrements.edit'
    ]]);
    Route::put('/enregistrements/{id}', 'RecordsController@storeCheck');
    Route::resource('syntheses', 'SynthesisController', ['names' => [
            'index' => 'syntheses.index',
            'show' => 'syntheses.show'
    ]]);
    Route::resource('graphes', 'GraphsController', ['names' => [
            'index' => 'graphes.index',
            'show' => 'graphes.show',
            'update' => 'graphes.update'
    ]]);
});
