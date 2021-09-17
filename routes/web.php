<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Crm Status
    Route::delete('crm-statuses/destroy', 'CrmStatusController@massDestroy')->name('crm-statuses.massDestroy');
    Route::resource('crm-statuses', 'CrmStatusController');

    // Crm Customer
    Route::delete('crm-customers/destroy', 'CrmCustomerController@massDestroy')->name('crm-customers.massDestroy');
    Route::resource('crm-customers', 'CrmCustomerController');

    // Crm Note
    Route::delete('crm-notes/destroy', 'CrmNoteController@massDestroy')->name('crm-notes.massDestroy');
    Route::resource('crm-notes', 'CrmNoteController');

    // Crm Document
    Route::delete('crm-documents/destroy', 'CrmDocumentController@massDestroy')->name('crm-documents.massDestroy');
    Route::post('crm-documents/media', 'CrmDocumentController@storeMedia')->name('crm-documents.storeMedia');
    Route::post('crm-documents/ckmedia', 'CrmDocumentController@storeCKEditorImages')->name('crm-documents.storeCKEditorImages');
    Route::resource('crm-documents', 'CrmDocumentController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Surah
    Route::delete('surahs/destroy', 'SurahController@massDestroy')->name('surahs.massDestroy');
    Route::post('surahs/parse-csv-import', 'SurahController@parseCsvImport')->name('surahs.parseCsvImport');
    Route::post('surahs/process-csv-import', 'SurahController@processCsvImport')->name('surahs.processCsvImport');
    Route::resource('surahs', 'SurahController');

    // Quran
    Route::delete('qurans/destroy', 'QuranController@massDestroy')->name('qurans.massDestroy');
    Route::post('qurans/media', 'QuranController@storeMedia')->name('qurans.storeMedia');
    Route::post('qurans/ckmedia', 'QuranController@storeCKEditorImages')->name('qurans.storeCKEditorImages');
    Route::post('qurans/parse-csv-import', 'QuranController@parseCsvImport')->name('qurans.parseCsvImport');
    Route::post('qurans/process-csv-import', 'QuranController@processCsvImport')->name('qurans.processCsvImport');
    Route::resource('qurans', 'QuranController');

    // Languages
    Route::delete('languages/destroy', 'LanguagesController@massDestroy')->name('languages.massDestroy');
    Route::resource('languages', 'LanguagesController');

    // Translate
    Route::delete('translates/destroy', 'TranslateController@massDestroy')->name('translates.massDestroy');
    Route::post('translates/parse-csv-import', 'TranslateController@parseCsvImport')->name('translates.parseCsvImport');
    Route::post('translates/process-csv-import', 'TranslateController@processCsvImport')->name('translates.processCsvImport');
    Route::resource('translates', 'TranslateController');

    // Notes
    Route::delete('notes/destroy', 'NotesController@massDestroy')->name('notes.massDestroy');
    Route::post('notes/media', 'NotesController@storeMedia')->name('notes.storeMedia');
    Route::post('notes/ckmedia', 'NotesController@storeCKEditorImages')->name('notes.storeCKEditorImages');
    Route::resource('notes', 'NotesController');

    // Meal
    Route::delete('meals/destroy', 'MealController@massDestroy')->name('meals.massDestroy');
    Route::post('meals/parse-csv-import', 'MealController@parseCsvImport')->name('meals.parseCsvImport');
    Route::post('meals/process-csv-import', 'MealController@processCsvImport')->name('meals.processCsvImport');
    Route::resource('meals', 'MealController');

    // Meal Contents
    Route::delete('meal-contents/destroy', 'MealContentsController@massDestroy')->name('meal-contents.massDestroy');
    Route::post('meal-contents/media', 'MealContentsController@storeMedia')->name('meal-contents.storeMedia');
    Route::post('meal-contents/ckmedia', 'MealContentsController@storeCKEditorImages')->name('meal-contents.storeCKEditorImages');
    Route::post('meal-contents/parse-csv-import', 'MealContentsController@parseCsvImport')->name('meal-contents.parseCsvImport');
    Route::post('meal-contents/process-csv-import', 'MealContentsController@processCsvImport')->name('meal-contents.processCsvImport');
    Route::resource('meal-contents', 'MealContentsController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

Route::group(['prefix' => 'quran', 'as' => 'quran.', 'namespace' => 'Quran', 'middleware' => ['auth']], function () {
    Route::get('quran','QuranController@index')->name('quran');
    Route::post('quran','QuranController@index')->name('quran');
});


Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax', 'middleware' => ['auth']], function () {
    Route::get('getCountAyah/{id?}','QuranAjaxController@getCountAyah')->name('getCountAyah');
    Route::post('getInfo','QuranAjaxController@getInfo')->name('getInfo');
    Route::post('note_save','NoteAjaxController@note_save')->name('note_save');
    Route::post('note_delete','NoteAjaxController@note_delete')->name('note_delete');
});
