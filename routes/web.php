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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'HomeController@index');

Route::get('new_ticket', 'TicketsController@create');
Route::post('new_ticket', 'TicketsController@store');
Route::get('tickets/{ticket_id}', 'TicketsController@show');
Route::get('my_tickets', 'TicketsController@userTickets');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
	Route::get('update/{ticket_id}', 'TicketsController@update_show');
	Route::post('update/do/{ticket_id}', 'TicketsController@update');
	Route::get('delete/{ticket_id}', 'TicketsController@delete');
	Route::get('tickets', 'TicketsController@index');
	Route::get('close_ticket/{ticket_id}', 'TicketsController@close');
});

Route::post('comment', 'CommentsController@postComment');
