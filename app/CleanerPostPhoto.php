<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CleanerPrePhoto
 * @mixin \Eloquent
 */
class CleanerPostPhoto extends Model{
    
    protected $table = 'cleaner_post_booking';


    protected $fillable = [
        'appointment_id',  'cleaner_id', 'top_img','back_img','front_img','right_img','left_img'
    ];

   
}
