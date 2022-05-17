<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
   protected $table = 'add_on_services';
   protected $fillable = [
        'name', 'price', 'description', 'status', 'duration',
    ];
     
    
}
