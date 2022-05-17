<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cleanerDailyOpeningRecord extends Model
{
        protected $table = 'cleaner_daily_opening_record';

        public function cleaners_name() {
                return $this->belongsTo('App\User','cleaner_id');
              }
          

}
