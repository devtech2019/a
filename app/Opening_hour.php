<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opening_hour extends Model
{
	 protected $table = 'opening_hours';
	 protected $fillable = [
      'day',
      'opening_time',
      'closing_time',
    ];
   
     public function cleanersAvailability(){
   
    return $this->belongsTo('App\User','user_id');

  }
}
