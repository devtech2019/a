<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Requests\BaseFormRequest;


class TeamCreateRequest extends BaseFormRequest
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
            //
            'name'      => 'required|min:3|max:100',
           // 'email'     => 'required|unique:teams',
            'email'     => 'required|email|unique:users',
            //'sex'       => 'required',
            'mobile'    => 'required|numeric|digits:10',
            'dob'       => 'required',
            'address'   => 'required',
            'phone'      => 'required|numeric|digits_between:5,10',
            'post'      => 'required',
            'status'    => 'required',
            'join_date' => 'required|after_or_equal:dob',
            'photo'     => 'required|image|mimes:jpeg,png,jpg|max:6000',
        ];
    }
    public function messages(){
        return [
        'dob.required' 		=> 'The foundation date field is required',
        'phone.required' 		=> 'The phone no field is required',
        ];
    }

    
}
