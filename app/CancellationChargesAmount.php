<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationChargesAmount extends Model{
   
  protected $table = 'cancellation_charges_amount';

  public function cancellationUserDetail() {
    return $this->belongsTo('\App\User','user_id')->select('id','name');
  }
  
  public function cancellationCleanerDetail() {
    return $this->belongsTo('\App\User','cleaner_id')->select('id','name');
  }
  public function cancellationTransactionDetail() {
    return $this->belongsTo('\App\Transaction','transaction_id');
  }
  public function userDetails(){
    return $this->belongsTo('App\User','user_id');
  }

  public function cleanerDetails(){
    return $this->belongsTo('App\User','cleaner_id');
  }

}




