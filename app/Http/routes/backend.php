<?php
/**
 * Author: Xavier Au
 * Date: 26/7/2017
 * Time: 6:22 PM
 */


use Anacreation\Etvtest\Models\QuestionType;

Route::group(['middleware' => "auth:admin", 'prefix' => 'admin', 'guard' => 'admin'], function () {

    Route::post('events/{event}/publish', "EventsController@publish")->name('events.publish');
    Route::resource("events", "EventsController");
    Route::post('events/{event}/participants/{user}/remove', "EventsController@removeParticipant")
         ->name('events.participants.remove');

    Route::resource("users", "UsersController");
    Route::post("users/{user}/approve", "UsersController@approve");

    Route::resource("collections", "CollectionsController");
    Route::post("collections/{collection}/updateOrder", "CollectionsController@updateLessonsOrder");
    Route::get("collections/{collection}/lessons", "CollectionsController@editLessonsIndex")
         ->name('collections.lessons.index');
    Route::get("collections/{collection}/lessons/edit", "CollectionsController@editLessons")
         ->name('collections.lessons.edit');
    Route::post("collections/{collection}/lessons", "CollectionsController@updateLessons")
         ->name('collections.lessons.update');;
    Route::resource("lessons", "LessonsController");
    Route::get("lessons/{lesson}/tests", "LessonsController@editTests");
    Route::post("lessons/{lesson}/tests", "LessonsController@updateTests");
    Route::resource("permissions", "PermissionsController");
    Route::resource("roles", "RolesController");
    Route::get("roles/{role}/permissions", "RolesController@showPermissions");
    Route::post("roles/{role}/permissions", "RolesController@updatePermissions");
    Route::resource("tests", "TestsController");
    Route::resource("tests.questions", "QuestionsController");
    Route::post("questions/updateOrder", "QuestionsController@updateOrder");
    Route::get("questionTypes", function () {
        return response()->json(QuestionType::all());
    });

    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::get('settings/{setting}/edit', 'SettingsController@edit')->name('settings.edit');
    Route::put('settings/{setting}', 'SettingsController@update')->name('settings.update');
});

Route::post("/CKEditorFileUploader/upload", "CKEditorController@upload")->middleware('auth:admin');