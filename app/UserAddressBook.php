<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


/**
 * Class UserAddressBook
 * @mixin Model
 */
class UserAddressBook extends Model{


    protected $table = 'user_address_book';

    protected $fillable = [
        'user_id',  'pin_code', 'location', 'city', 'state','address','lat','lng'
    ];

     
}
