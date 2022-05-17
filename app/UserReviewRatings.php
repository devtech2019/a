<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User Review Ratings
 * @mixin \Eloquent
 */
class UserReviewRatings extends Model{
   
    protected $table = 'user_rating_reviews';

    public function appointmentDetails() {
        return $this->belongsTo('App\Appointment','booking_id');
      }
}
