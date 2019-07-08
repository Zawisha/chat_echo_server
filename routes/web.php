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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('messages',function(Illuminate\Http\Request $request)
{
//ochered
    App\Events\PrivateChat::dispatch($request->all());
});

Route::get('/room/{room}',function(App\Room $room)
{
    return view('room', ['room' => $room]);
});
