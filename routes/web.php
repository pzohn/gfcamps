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

Route::get('/', function () {
    return "welcome to gfc!";
});

Route::post('/getCity', 'PayController@getCity');

Route::post('/getCampactivities', 'CampactivityController@getCampactivities');

Route::post('/getCampactivitiesByLittleType', 'CampactivityController@getCampactivitiesByLittleType');

Route::post('/getShowsByType', 'CampactivityController@getShowsByType');

Route::post('/getCampactivityById', 'CampactivityController@getCampactivityById');

