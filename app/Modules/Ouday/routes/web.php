<?php

Route::group(['module' => 'Ouday', 'middleware' => ['web'], 'namespace' => 'App\Modules\Ouday\Controllers'], function() {

    Route::resource('ouday', 'OudayController');

});
