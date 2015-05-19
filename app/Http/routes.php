<?php

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function ($router) {
    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'admin.dashboard.index']);

    Route::group(['prefix' => 'site-settings', 'middleware' => 'user-role', 'role' => 'admin'], function () {
        Route::get('/', ['uses' => 'SiteSettingsController@edit', 'as' => 'admin.site-settings.edit']);
        Route::post('/', ['uses' => 'SiteSettingsController@store', 'as' => 'admin.site-settings.store']);
    });

    Route::group(['prefix' => 'users', 'middleware' => 'user-role', 'role' => 'admin'], function () {
        Route::get('/', ['uses' => 'UsersController@index', 'as' => 'admin.users.index']);
        Route::get('/new', ['uses' => 'UsersController@create', 'as' => 'admin.users.create']);
        Route::post('/', ['uses' => 'UsersController@store', 'as' => 'admin.users.store']);
        Route::get('/profile', ['uses' => 'UsersController@profile', 'as' => 'admin.users.profile']);
        Route::get('/{id}', ['uses' => 'UsersController@edit', 'as' => 'admin.users.edit']);
        Route::put('/{id}', ['uses' => 'UsersController@update', 'as' => 'admin.users.update']);
    });

    Route::group(['prefix' => 'copy', 'middleware' => 'user-role', 'role' => 'admin'], function () {
        Route::get('/', ['uses' => 'CopyController@index', 'as' => 'admin.copy.index']);
        Route::get('/new', ['uses' => 'CopyController@create', 'as' => 'admin.copy.create']);
        Route::post('/', ['uses' => 'CopyController@store', 'as' => 'admin.copy.store']);
        Route::get('/profile', ['uses' => 'CopyController@profile', 'as' => 'admin.copy.profile']);
        Route::get('/{id}', ['uses' => 'CopyController@edit', 'as' => 'admin.copy.edit']);
        Route::put('/{id}', ['uses' => 'CopyController@update', 'as' => 'admin.copy.update']);
    });
});

Route::get('login', ['uses' => 'Auth\\SessionController@create', 'as' => 'auth.session.create']);
Route::post('login', ['uses' => 'Auth\\SessionController@store', 'as' => 'auth.session.store']);
Route::any('logout', ['uses' => 'Auth\\SessionController@destroy', 'as' => 'auth.session.destroy']);

Route::get('password-reset', ['uses' => 'Auth\\PasswordController@create', 'as' => 'auth.password.create']);
Route::post('password-reset', ['uses' => 'Auth\\PasswordController@store', 'as' => 'auth.password.store']);
Route::get('password-reset/{id}', ['uses' => 'Auth\\PasswordController@edit', 'as' => 'auth.password.edit']);
Route::post('password-reset/{id}', ['uses' => 'Auth\\PasswordController@update', 'as' => 'auth.password.update']);
