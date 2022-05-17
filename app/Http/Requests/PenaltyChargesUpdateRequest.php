<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PenaltyChargesUpdateRequest extends FormRequest
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
            'cancellation_before'   => 'required',
            'cancellation_within'   => 'required',
            'cancellation_after'   => 'required',
           
            // 'value'         => 'required|integer',
           
        ];
      


        if(isset($data['cancellation_before']) && !empty($data['cancellation_before']) && $data['cancellation_before'] == '%'){
            $rules['cancellation_before_value']    = 'required|integer|min:1|max:100';
        }else{
            $rules['cancellation_before_value']    = 'required|integer|min:1';
        } 

        if(isset($data['cancellation_within']) && !empty($data['cancellation_within']) && $data['cancellation_within'] == '%'){
            $rules['cancellation_within_value']    = 'required|integer|min:1|max:100';
        }else{
            $rules['cancellation_within_value']    = 'required|integer|min:1';
        } 

        if(isset($data['cancellation_after']) && !empty($data['cancellation_after']) && $data['cancellation_after'] == '%'){
            $rules['cancellation_after_value']    = 'required|integer|min:1|max:100';
        }else{
            $rules['cancellation_after_value']    = 'required|integer|min:1';
        } 

        return $rules;

    }
    
}
