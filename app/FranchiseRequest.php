<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FranchiseRequest extends Model
{
   protected $table = 'franchise_requests';
   protected $fillable = [
        'name', 'email', 'contact_no', 'company_name', 'address', 'city', 'state', 'pincode', 'status',
    ];      
}
