<?php

Route::group(['prefix' => 'translation'], function() {
    Route::get('get', 'TranslationController@getAction');
    Route::get('getRandom', 'TranslationController@getRandomAction');
    Route::get('check', 'TranslationController@checkAction');
});
