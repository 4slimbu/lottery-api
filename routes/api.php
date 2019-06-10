<?php

Route::prefix('v1')->namespace('\App\Acme\Controllers')->group(function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
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

    // Permissions
    Route::get('lottery/slots', 'LotteryController@index');
    Route::post('lottery/slots', 'LotteryController@create');
    Route::get('lottery/slots/{lotterySlotId}', 'LotteryController@show')->where('lotterySlotId', '[0-9]+');
    Route::put('lottery/slots/{lotterySlotId}', 'LotteryController@update')->where('lotterySlotId', '[0-9]+');
    Route::delete('lottery/slots', 'LotteryController@destroyMultiple');
    Route::delete('lottery/slots/{lotterySlotId}', 'LotteryController@destroy')->where('lotterySlotId', '[0-9]+');

    // Me
    Route::get('me', 'MeController@show');
    Route::post('me', 'MeController@update');
    Route::put('me/update-email', 'MeController@updateEmail');
    Route::put('me/reset-password', 'MeController@resetPassword');

    // Posts
    Route::get('posts', 'PostController@index');
    Route::post('posts', 'PostController@create');
    Route::post('posts/{postId}', 'PostController@update');
    Route::get('posts/{postId}', 'PostController@show');
    Route::delete('posts/{postId}', 'PostController@destroy');

    // Comments
    Route::get('comments/{postId}', 'CommentController@index');
    Route::post('comments', 'CommentController@create');
    Route::get('mycomments', 'CommentController@myComments');
    Route::put('comments/{commentId}', 'CommentController@update');
    Route::get('commentId/{commentId}', 'CommentController@show');
    Route::delete('comments/{commentId}', 'CommentController@destroy');

    // Locations
    Route::get('locations', 'LocationController@index');

    // Category
    Route::get('categories', 'CategoryController@index');

});