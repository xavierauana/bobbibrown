<?php
/**
 * Author: Xavier Au
 * Date: 23/8/2017
 * Time: 10:28 PM
 */

Route::post('events/{event}/publish', "EventsController@publish")->name('events.publish');
Route::get('events/{event}/qrcode', "EventsController@getQrCode")->name('events.publish');
Route::resource("events", "EventsController");
Route::post('events/{event}/participants/{user}/remove', "EventsController@removeParticipant")
     ->name('events.participants.remove');