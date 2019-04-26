<?php

namespace App;

use App\Notifications\StaffResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'firstName','middleName', 'LastName','email', 'dob','gender','address','role','classTeacher_id','remark','phone_no','mobile_no','profilePic','password',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new StaffResetPassword($token));
    }
    public function subject()
    {
        return $this->belongsToMany('App\Model\Subject', 'class_staff_subject', 'staff_id', 'subject_id');
    }
    public function classRoom()
    {
        return $this->belongsToMany('App\Model\ClassRoom', 'class_staff', 'staff_id', 'class_id');
    }
    public function section()
    {
        return $this->belongsToMany('App\Model\Section', 'class_staff', 'sec_id', 'class_id');
    }
}
