<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Washing_plan extends Model
{
    //
    protected $fillable = [
      'name','description'
    ];

    public function washing_include(){
      return $this->hasOne('App\Washing_plan_include');
    }

    public function washing_price(){
      return $this->hasOne('App\Washing_price');
    }

    public function appointment() {
      return $this->hasOne('App\Appointment');
    }

    public function WashingPlanInclude(){
      return $this->hasMany('App\Washing_plan_include');
    }
}
