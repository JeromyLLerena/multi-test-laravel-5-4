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
    return view('welcome');
});

Route::get('/competitions', 'Football\FootballController@index')->name('competitions.index');
Route::get('/competitions/{id}', 'Football\FootballController@show')->name('competitions.show');
Route::get('/competitions/{id}/fixtures', 'Football\FootballController@fixtures')->name('competitions.fixtures');

Route::post('/webhook', 'Bot\BotController@webhook');

Route::group(['prefix' => 'telegram', 'as' => 'telegram', 'namespace' => 'Telegram'], function(){
	Route::post('webhook', 'TelegramBotController@webhook');
	Route::group(['prefix' => 'admin', 'as' => '.admin', 'namespace' => 'Admin'], function(){
		Route::get('home', ['as' => '.home', 'AdminController@home']);
	});
});

Route::get('test', function(){
	return view('admin.home');
});

Route::group(['prefix' => 'bots', 'as' => 'bots', 'namespace' => 'Bot'], function(){
	Route::get('/index', ['as' => '.index', 'uses' => 'BotController@index']);
	Route::get('/create', ['as' => '.create', 'uses' => 'BotController@showCreate']);
	Route::post('/create', ['as' => '.create', 'uses' => 'BotController@create']);
	Route::get('/{id}/edit', ['as' => '.edit', 'uses' => 'BotController@showEdit']);
	Route::post('/{id}/edit', ['as' => '.edit', 'uses' => 'BotController@edit']);
});