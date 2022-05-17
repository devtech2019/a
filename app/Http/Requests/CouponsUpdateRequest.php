<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class CouponsUpdateRequest extends FormRequest
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



     public function rules(Request $request)
    {  
        $data   =   $request->all();


        $rules  =   [
            'applicable_for'   => 'required',
            'title'            => 'required|min:3|max:100',
            'description'      => 'required|max:255',
            'coupon_code'      => 'required|min:2|max:20',
            'value_type'       => 'required',
            // 'value'            => 'required|integer',
            'start_date'       => 'required',
            'end_date'         => 'required|after_or_equal:start_date',
            'coupon_limit'     => 'required|integer|min:1|digits_between:1,10',
            'status'           => 'required',
        ];
      


        if(isset($data['value_type']) && !empty($data['value_type']) && $data['value_type'] == '%'){
            $rules['value']    = 'required|integer|min:1|max:100';
        }else{
            $rules['value']    = 'required|integer|min:1';
        } 
        return $rules;

    }
  
}
