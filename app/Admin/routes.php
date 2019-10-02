<?php

Route::get('', ['as' => 'admin.dashboard', 'uses' => \App\Http\Controllers\Admin\DashboardController::class . '@index']);

Route::post('', ['as' => 'admin.dashboard.send', 'uses' => \App\Http\Controllers\Admin\DashboardController::class . '@sendMessages']);


Route::namespace('\App\Http\Controllers\Admin\\')
    ->name('admin.')
    ->group(function () {
        Route::post('', DashboardController::class . '@sendMessages')->name('dashboard.send');

        Route::post('/settings', SettingController::class . '@store')->name('settings.store');
        Route::post('/settings/webhook', SettingController::class . '@setWebhook')->name('setting.webhook');

        Route::get('telegram/login', TelegramController::class . '@login')->name('dashboard.telegram.login');
        Route::post('telegram/login', TelegramController::class . '@phoneLogin')->name('dashboard.telegram.phoneLogin');
        Route::post('telegram/logout', TelegramController::class . '@logout')->name('dashboard.telegram.logout');
        Route::post('telegram/complete', TelegramController::class . '@completePhoneLogin')->name('dashboard.telegram.completePhoneLogin');

    });
