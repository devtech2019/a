<?php 

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

abstract class BaseFormRequest extends FormRequest {

    /**
     * @overrride
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) : void{   

        if(Request::get('api_from')){
            // return ["status"=>"error","errors"=>$validator->errors()->toArray()];
            // die;
            throw new HttpResponseException(response()->json(["status"=>"error","message"=>$validator->errors()->toArray()], 200));
        }
        throw (new ValidationException($validator))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }

}