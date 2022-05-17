<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'payment_transection';

    public function washing_plan() {
      return $this->belongsTo('App\Washing_plan','plan_id');
    }
    public function payment_count() {
      return $this->belongsTo('App\Appointment','user_id');
    }
    public function user_name() {
      return $this->belongsTo('App\User','user_id');
    }
    public function userCancellationRefunds() {
      return $this->hasOne('App\CancellationRefunds','payment_id','payment_id');
    }
  
    public function appointmentDetails() {
      return $this->belongsTo('App\Appointment','original_appointment_id');
    }
    public function appointmentAddons() {
      return $this->hasMany('App\Appointment_AddOn','appointment_id','appointment_id');
    }
}



