<?php
/**
 * Author: Xavier Au
 * Date: 26/7/2017
 * Time: 6:22 PM
 */


use Anacreation\Etvtest\Models\QuestionType;

Route::group(['middleware' => "auth:admin", 'prefix' => 'admin', 'guard' => 'admin'], function () {


    @include_once "events.php";
    @include_once "lessons.php";
    @include_once "settings.php";
    @include_once "collections.php";


    Route::resource('categories', 'CategoriesController');
    Route::resource('lines', 'LinesController');
    Route::resource('products', 'ProductsController');


    // Not completed
    Route::resource("users", "UsersController");
    Route::post("users/{user}/approve", "UsersController@approve");
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

});

Route::post("/CKEditorFileUploader/upload", "CKEditorController@upload")->middleware('auth:admin');