<?php

// Render login
Route::get('login', 'SessionsController@create');

// Route for logout
Route::get('logout', 'SessionsController@destroy');

// POST to login
Route::post('sessions/store', 'SessionsController@store');

// Registration, render form
Route::get('register', function() {
    return View::make('users.register');
});

// Registration POST
Route::post('users/store', 'UsersController@store');