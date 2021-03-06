<?php


// Render login
Route::get('/', 'SessionsController@create');
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

// Authenticated routes
Route::group(['before' => 'auth'], function () {
    // Landing page after login
    Route::get('/me', 'UsersController@me');

    Route::get('/banks/template/{template}', 'BanksController@template');
    Route::get('/banks', 'BanksController@index');

    Route::get('/deposits/template/{template}', 'DepositsController@template');
    Route::get('/deposits', 'DepositsController@index');

    Route::get('/withdrawals/to_bank', 'WithdrawalsController@toBank');

    Route::get('/pay/{username}', 'UsersController@pay');

    // API routes
    Route::group(['prefix' => 'api/v1'], function () {
        Route::resource('banks', 'Api\v1\BanksController', ['only' => ['store']]);

        Route::resource('deposits', 'Api\v1\DepositsController', ['only' => ['store']]);

        Route::get('/users/find/{username}', 'Api\v1\UsersController@find');
        Route::post('/users/pay', 'Api\v1\UsersController@pay');

        Route::post('/withdrawals/to_bank', ['before' => ['bankOwner'], 'uses' => 'Api\v1\WithdrawalsController@toBank']);
    });
});
