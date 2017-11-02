<?php
/**
 * Author: Xavier Au
 * Date: 23/8/2017
 * Time: 10:26 PM
 */

Route::resource("lessons", "LessonsController");
Route::get("lessons/{lesson}/tests", "LessonsController@editTests");
Route::post("lessons/{lesson}/tests", "LessonsController@updateTests");
Route::post("lessons/{lesson}/users/{user}/reminder", "LessonsController@sendLessonReminder");
Route::get("lessons/{lesson}/users", "LessonsController@getUsersForTest");
Route::get("lessons/{lesson}/users/{user}/records", "LessonsController@getUserTestRecords")->name('lessons.user.test.records');