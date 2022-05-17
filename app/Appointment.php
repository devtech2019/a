<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
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
      'cancel_reason'
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

    public function washingPrice() {
      return $this->belongsTo('App\Washing_price','washing_plan_id')->with(['washing_plan','vehicle_type']);
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

    public function CleanerPreWashPhoto() {
      return $this->hasOne('App\CleanerPrePhoto','appointment_id');
    }
    
    public function CleanerAfterWashPhoto() {
      return $this->hasOne('App\CleanerPostPhoto','appointment_id');
    }
   
    public function payment(){
      return $this->hasOne('App\Payment');
    }

    public function CleanerBookingStatusData() {
      return $this->hasOne('App\CleanerBookingStatus','appointment_id');
    }

    public function appointment_addons(){
      return $this->hasMany('App\Appointment_AddOn')->with('appointment_addon');
    }

    public function appointment_transaction(){
      return $this->hasMany('App\Transaction');
    }

    public function UserReviewRatingsData(){
      return $this->hasOne('App\UserReviewRatings','booking_id');
    }

    public function appointmentTransactionData(){
      return $this->hasOne('App\Transaction');
    }
    
    public function couponDetails() {
      return $this->belongsTo('App\Coupon','coupon_id');
    }
    
}
