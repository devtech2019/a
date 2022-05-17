<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company_social;
use App\Service;
use App\Opening_hour;
use App\Contact;
use Mail,Validator;

class contactMailController extends Controller
{
    public function index()
    {
      $company_socials = Company_social::all();
      $services = Service::all();
      $opening_times = Opening_hour::all();
      $contacts = Contact::all();
      return view('contact', compact('company_socials', 'services', 'opening_times', 'contacts'));
    }

    public function send(Request $request){   
      
        $formData = $request->all();
        $rules  = array(
          'name'            =>  'required',
          'email'           =>  'required|email',
          'subject'         =>  'required',
          'message'         =>  'required|min:10',
        );
        $rulesmsg     = array(
            'name.required'           =>  trans('Please enter your password.'),
            'email.same'              =>  trans('Please enter your email.'),
            'subject.same'            =>  trans('Please enter your subject.'),
            'message.same'            =>  trans('Please enter your message.'),
        );
        if(isset($formData['api_from']) && !empty($formData['api_from'])){
          $validator          =   Validator::make($formData, $rules, $rulesmsg);
          if ($validator->fails()){ 
              $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
              return $response;
          }    
        }else{
          $this->validate($request->all(),$rules,$rulesmsg);
        }

        \App\ContactUs::create($formData);
        
        // $to               =   $request->email;
        // $to_name          =   ucwords($request->name);
        // $full_name        =   $request->name;
        // $from             =   "carwash@getnada.com";
        // $action           =   "contact_us";        
        // $rep_Array        =   array($full_name,$request->subject); 
        // CustomHelper::callSendMail($to,$to_name,$rep_Array,$action,$from);

        if(isset($formData['api_from']) && !empty($formData['api_from'])){
          return $response = array('status' =>  "success",'message'   =>  'Your request has been sent successfully our team will contact you asap.');
        }else{
          return back()->with('added', 'Your request has been sent successfully our team will contact you asap.');
        }

    }
}
