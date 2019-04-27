<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    protected $fillable = ['student_id', 'guardian_id', 'paid_status','status', 'staff_id', 'total_amount','due_amount','paid_amount','session_year','paid_date','issue_date','due_date'];

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
    public function classRoom()
    {
        return $this->belongsTo('App\Model\ClassRoom', 'class_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Staff', 'staff_id');
    }
    public function guardian()
    {
        return $this->belongsTo('App\Guardian', 'guardian_id');
    }
    public function fee()
    {
        return $this->belongsToMany('App\Model\Fee', 'bill_fee','bill_id','fee_id');
    }
    public function fine()
    {
        return $this->belongsToMany('App\Model\Fine', 'bill_fee','bill_id','fine_id');
    }
    public function discount()
    {
        return $this->belongsToMany('App\Model\Discount', 'bill_fee','bill_id','discount_id');
    }


}
