<?php

// Render login
Route::get('login', 'SessionsController@create');

// Route for logout
Route::get('logout', 'SessionsController@destroy');

// POST to login
Route::post('sessions/store', 'SessionsController@store');