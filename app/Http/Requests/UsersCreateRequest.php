<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use App\Http\Requests\BaseFormRequest;

use Config,Auth;

class UsersCreateRequest extends BaseFormRequest{


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
        $authUser   =   Auth::user();
        if(isset($input['api_from']) && empty($input['api_from'])){
            if(Auth::user()->role  ==  "S"){
                $input['role']          = "C";
                $input['franchise_id']  = Auth::user()->id;
            }
        }
        $rules  =    [
            'name'      => 'required|min:2|max:100',
            'role'      => 'required',    
            'email'     => 'required|email|unique:users',
            //'gender'  => 'required',
            //'dob'       => 'required',
            'mobile'    => 'required|numeric|digits:10',
            // 'address' => 'required|max:200',
        ];

        if (!is_null($request->file('photo'))) {
            $rules['photo']     = 'image|mimes:jpeg,png,jpg|max:6000';
        }
        if (!is_null($request->dob)) {
            $rules['dob']     = 'required';
        }
        if(isset($input['role']) && $input['role']   ==  'C'){
            $rules['police_clearance']      =   'required';
            $rules['license_no']            =   'required|min:6|max:20|unique:users';
            if(Auth::user()->role  !=  "S"){
                $rules['franchise_id']          =   'required';
            }
        }
        if(isset($input['api_from']) && empty($input['api_from'])){

            if(Auth::user()->role  !=  "S"){
                $rules['role']          =   'required';
            }
            $rules['password']          =   'required';

        }
        if(isset($input['phone']) && !empty($input['phone'])){
            $rules['phone']  =  'integer';
        }

        return  $rules;
    }

}
