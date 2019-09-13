<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

Route::get('/env', function () {
    dd(env('MY_KEY'));
});

Route::get('/log', function () {
    Log::info('This is an info message');
    Log::critical('This is a critical message');

    return 'Logged items successfully.';
});

Route::get('/users', function () {
    dd(\App\User::all());
});

Route::get('/jobs/{jobs}', function ($jobs) {
    for ($i=0; $i < $jobs; $i++) {
        \App\Jobs\SomeJob::dispatch();
    }

    return 'Jobs complete!';
});

Route::post('/submit', function (Request $request) {
    Storage::copy(
        $request->input('key'),
        str_replace('tmp/', '', $request->input('key'))
    );
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
