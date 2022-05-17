<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
   protected $table = 'coupons';
   protected $fillable = [
        'applicable_for', 'start_date', 'end_date', 'title', 'description', 'value_type', 'coupon_code', 'coupon_limit', 'status','value', 
    ];
   
     public function is_coupon(){

      if (Auth::check()) {

        $user = Auth::user();

        if ($coupons->applicable_for == 'I' OR $coupons->applicable_for == 'P' OR  $coupons->applicable_for == 'B') {

          return true;

        }

        return false;

      }

      return false;
    }

    

    
    
}
