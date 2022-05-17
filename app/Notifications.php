<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notifications
 * @mixin \Eloquent
 */
class Notifications extends Model{
   
    protected $table = 'notifications';



  	/**
     * Get the notification's body.
     *
     * @param  string  $value
     * @return string
     */
    public function getNotificationAttribute($value)
    {
        return strip_tags($value);
    }

    /**
     * Get the notification's title.
     *
     * @param  string  $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        return ucfirst($value);
    }



}
