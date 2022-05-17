<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social_team extends Model
{
    //
    protected $fillable = [
      'url',
      'team_id',
      'social',
      'social_icon',
    ];

     /**
     * Get the social team validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'url' => 'required|url',
            'social' => 'required',
            'social_icon' => 'required',
        ];
    }
    

    public function teams(){
      return $this->belongsTo('App\Team', 'team_id');
    }

}
