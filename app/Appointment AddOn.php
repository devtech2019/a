<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment_AddOn extends Model
{
    protected $fillable = [
      'user_id',
      'vehicle_id',
      'address_id',
      'booking_type',
      'washing_plan_id',
      'status_id',
      'appointment_date',
      'time_frame',
      'cleaner_id',
    ];

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function cleaner() {
      return $this->belongsTo('App\User','cleaner_id');
    }

    public function vehicle_company() {
      return $this->belongsTo('App\Vehicle_company');
    }

    public function vehicle_modal() {
      return $this->belongsTo('App\Vehicle_modal');
    }

    public function vehicle_type() {
      return $this->belongsTo('App\Vehicle_type', 'vehicle_types_id');
    }

    public function washing_plan() {
      return $this->belongsTo('App\Washing_plan')->with(['washing_price','WashingPlanInclude']);
    }

    public function status() {
      return $this->belongsTo('App\Status');
    }

    public function user_vehicle() {
      return $this->belongsTo('App\UserVehicle','vehicle_id')->with(['vehicleClass','vehicleModel','VehicleType']);
    }

    public function user_address() {
      return $this->belongsTo('App\UserAddressBook','address_id');
    }
    public function cleaner_appointment() {
      return $this->belongsTo('App\User','user_id');
    }

   
    public function payment(){
      return $this->hasOne('App\Payment');
    }
    
}
