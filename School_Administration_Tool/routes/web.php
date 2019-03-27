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
Route::get('staff/login', 'StaffAuth\LoginController@showLoginForm')->name('loginStaff');
Route::post('staff/login', 'StaffAuth\LoginController@login');
Route::group(['prefix' => 'staff','middleware' => ['staff']], function () {
    Route::post('/logout', 'StaffAuth\LoginController@logout')->name('logoutStaff');

    Route::get('/register', 'StaffAuth\RegisterController@showRegistrationForm')->name('registerStaff');
    Route::post('/register', 'StaffAuth\RegisterController@register');

    Route::post('/password/email', 'StaffAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
    Route::post('/password/reset', 'StaffAuth\ResetPasswordController@reset')->name('password.email');
    Route::get('/password/reset', 'StaffAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::get('/password/reset/{token}', 'StaffAuth\ResetPasswordController@showResetForm');

    Route::resource('class','Backend\ClassController');

    Route::resource('section','Backend\SectionController');

    Route::resource('guardian','Backend\GuardianController');

    Route::resource('student','Backend\StudentController');

    Route::resource('staff','Backend\StaffController');

    Route::resource('subject','Backend\SubjectController');

    Route::resource('exam','Backend\ExamController');




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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
