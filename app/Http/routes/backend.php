<?php
/**
 * Author: Xavier Au
 * Date: 26/7/2017
 * Time: 6:22 PM
 */

use Anacreation\Etvtest\Models\QuestionType;

Route::group([
    'middleware' => "auth:admin",
    'prefix'     => 'admin',
    'guard'      => 'admin'
], function () {

    @include "events.php";
    @include "lessons.php";
    @include "settings.php";
    @include "collections.php";

    Route::resource('categories', 'CategoriesController');
    Route::resource('lines', 'LinesController');
    Route::resource('products', 'ProductsController');

    // Not completed
    Route::get("users/trashed", "UsersController@showDeletedUsers")
         ->name('users.trashed');
    Route::post("users/{user}/restore", "UsersController@restore")
         ->name('users.restore');
    Route::resource("users", "UsersController");
    Route::post("users/{user}/approve", "UsersController@approve");
    Route::resource("permissions", "PermissionsController");
    Route::resource("roles", "RolesController");
    Route::get("roles/{role}/permissions",
        "RolesController@showPermissions");
    Route::post("roles/{role}/permissions",
        "RolesController@updatePermissions");

    Route::resource("tests", "TestsController");
    Route::resource("tests.questions", "QuestionsController");
    Route::post("questions/updateOrder",
        "QuestionsController@updateOrder");
    Route::get("questionTypes", function () {
        return response()->json(QuestionType::all());
    });

    Route::resource('administrators', "AdministratorsController");

});

Route::post("/CKEditorFileUploader/upload", "CKEditorController@upload")
     ->middleware('auth:admin');