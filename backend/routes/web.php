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

//Route::get('/client/task/create', 'TaskController@create')->name('show_client_create');
Route::post('/client/add', 'HomeController@addClient')->name('add_client');
Route::get('/client/remove', 'HomeController@removeClient')->name('remove_client');
Route::get('/client/archive', 'HomeController@archiveClient')->name('archive_client');
Route::get('/client/unarchive', 'HomeController@unarchiveClient')->name('unarchive_client');
Route::get('/client/create', 'HomeController@showClientCreate')->name('show_client_create');
Route::get('/client/{id}', 'HomeController@showClient')->name('show_client');

Route::resource('tasks','TaskController');
Route::resource('authors','AuthorController');

//Route::get('/tasks', 'TaskController@index')->name('task');
