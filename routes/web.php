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
    return redirect('/game');
});

Route::get('game', 'App\Http\Controllers\GameController@index')->name('game');
Route::get('lb', 'App\Http\Controllers\GameController@leaderboard')->name('leaderboard');

Route::get('api/game/create', 'App\Http\Controllers\GameController@startGame')->name('game.create');
Route::post('api/game/{session_id}/update', 'App\Http\Controllers\GameController@saveScore')->name('game.update');
Route::post('api/game/{session_id}/end', 'App\Http\Controllers\GameController@endGame')->name('game.update');