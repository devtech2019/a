<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class CompanySocialUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */



     public function rules()
    {
        return [
            'link'=> 'required|url',
            'social_icon'=> 'required',         
            'social_site'=> 'required',   
        ];
    }
  
}
