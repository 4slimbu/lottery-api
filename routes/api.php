<?php

Route::prefix('v1')->namespace('\App\Acme\Controllers')->group(function() {
    Route::post('coinbase/create-charge', 'CoinbaseController@createCharge');

    Route::post('register', 'AuthController@register');
    Route::post('register-as-guest', 'AuthController@registerAsGuest');
    Route::post('login', 'AuthController@login');
    Route::post('player-login', 'AuthController@playerLogin');
    Route::put('logout', 'AuthController@logout');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::put('reset-password', 'AuthController@resetPassword');
    Route::put('verify-email/{token}', 'AuthController@verifyEmail');
    Route::put('reset-email', 'AuthController@resetEmail');
    Route::get('resend-verification-code', 'AuthController@reSendVerificationCode');
    Route::put('refresh-token', 'AuthController@refreshToken');

    // Users
    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@create');
    Route::get('users/{userId}', 'UserController@show')->where('userId', '[0-9]+');
    Route::put('users/{userId}', 'UserController@update')->where('userId', '[0-9]+');
    Route::put('users', 'UserController@updateMultiple');
    Route::delete('users', 'UserController@destroyMultiple');
    Route::delete('users/{userId}', 'UserController@destroy')->where('userId', '[0-9]+');
    Route::get('users/check-email', 'UserController@checkEmail');
    Route::get('users/export', 'UserController@export');

    // Role
    Route::get('roles', 'RoleController@index');
    Route::post('roles', 'RoleController@create');
    Route::get('roles/{roleId}', 'RoleController@show')->where('roleId', '[0-9]+');
    Route::put('roles/{roleId}', 'RoleController@update')->where('roleId', '[0-9]+');
    Route::delete('roles', 'RoleController@destroyMultiple');
    Route::delete('roles/{roleId}', 'RoleController@destroy')->where('roleId', '[0-9]+');

    // Permissions
    Route::get('permissions', 'PermissionController@index');
    Route::post('permissions', 'PermissionController@create');
    Route::get('permissions/{permissionId}', 'PermissionController@show')->where('permissionId', '[0-9]+');
    Route::put('permissions/{permissionId}', 'PermissionController@update')->where('permissionId', '[0-9]+');
    Route::delete('permissions', 'PermissionController@destroyMultiple');
    Route::delete('permissions/{permissionId}', 'PermissionController@destroy')->where('permissionId', '[0-9]+');

    // Settings
    Route::get('settings', 'SettingController@index');
    Route::post('settings', 'SettingController@create');
    Route::get('settings/{settingId}', 'SettingController@show')->where('settingId', '[0-9]+');
    Route::put('settings/{settingId}', 'SettingController@update')->where('settingId', '[0-9]+');
    Route::delete('settings', 'SettingController@destroyMultiple');
    Route::delete('settings/{settingId}', 'SettingController@destroy')->where('settingId', '[0-9]+');

    // Currencies
    Route::get('currencies', 'CurrencyController@index');
    Route::post('currencies', 'CurrencyController@create');
    Route::get('currencies/{currencyId}', 'CurrencyController@show')->where('currencyId', '[0-9]+');
    Route::put('currencies/{currencyId}', 'CurrencyController@update')->where('currencyId', '[0-9]+');
    Route::delete('currencies', 'CurrencyController@destroyMultiple');
    Route::delete('currencies/{currencyId}', 'CurrencyController@destroy')->where('currencyId', '[0-9]+');

    // Lottery
    Route::get('lottery/slots', 'LotteryController@index');
    Route::post('lottery/slots', 'LotteryController@create');
    Route::post('lottery/slots/close', 'LotteryController@close');
    Route::post('lottery/slots/add-participant', 'LotteryController@addParticipant');
    Route::get('lottery/slots/winners', 'LotteryController@getWinners');
    Route::get('lottery/slots/last', 'LotteryController@getLastResult');
    Route::get('lottery/slots/active', 'LotteryController@getActiveSlot');
    Route::get('lottery/slots/{lotterySlotId}', 'LotteryController@showLotterySlot')->where('lotterySlotId', '[0-9]+');
    Route::put('lottery/slots/{lotterySlotId}', 'LotteryController@update')->where('lotterySlotId', '[0-9]+');
    Route::delete('lottery/slots', 'LotteryController@destroyMultiple');
    Route::delete('lottery/slots/{lotterySlotId}', 'LotteryController@destroy')->where('lotterySlotId', '[0-9]+');

    // Wallet
    Route::get('wallets', 'WalletController@index');
    Route::get('wallets/withdraw-requests', 'WalletController@getWithdrawRequests');
    Route::put('wallets/withdraw-requests', 'WalletController@updateMultipleWithdrawRequest');

    // Dashboard
    Route::get('dashboard/get-stats', 'DashboardController@getStats');

    // Me
    Route::get('me', 'MeController@show');
    Route::post('me/play', 'MeController@play');
    Route::get('me/played-games', 'MeController@getPlayedGames');
    Route::get('me/transactions', 'MeController@getTransactions');
    Route::get('me/withdraw-requests', 'MeController@getWithdrawRequests');
    Route::post('me/create-withdraw-request', 'MeController@createWithdrawRequest');
    Route::put('me/cancel-withdraw-request/{withdrawRequestId}', 'MeController@cancelWithdrawRequest');
    Route::get('me/profile', 'MeController@profile');
    Route::put('me/profile', 'MeController@profile');
    Route::put('me/profile/update', 'MeController@update');

    // Pages
    Route::get('pages', 'PageController@index');
    Route::post('pages', 'PageController@create');
    Route::get('pages/{idOrSlug}', 'PageController@show');
    Route::put('pages/{pageId}', 'PageController@update')->where('pageId', '[0-9]+');
    Route::delete('pages/{pageId}', 'PageController@destroy')->where('pageId', '[0-9]+');
    // Pages
    Route::get('seo', 'SeoController@index');
    Route::post('seo', 'SeoController@save');
    Route::get('seo/{seoId}', 'SeoController@show')->where('seoId', '[0-9]+');
    Route::delete('seo/{seoId}', 'SeoController@destroy')->where('seoId', '[0-9]+');

    // Contact Us
    Route::post('contact', 'ContactFormEntryController@create');
});