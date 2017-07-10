<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Anacreation\Etvtest\Models\QuestionType;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('register/verify/{confirmationCode}', [
    'as'   => 'email.confirmation',
    'uses' => 'Auth\RegisterController@verify'
]);

Auth::routes();

Route::group(['middleware' => "auth:admin", 'prefix' => 'admin', 'guard' => 'admin'], function () {

    Route::resource("events", "EventsController");
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
    Route::resource("tests", "TestsController");
    Route::resource("tests.questions", "QuestionsController");
    Route::post("questions/updateOrder", "QuestionsController@updateOrder");
    Route::get("questionTypes", function () {
        return response()->json(QuestionType::all());
    });

    Route::resource('menus', 'MenusController');
});

Route::group(['middleware' => "auth"], function () {

    Route::post("/events/{event}/registration", "EventsController@registration")->name("user.event.registration");

    Route::get('/collections/{collection}', 'HomeController@showCollection')->name("show.collection");

    Route::get('/collections/{collection}/lessons/{lesson}', 'HomeController@showCollectionLesson')
         ->name("show.collection.lesson");

    Route::get('/lessons/{lesson}', 'HomeController@showLesson')->name("show.lesson");
    Route::get('/lessons/{lesson}/test', 'HomeController@showLessonTest')->name("show.lesson.test");

});


Route::get('/home', 'HomeController@index')->name('home');
