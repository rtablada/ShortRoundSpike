Route::group(['prefix' => '{{ dashedPlural }}'], function () {
    Route::get('/', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@index', 'as' => 'admin.{{ dashedPlural }}.index']);
    Route::get('/new', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@create', 'as' => 'admin.{{ dashedPlural }}.create']);
    Route::post('/', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@store', 'as' => 'admin.{{ dashedPlural }}.store']);
    Route::get('/{id}', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@edit', 'as' => 'admin.{{ dashedPlural }}.edit']);
    Route::put('/{id}', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@update', 'as' => 'admin.{{ dashedPlural }}.update']);
    {% if position %}Route::get('/{id}/up', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@up', 'as' => 'admin.{{ dashedPlural }}.up']);
    Route::get('/{id}/down', ['uses' => 'Admin\\{{ modelUpperPlural }}Controller@down', 'as' => 'admin.{{ dashedPlural }}.down']);{% endif %}

});
