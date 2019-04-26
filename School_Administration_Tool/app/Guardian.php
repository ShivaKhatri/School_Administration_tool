<?php

namespace App;

use App\Notifications\GuardianResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Guardian extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','middleName', 'LastName','email', 'relation','occupation','address','phone_no','mobile_no','profilePic','password',
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
        $this->notify(new GuardianResetPassword($token));
    }
    public function student()
    {
        return $this->belongsToMany('App\Student', 'guardian_student', 'guard_id', 'student_id');
    }
}
