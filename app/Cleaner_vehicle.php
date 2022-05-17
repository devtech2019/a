<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cleaner_vehicle extends Model
{
   protected $table = 'cleaners_franchise_vehicle';
   
  public function teamCleaners(){
   
    return $this->belongsTo('App\Team','franchise_id');

  }
  public function franchiseCleaners(){
   
    return $this->belongsTo('App\UserFranchise','cleaner_id');

  }
    
    
}
