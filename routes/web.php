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


Route::get('/', function () {
    return auth()->check() ? redirect('home') : view('auth.login');
})->name('home');

Route::get('register/verify/{confirmationCode}', [
    'as'   => 'email.confirmation',
    'uses' => 'Auth\RegisterController@verify'
]);

Auth::routes();

include_once(app_path('Http/routes/backend.php'));

Route::group(['middleware' => "auth"], function () {

    Route::get('profile', 'HomeController@getProfile')->name('profile');
    Route::post('profile', 'HomeController@postProfile')->name('profile.update');

    Route::post("/events/{event}/registration", "EventsController@registration")->name("user.event.registration");

    Route::get('/collections/{collection}', 'HomeController@showCollection')->name("show.collection");

    Route::get('/collections/{collection}/lessons/{lesson}', 'HomeController@showCollectionLesson')
         ->name("show.collection.lesson");

    Route::get('/lessons/{lesson}', 'HomeController@showLesson')->name("show.lesson");
    Route::get('/lessons/{lesson}/test', 'HomeController@showLessonTest')->name("show.lesson.test");
    Route::post('/tests/{test}/grade', 'HomeController@gradeTest')->name("grade.test");
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/events', 'HomeController@showEvents')->name('show.events');
    Route::get('/events/{event}', 'HomeController@showEventDetail')->name('show.event.detail');
    Route::post('/events/{event}/register', 'HomeController@registerEvent')->name('register.event');
});


