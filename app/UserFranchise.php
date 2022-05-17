<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFranchise extends Model
{
    //
  
    protected $table = 'users_franchise';


    public function userCleaners(){
   
        return $this->belongsTo('App\User','user_id');

    }
 
  // public function users(){
   
  //   return $this->belongsTo(App\User::class, 'user_id');

  // }
      /**
     * Get the url to the photo
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->urlForName($this->photo);
    }


    /**
     * Get the url for the file name (specify thumb, default, original)
     * @param $name
     * @return string
     */
    public function urlForName($name)
    {
        return asset('public/images/users/').$name;
    }  

    
}
