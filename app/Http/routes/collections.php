<?php
/**
 * Author: Xavier Au
 * Date: 23/8/2017
 * Time: 10:27 PM
 */
Route::resource("collections", "CollectionsController");
Route::post("collections/{collection}/updateOrder", "CollectionsController@updateLessonsOrder");
Route::get("collections/{collection}/lessons", "CollectionsController@editLessonsIndex")
     ->name('collections.lessons.index');
Route::get("collections/{collection}/lessons/edit", "CollectionsController@editLessons")
     ->name('collections.lessons.edit');
Route::post("collections/{collection}/lessons", "CollectionsController@updateLessons")
     ->name('collections.lessons.update');;

Route::get("collections/{collection}/tests", "CollectionsController@editTests")->name('collections.test.edit');
Route::post("collections/{collection}/tests", "CollectionsController@updateTests");