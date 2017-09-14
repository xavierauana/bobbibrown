<?php
/**
 * Author: Xavier Au
 * Date: 26/7/2017
 * Time: 6:22 PM
 */

use Anacreation\Etvtest\Models\QuestionType;
use App\Http\Controllers\AdministratorsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\UsersController;

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
    Route::resource("users", UsersController::class);
    Route::post("users/{user}/approve", UsersController::class . "@approve");
    Route::resource("permissions", PermissionsController::class);
    Route::resource("roles", RolesController::class);
    Route::get("roles/{role}/permissions",
        RolesController::class . "@showPermissions");
    Route::post("roles/{role}/permissions",
        RolesController::class . "@updatePermissions");

    Route::resource("tests", TestsController::class);
    Route::resource("tests.questions", QuestionsController::class);
    Route::post("questions/updateOrder",
        QuestionsController::class . "@updateOrder");
    Route::get("questionTypes", function () {
        return response()->json(QuestionType::all());
    });

    Route::resource('administrators', "AdministratorsController");

});

Route::post("/CKEditorFileUploader/upload", "CKEditorController@upload")
     ->middleware('auth:admin');