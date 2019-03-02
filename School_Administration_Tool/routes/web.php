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

Route::group(['prefix' => 'staff'], function () {
    Route::get('/loginStaff', 'StaffAuth\LoginController@showLoginForm')->name('loginStaff');
    Route::post('/loginStaff', 'StaffAuth\LoginController@login');
    Route::post('/logoutStaff', 'StaffAuth\LoginController@logout')->name('logoutStaff');

    Route::get('/registerStaff', 'StaffAuth\RegisterController@showRegistrationForm')->name('registerStaff');
    Route::post('/registerStaff', 'StaffAuth\RegisterController@register');

    Route::post('/password/email', 'StaffAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'StaffAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'StaffAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'StaffAuth\ResetPasswordController@showResetForm');

    Route::resource('class','Backend\ClassController');
    Route::resource('section','Backend\SectionController');
    Route::get('anyData', 'Backend\SectionController@anyData')->name('sectionDatable');

});

Route::group(['prefix' => 'student'], function () {
    Route::get('/loginStudent', 'StudentAuth\LoginController@showLoginForm')->name('loginStudent');
    Route::post('/loginStudent', 'StudentAuth\LoginController@login');
    Route::post('/logoutStudent', 'StudentAuth\LoginController@logout')->name('logoutStudent');

    Route::get('/registerStudent', 'StudentAuth\RegisterController@showRegistrationForm')->name('registerStudent');
    Route::post('/registerStudent', 'StudentAuth\RegisterController@register');

    Route::post('/password/email', 'StudentAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'StudentAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'StudentAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'StudentAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'guardian'], function () {
    Route::get('/loginGuardian', 'GuardianAuth\LoginController@showLoginForm')->name('loginGuardian');
    Route::post('/loginGuardian', 'GuardianAuth\LoginController@login');
    Route::post('/logoutGuardian', 'GuardianAuth\LoginController@logout')->name('logoutGuardian');

    Route::get('/registerGuardian', 'GuardianAuth\RegisterController@showRegistrationForm')->name('registerGuardian');
    Route::post('/registerGuardian', 'GuardianAuth\RegisterController@register');

    Route::post('/password/email', 'GuardianAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'GuardianAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'GuardianAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'GuardianAuth\ResetPasswordController@showResetForm');
});


