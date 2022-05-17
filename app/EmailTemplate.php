<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmailTemplate
 * @mixin \Eloquent
 */
class EmailTemplate extends Model{
    
    protected $table = 'email_templates';

      public function rules()
    {
        return [
            'name'      => 'required',
            'subject'     => 'required|min:25',
            
        ];
    }

}
