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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])
    ->prefix('admin')
    ->namespace('Admin')
    ->name('admin.')
    ->group(function () {
        Route::post('/settings', SettingController::class . '@store')->name('settings.store');
        Route::post('/settings/webhook', SettingController::class . '@setWebhook')->name('setting.webhook');
    });

Route::post(Telegram::getAccessToken(), TelegramController::class . '@commands')->name('telegram.commands');



Route::get('/home', 'HomeController@index')->name('home');



