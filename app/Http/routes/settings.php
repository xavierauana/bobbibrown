<?php
/**
 * Author: Xavier Au
 * Date: 23/8/2017
 * Time: 10:27 PM
 */

Route::get('settings', 'SettingsController@index')->name('settings.index');
Route::get('settings/{setting}/edit', 'SettingsController@edit')->name('settings.edit');
Route::put('settings/{setting}', 'SettingsController@update')->name('settings.update');