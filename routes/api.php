<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Surah
    Route::apiResource('surahs', 'SurahApiController');

    // Quran
    Route::post('qurans/media', 'QuranApiController@storeMedia')->name('qurans.storeMedia');
    Route::apiResource('qurans', 'QuranApiController');

    // Languages
    Route::apiResource('languages', 'LanguagesApiController');

    // Translate
    Route::apiResource('translates', 'TranslateApiController');

    // Notes
    Route::post('notes/media', 'NotesApiController@storeMedia')->name('notes.storeMedia');
    Route::apiResource('notes', 'NotesApiController');

    // Meal
    Route::apiResource('meals', 'MealApiController');

    // Meal Contents
    Route::post('meal-contents/media', 'MealContentsApiController@storeMedia')->name('meal-contents.storeMedia');
    Route::apiResource('meal-contents', 'MealContentsApiController');
});
