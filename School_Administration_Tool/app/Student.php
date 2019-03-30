<?php

namespace App;

use App\Notifications\StudentResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
        $this->notify(new StudentResetPassword($token));
    }
    public function classRoom()
    {
        return $this->belongsToMany('App\Model\ClassRoom', 'class_section_student', 'student_id', 'class_id');
    }
    public function section()
    {
        return $this->belongsToMany('App\Model\Section', 'class_section_student', 'student_id', 'section_id');
    }
    public function guardian()
    {
        return $this->belongsToMany('App\Guardian', 'class_section_student', 'student_id', 'guard_id');
    }
}
