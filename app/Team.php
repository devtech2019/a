<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password', 'photo', 'dob', 'mobile', 'phone', 'address', 'join_date', 'status', 'post','user_id',
    ];

    public function social_teams(){
      return $this->hasOne('App\Social_team');
    }
    public function userFranchise() {
      return $this->hasMany('App\UserFranchise', 'franchise_id');
    }

    public function team_task() {
      return $this->hasOne('App\Team_task');
    }
     public function teamCleaners(){
   
    return $this->hasMany('App\UserFranchise','franchise_id');

  }
}
