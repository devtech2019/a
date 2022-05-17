<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password', 'photo', 'gender', 'dob', 'mobile', 'phone', 'address', 'role','zip_code','license_no','police_clearance','franchise_id','verification_otp_time','resend_otp_time','otp_number','is_verified','is_block','tracker_device_driver_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function team_task() {
      return $this->hasOne('App\Team_task');
    }

    public function blogs() {
      return $this->hasOne('App\Blog');
    }
    
    public function CleanerVehicle() {
      return $this->hasOne('App\Cleaner_vehicle','cleaner_id');
    }

    public function getRatingAvg()
    {
        return $this->hasMany('App\UserReviewRatings','cleaner_id');
    }

    
    public function franchise_name() {
      return $this->belongsTo('App\Team','franchise_id');
    }

    public function appointment() {
      return $this->belongsToMany('App\Appointment', 'appointment_users');
    }
    public function userCleaners() {
      return $this->hasMany('App\UserFranchise','franchise_id');
    }
    public function bookedCleaners() {
      return $this->hasMany('App\UserFranchise','user_id');
    }
    
    public function bookingCleaners() {
      return $this->hasMany('App\UserFranchise','user_id');
    }
   
    public function is_admin(){

      if (Auth::check()) {

        $user = Auth::user();

        if ($user->role == 'A') {

          return true;

        }

        return false;

      }

      return false;
    }

    public function is_common(){

      if (Auth::check()) {

        $user = Auth::user();

        if ($user->role == 'S' OR $user->role == 'A' OR  $user->role == 'C' OR  $user->role == 'U') {

          return true;

        }

        return false;

      }

      return false;
    }


      /**
     * Get the url to the photo
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->urlForName($this->photo);
    }


    /**
     * Get the url for the file name (specify thumb, default, original)
     * @param $name
     * @return string
     */
    public function urlForName($name)
    {
        return asset('images/users/'). $name;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }   

    public function userNotifications() {
      return $this->hasMany('App\Notifications', 'user_id')->whereNull('is_read');
    }


}
