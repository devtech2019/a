<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FaqCategoryRequest extends FormRequest
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

      $rules = [
        // 'name' => 'required',
    ];
    if(isset($data) && !empty($data->name)){
      
        $rules['name']    = 'required';
      
    }else{
        
        $rules['name']  = 'required|min:3:max:255|unique:faq_categories';
    }
    return $rules;
}
    
}
