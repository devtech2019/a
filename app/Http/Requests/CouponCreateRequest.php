<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CouponCreateRequest extends FormRequest
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
            'coupon_code'      => 'required|unique:coupons|min:2|max:20',
            'value_type'       => 'required',
            // 'value'         => 'required|integer',
            'start_date'       => 'required|after_or_equal:today',
            'end_date'         => 'required|after_or_equal:start_date',
            'coupon_limit'     => 'required|numeric|min:1|digits_between:1,10',
            'status'           => 'required',

        ];
      


        if(isset($data['value_type']) && !empty($data['value_type']) && $data['value_type'] == '%'){
            $rules['value']    = 'required|numeric|min:1|max:100';
        }else{
            $rules['value']    = 'required|numeric|min:1';
        } 
        return $rules;

    }
    
}
