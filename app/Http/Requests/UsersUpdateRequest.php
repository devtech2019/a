<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Config,Auth;
class UsersUpdateRequest extends FormRequest
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
    public function rules(Request $request){

        $input  = $request->all();
        if(Auth::user()->role  ==  "S"){
            $input['role']          = "S";
            $input['franchise_id']  = Auth::user()->id;
        }
        
        $rules  =    [
            'name'      => 'required|min:2|max:100',
            'email'     => 'required|email|unique:users,email,'.$this->user.',id', 
            'gender'       => 'required',
            'dob'       => 'required',
            'mobile'    => 'required|numeric|digits:10',
            'address'   => 'required',
          
        ];


        if($input['role']   ==  'C'){
            $rules['police_clearance']  =   'required';
              $rules['franchise_id']  =   'required';
            $rules['license_no']        =   'required|min:13|unique:users,license_no,'.$this->user.',id';
        }
         if(Auth::user()->role  !=  "S"){
            $rules['role']          =   'required';
        }

        if(isset($input['phone']) && !empty($input['phone'])){
            $rules['phone']  =  'integer';  
        }

        if(isset($input['photo']) && !empty($input['photo'])){
            $rules['photo']     = 'image|mimes:jpeg,png,jpg|max:6000';
        }
       
        return  $rules;
    }
}
