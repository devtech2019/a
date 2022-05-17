<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamUpdateRequest extends FormRequest
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
          'name'      => 'required|min:3|max:100',
          'email'     => 'required|email|unique:teams,email,'.$this->team.',id', 
          'phone'      => 'required|numeric|digits_between:1,10',
          //'email'     => 'required|email|unique:users,email,'.$this->user.',id', 
          'mobile'    => 'required|numeric|digits:10',
          'dob'       => 'required',
          'address'   => 'required',
          'post'      => 'required',
          'status'    => 'required',
          'join_date' => 'required|after_or_equal:dob',
          'photo'     => 'image|mimes:jpeg,png,jpg|max:6000',
        ];
    }
}
