<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  protected $table = 'settings';
  
    protected $fillable = [
      'c_name',
      'logo',
      'google_address_key',
      'logo_two',
      'mobile',
      'phone',
      'address',
      'street_address',
      'email',
      'website',
      'gst',
      'twitter',
      'instagram',
      'android_apk',
      'ios_ipa',
    ];
}
