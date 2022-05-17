<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountingServices
 * @mixin Model
 */
class AccountingServices extends Model{

    protected $table = 'accounting_services';
    protected $fillable = [
        'amount',  'date','franchise_id'
    ];


     
}
