<?php

use Illuminate\Support\Facades\Route;
use Predis\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $redisPrefix = env('REDIS_PREFIX');

    $publisher = new Client([
        "host" => env('REDIS_HOST'),
        "password" => env('REDIS_PASSWORD'),
        "port" => env("REDIS_PORT"),
    ]);

    $publisher->publish(
        $redisPrefix.'user_added_note',
        json_encode([
            'type' => 'user_added_note',
            'user_id' => 10,
            'note_id' => 50,
        ])
    );

//    return view('welcome');
});
