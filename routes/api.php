<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'word'], function() {
    Route::get('get', 'WordController@getAction');
    Route::post('add', 'WordController@addAction');
    Route::get('getAll', 'WordController@getAllAction');
    Route::get('getRandom', 'WordController@getRandomAction');
    Route::post('addToArchive', 'WordController@addToArchiveAction');
    Route::post('addAllWords', 'WordController@addAllWordsAction');
});

Route::group(['prefix' => 'translation'], function() {
    Route::get('get', 'TranslationController@getAction');
    Route::get('getRandom', 'TranslationController@getRandomAction');
    Route::get('check', 'TranslationController@checkAction');
});
