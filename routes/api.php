<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::controller(NoteController::class)
    ->prefix('note')
    ->name("note.")
    ->middleware('CheckUser')
    ->group(
        function() {
            Route::get('/all' , 'index')->name('all');
            Route::post('/create' , 'store')->name('store');
            Route::post('/update/{id}' , 'update')->name('update');
            Route::post('/destroy/{id}' , 'destroy')->name('destroy');
        }
    );
