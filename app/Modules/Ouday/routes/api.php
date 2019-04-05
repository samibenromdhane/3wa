<?php

Route::group(['module' => 'Ouday', 'middleware' => ['api'], 'namespace' => 'App\Modules\Ouday\Controllers'], function() {

    Route::resource('ouday', 'OudayController');

});
