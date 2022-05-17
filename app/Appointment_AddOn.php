<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment_AddOn extends Model
{

  protected $table = 'appointment_addons';
    protected $fillable = [
      'appointment_id',
      'addon_id',
      'user_id',
     
    ];
    // public function appointment_addon_services() {
    //   return $this->belongsTo('App\AddOn','addon_id');
    // }

    public function appointment_addon() {
      return $this->belongsTo('App\AddOn','addon_id');
    } 
   
    
}
