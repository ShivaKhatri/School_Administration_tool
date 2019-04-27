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

    Route::get('staff/role/{id}', 'Backend\StaffController@role')->name('staff.role');
    Route::get('staff/{use}/role/{id}', 'Backend\StaffController@roleEdit')->name('staff.roleEdit');

    Route::get('staff/ajax/{id}', 'Backend\StaffController@ajax')->name('staff.ajax');
    Route::get('staff/{use}/ajax/{id}', 'Backend\StaffController@ajaxEdit')->name('staff.ajaxEdit');
    Route::resource('staff','Backend\StaffController');

    Route::resource('class','Backend\ClassController');

    Route::resource('section','Backend\SectionController');

    Route::get('attendance/subject/{id}', 'Backend\AttendanceController@subject')->name('attendance.subject');
    Route::get('attendance/{use}/subject/{id}', 'Backend\AttendanceController@subjectEdit')->name('attendance.subject.edit');
    Route::resource('attendance','Backend\AttendanceController');

    Route::get('mark/giveMark/{id}', 'Backend\MarkController@giveMark')->name('mark.giveMark');
    Route::get('mark/{use}/giveMark/{id}', 'Backend\MarkController@editGiveMark')->name('mark.editGiveMark');
    Route::resource('mark','Backend\MarkController');

    Route::resource('guardian','Backend\GuardianController');

    Route::get('student/ajax/{id}', 'Backend\StudentController@ajax')->name('student.ajax');
    Route::get('student/{use}/ajaxEdit/{id}', 'Backend\StudentController@ajaxEdit')->name('student.ajaxEdit');
    Route::get('student/validate/{id}/{use}', 'Backend\StudentController@valid')->name('student.valid');
    Route::resource('student','Backend\StudentController');

    Route::get('result/section/{id}', 'Backend\ResultController@section')->name('result.section');
    Route::get('result/exam/{id}/{session}', 'Backend\ResultController@exam')->name('result.exam');
    Route::get('result/showResult', 'Backend\ResultController@showResult')->name('result.showResult');
    Route::get('result/student/{class}/{section}/{session}', 'Backend\ResultController@student')->name('result.student');

    Route::get('result/result/{class}/{section}/{session}/{examID}/{studentID}', 'Backend\ResultController@result')->name('result.result');
    Route::resource('result','Backend\ResultController');



    Route::resource('subject','Backend\SubjectController');

    Route::get('exam/class/{exam_id}/{class}', 'Backend\ExamController@exam')->name('exam.routine');
    Route::resource('exam','Backend\ExamController');

    Route::get('fee/student/{student_id}', 'Backend\FeeController@student')->name('fee.student');
    Route::get('fee/{use}/student/{student_id}', 'Backend\FeeController@studentEdit')->name('fee.studentEdit');
    Route::resource('fee','Backend\FeeController');

    Route::get('fine/student/{student_id}', 'Backend\FineController@student')->name('fine.student');
    Route::get('fine/{use}/student/{student_id}', 'Backend\FineController@studentEdit')->name('fine.studentEdit');
    Route::resource('fine','Backend\FineController');

    Route::get('discount/student/{student_id}', 'Backend\DiscountController@student')->name('discount.student');
    Route::get('discount/{use}/student/{student_id}', 'Backend\DiscountController@studentEdit')->name('discount.studentEdit');
    Route::resource('discount','Backend\DiscountController');

    Route::get('bill/student/{student_id}', 'Backend\BillController@student')->name('bill.student');
    Route::resource('bill','Backend\BillController');




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
