<?php

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function ($router) {
    Route::get('api/menus', ['uses' => 'Admin\\Api\\MenusController@index', 'as' => 'admin.api.menus.index']);
    Route::get('menus', ['uses' => 'Admin\\MenusController@index', 'as' => 'admin.menus.index']);
    Route::get('menus/{slug}', ['uses' => 'Admin\\MenusController@show', 'as' => 'admin.menus.show']);

    Route::get('site-settings', ['uses' => 'Admin\\SiteSettingsController@edit', 'as' => 'admin.site-settings.edit']);
    Route::post('site-settings', ['uses' => 'Admin\\SiteSettingsController@store', 'as' => 'admin.site-settings.store']);

    Route::get('users', ['uses' => 'Admin\\UsersController@index', 'as' => 'admin.users.index']);
    Route::get('users/profile', ['uses' => 'Admin\\UsersController@profile', 'as' => 'admin.users.profile']);
    Route::get('users/{id}', ['uses' => 'Admin\\UsersController@edit', 'as' => 'admin.users.edit']);
    Route::put('users/{id}', ['uses' => 'Admin\\UsersController@update', 'as' => 'admin.users.update']);

});

Route::get('login', ['uses' => 'Auth\\SessionController@create', 'as' => 'auth.session.create']);
Route::post('login', ['uses' => 'Auth\\SessionController@store', 'as' => 'auth.session.store']);
Route::any('logout', ['uses' => 'Auth\\SessionController@destroy', 'as' => 'auth.session.destroy']);

Route::get('password-reset', ['uses' => 'Auth\\PasswordController@create', 'as' => 'auth.password.create']);
