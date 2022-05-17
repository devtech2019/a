<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserVehicle
 * @mixin \Eloquent
 */
class UserVehicle extends Model{
    
    protected $table = 'user_vehicle';


    protected $fillable = [
        'user_id',  'color', 'vehicle_class', 'vehicle_model', 'vehicle_make','vehicle_registration_no','top_photo','bottom_photo','front_photo','right_photo','left_photo'
    ];

    public function vehicleClass() {
      return $this->belongsTo('App\Vehicle_type','vehicle_class');
    }

    public function vehicleModel() {
      return $this->belongsTo('App\Vehicle_modal','vehicle_model');
    }

    public function VehicleType() {
      return $this->belongsTo('App\Vehicle_company','vehicle_make');
    }
    
}
