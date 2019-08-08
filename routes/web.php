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

Route::post('/getPage', 'CampactivityController@getPage');

Route::post('/getCampactivities', 'CampactivityController@getCampactivities');

Route::post('/getCampactivitiesByLittleType', 'CampactivityController@getCampactivitiesByLittleType');

Route::post('/getCampactivitiesByBigType', 'CampactivityController@getCampactivitiesByBigType');

Route::post('/getCampactivitiesForWx', 'CampactivityController@getCampactivitiesForWx');

Route::post('/getWxInfoById', 'CampactivityController@getWxInfoById');

Route::post('/getShowsByType', 'CampactivityController@getShowsByType');

Route::post('/getCampactivityById', 'CampactivityController@getCampactivityById');

Route::post('/GetCampactivityByCounty', 'CampactivityController@GetCampactivityByCounty');

Route::post('/getCamps', 'CampactivityController@getCamps');

Route::post('/getCampById', 'CampactivityController@getCampById');

Route::post('/saveMessage', 'MessageController@saveMessage');

Route::post('/savePost', 'ForumController@savePost');

Route::post('/loginByPhone', 'UserController@loginByPhone');

Route::post('/savePhone', 'UserController@savePhone');

Route::post('/collect', 'UserController@collect');

Route::post('/iscollect', 'UserController@iscollect');

Route::post('/getCollect', 'UserController@getCollect');

Route::post('/memberUpdate', 'UserController@memberUpdate');

Route::post('/memberSelect', 'UserController@memberSelect');

Route::post('/getCampactivitiesByCollect', 'CampactivityController@getCampactivitiesByCollect');

Route::post('/getWxInfoByName', 'CampactivityController@getWxInfoByName');

Route::post('/getNine', 'CampactivityController@getNine');

Route::post('/upload', 'FileController@upload');

Route::post('/onPay', 'PayController@onPay');

Route::post('/onRePay', 'PayController@onRePay');

Route::post('/onPayBack', 'PayController@onPayBack');

Route::post('/getOrderAll', 'PayController@getOrderAll');

Route::post('/getOrderUnPay', 'PayController@getOrderUnPay');

Route::post('/getOrderUnUse', 'PayController@getOrderUnUse');

Route::post('/getOrderUse', 'PayController@getOrderUse');

Route::post('/hideOrder', 'PayController@hideOrder');

Route::post('/useUpdate', 'PayController@useUpdate');

