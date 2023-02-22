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

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');



//* admin */


Route::name('admin.')->prefix('/')->middleware("admin")->group(function() {
    Route::get('dashboard', 'AdminController@index')->name('dashboard');
    Route::get('edit','AdminController@profile')->name('edit');
    Route::post('updateProfile','AdminController@updateProfile')->name('updateProfile');
    Route::get('pengguna','AdminController@userProfile')->name('pengguna');
    Route::get('changeUser','AdminController@changeUserStatus')->name('changeUser');
    Route::post('addUser','AdminController@addUser')->name('addUser');
    Route::get('showUser/{id}','AdminController@showUser')->name('showUser');
    Route::post('editUser/{id}','AdminController@editUser')->name('editUser');
    Route::delete('delUser/{id}','AdminController@delUser')->name('delUser');
    Route::get('feed', 'PostController@index')->name('feed');
    Route::post('addPost', 'PostController@store')->name('addPost');
    Route::get('showPost/{id}', 'PostController@show')->name('showPost');
    Route::post('updatePost/{id}', 'PostController@update')->name('updatePost');
    Route::get('read/{id}', 'PostController@readPost')->name('read');
    Route::delete('delPost/{id}', 'PostController@destroy')->name('delPost');
    Route::get('konsultasi', 'ConsultController@index')->name('konsultasi');
    Route::get('komunitas', 'ComunityController@index')->name('komunitas');
    Route::post('addStatus', 'StatusController@store')->name('addStatus');
    Route::get('showStatus/{id}', 'StatusController@show')->name('showStatus');
    Route::post('updateStatus/{id}', 'StatusController@update')->name('updateStatus');
    // Route::get('readStatus/{id}', 'StatusController@readStatus')->name('readStatus');
    Route::delete('delStatus/{id}', 'StatusController@destroy')->name('delStatus');
});

//* expert*/  


Route::name('expert.')->prefix('/')->middleware("expert","isUser")->group(function() {
    Route::get('expert', 'ExpertController@index')->name('expert');
    Route::get('edite','ExpertController@profile')->name('edite');
    Route::post('updateprofilex','ExpertController@updateProfile')->name('updateprofilex');
    Route::get('feede', 'PostController@indexe')->name('feede');
    Route::post('addposte', 'PostController@store')->name('addposte');
    Route::get('showposte/{id}', 'PostController@show')->name('showposte');
    Route::post('updateposte/{id}', 'PostController@update')->name('updateposte');
    Route::get('reade/{id}', 'PostController@readPost')->name('reade');
    Route::delete('delposte{id}', 'PostController@destroy')->name('delposte');
    Route::get('konsultasie', 'ConsultController@indexe')->name('konsultasie');

});

//* farmer */


Route::name('farmer.')->prefix('/')->middleware("farmer","isUser")->group(function() {
    Route::get('farmer', 'FarmerController@index')->name('farmer');
    Route::get('profilepage', 'FarmerController@profilePage')->name('profilepage');
    Route::get('editf','FarmerController@profile')->name('editf');
    Route::post('updateprofilef','FarmerController@updateProfile')->name('updateprofilef');
    Route::post('changecover','FarmerController@changeCover')->name('changecover');
    Route::post('changephoto','FarmerController@changePhoto')->name('changephoto');
    Route::get('feedf', 'PostController@indexf')->name('feedf');
    Route::get('readf/{id}', 'PostController@readf')->name('readf');
    Route::get('konsultasif', 'ConsultController@indexf')->name('konsultasif');
    Route::get('komunitasf', 'ComunityController@indexf')->name('komunitasf');
    Route::post('addstatusf', 'StatusController@store')->name('addstatusf');
    Route::get('showstatusf/{id}', 'StatusController@show')->name('showstatusf');
    Route::post('updatestatusf/{id}', 'StatusController@update')->name('updatestatusf');
    // Route::get('readf/{id}', 'StatusController@readStatus')->name('readf');
    Route::delete('delstatusf/{id}', 'StatusController@destroy')->name('delstatusf');


});


