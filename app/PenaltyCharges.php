<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 * @mixin \Eloquent
 */
class PenaltyCharges extends Model{
    
    // protected $table = 'penalty_charges';

    protected $fillable = [
        'cancellation_before', 'cancellation_within', 'cancellation_after', 'cancellation_before_value', 'cancellation_within_value', 'cancellation_after_value',
    ];

}
