<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Class CancellationRefunds
 * @mixin Model
 */
class CancellationRefunds extends Model{

    protected $table = 'cancellation_refunds';

    public function userDetails(){
      return $this->belongsTo('App\User','user_id');
    }

	public function cleanerDetails(){
      return $this->belongsTo('App\User','cleaner_id');
    }

}
