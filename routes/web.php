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