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


    Route::get('/collections/{collection}/test', 'HomeController@showCollectionTest')->name("show.collection.test");
    Route::post('/collections/{collection}/test', 'HomeController@gradeCollectionTest')->name("grade.collection.test");

    Route::get('/collections/{collection}', 'HomeController@showCollection')->name("show.collection");

    Route::get('/collections/{collection}/lessons/{lesson}', 'HomeController@showCollectionLesson')
         ->name("show.collection.lesson");

    Route::get('/lessons/{lesson}', 'HomeController@showLesson')->name("show.lesson");
    Route::get('/lessons/{lesson}/test', 'HomeController@showLessonTest')->name("show.lesson.test");
    Route::post('/lessons/{lesson}/test', 'HomeController@gradeLessonTest')->name("grade.lesson.test");
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/resources', "HomeController@showResources")->name("show.resources");
    Route::get('/products/{product}', "HomeController@showProduct")->name("show.product");


    Route::get('/events', 'HomeController@showEvents')->name('show.events');
    Route::get('/myEvents', 'HomeController@showMyEvents')->name('show.myevents');
    Route::post('/events/{event}/cancel', 'HomeController@cancelEvent')->name('user.event.cancel');
    Route::post('/events/{event}/registration', 'HomeController@registration')->name('user.event.registration');
    Route::get('/events/{event}/signin', 'HomeController@eventSignIn')->name('signin.event');
    Route::post('/events/{event}/signin', 'HomeController@logSignIn')->name('log.signin.event');
    Route::get('/events/{event}', 'HomeController@showEventDetail')->name('show.event.detail');
    Route::post('/events/{event}/register', 'HomeController@registerEvent')->name('register.event');
});


