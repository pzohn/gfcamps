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
    return view('gfc');
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

Route::post('/savePostList', 'ForumController@savePostList');

Route::post('/savePostListItem', 'ForumController@savePostListItem');

Route::post('/getPostList', 'ForumController@getPostList');

Route::post('/getPostLists', 'ForumController@getPostLists');

Route::post('/getPostListsByPhone', 'ForumController@getPostListsByPhone');

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

Route::post('/onPayForCert', 'PayController@onPayForCert');

Route::post('/onRePay', 'PayController@onRePay');

Route::post('/onPayBack', 'PayController@onPayBack');

Route::post('/getOrderAll', 'PayController@getOrderAll');

Route::post('/getOrderUnPay', 'PayController@getOrderUnPay');

Route::post('/getOrderUnsend', 'PayController@getOrderUnsend');

Route::post('/getOrderSend', 'PayController@getOrderSend');

Route::post('/hideOrder', 'PayController@hideOrder');

Route::post('/useUpdate', 'PayController@useUpdate');

Route::post('/getAddress', 'UserController@getAddress');

Route::post('/getAddressById', 'UserController@getAddressById');

Route::post('/insertAddress', 'UserController@insertAddress');

Route::post('/updateAddress', 'UserController@updateAddress');

Route::post('/delAddress', 'UserController@delAddress');

Route::post('/makeTrades', 'CampactivityController@makeTrades');

Route::post('/certInsert', 'CertController@certInsert');

Route::post('/certsSelect', 'CertController@certsSelect');

Route::post('/certdelete', 'CertController@certdelete');

Route::post('/certupdate', 'CertController@certupdate');

Route::post('/getWxUser', 'UserController@getWxUser');

Route::post('/makeWxUser', 'UserController@makeWxUser');

Route::post('/newForum', 'ForumController@newForum');

Route::post('/getForums', 'ForumController@getForums');
Route::post('/getTest', 'TestController@getTest');
Route::post('/getTests', 'TestController@getTests');
Route::post('/insertTests', 'TestController@insertTests');

Route::post('/collectioninsert', 'CollectionController@insertOneCollectionItem');
Route::post('/collectiondelete', 'CollectionController@deleteOneCollectionItem');
Route::post('/getusercollections', 'CollectionController@getUserCollections');
Route::post('/getuseronecollection', 'CollectionController@getUserOneCollection');
