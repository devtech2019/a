<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\ContactUs;
use App\EmailAction;
use App\User;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Validator;
class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
          'logo' => 'image|mimes:jpeg,png,jpg',
          'gst'  => 'required|numeric',
          'mobile'  => 'required|numeric',
          'phone'  => 'required|numeric',
          'logo_two' => 'image|mimes:jpeg,png,jpg',
        ]);

        $input = $request->all();
        $file = $request->file('logo');
        $file2 = $request->file('logo_two');

        $name = $file->getClientOriginalName();
        $name2 = $file2->getClientOriginalName();

        $file->move('images/logo', $name);
        $file2->move('images/logo', $name2);

        $input['logo'] = $name;
        $input['logo_two'] = $name2;

        Contact::create($input);

        return back()->with('added', 'Record Has Been Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $request->validate([
          'logo' => 'image|mimes:jpeg,png,jpg',
          'logo_two' => 'image|mimes:jpeg,png,jpg',
          'mobile'  => 'required|numeric',
          'phone'  => 'required|numeric',
          'gst'  => 'required|numeric',
          'android_apk'  => 'required|max:120',
          'ios_ipa'  => 'required|max:120',
          'google_address_key'  => 'required|max:120',
        ]);

        $contact = Contact::findOrFail($id);
        $input = $request->all();

         if ( $request->file('logo')) {
            $file = $request->file('logo');
            $name = $file->getClientOriginalName();
            $file->move(base_path('public/images/'), $name);

            if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                unlink(public_path($name));
            };
            $input['logo'] = $name;

        }
        if ($request->file('logo_two')) {
            $file2 = $request->file('logo_two');
            $name = $file2->getClientOriginalName();
           $file2->move(base_path('public/images/'), $name);
            if (file_exists(public_path($name2 = $file2->getClientOriginalName()))) {
                unlink(public_path($name2));
            };
            $input['logo_two'] = $name2;

        }
      
        $contact['app_address'] = $input['app_address'];
        // $input['logo'] = $name;
        // $input['logo_two'] = $name2;
        $contact->update($input);
        return back()->with('updated', 'Record Has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        unlink(public_path() . '/images/logo/' . $contact->logo);

        $contact->delete();

        return back()->with('deleted', 'Record Has Been Deleted');
    }
    // public function contactData(Request $request,$id)
    // {
    //   $reply  = ContactUs::where('id',$id)->first(); 
    //  Session::flash('contact_us', 'You are successfully contact us');
    //  return view('reports.reply',compact('reply')); 
    // }

     public function savecontact(Request $request)
    {
       
        $formData = $request->all();
       
    
        $rules  = array(
          'name'            =>  'required',
          'email'           =>  'required|email',
          'subject'         =>  'required',
          'message'         =>  'required|min:5',
        );
        $rulesmsg     = array(
            'name.required'           =>  trans('Please enter your name.'),
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

          $validator          =   Validator::make($formData, $rules, $rulesmsg);

          if ($validator->fails()){ 

               return redirect()->back()->withInput($request->all())->withErrors($validator->errors());

          }    
        }  


        \App\ContactUs::create($formData);

        $contactdetail    =   User::where('role','A')->first(); 
       
        $to               =   $contactdetail->email;
        $to_name          =   ucwords($request->name);
        $full_name        =   $contactdetail->name;
        $from             =   $formData['email'];
        $action           =   "contact_us_reply";        
        $rep_Array        =   array($full_name,$request->name,$request->email,$request->subject,$request->message,); 
         
        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action,$from);
        

        // $contactperson    =   User::where('email', $formData['email'])->first(); 
    
       
        $to               =   $formData['email'];
        $to_name          =   ucwords($request->name);
        $full_name        =  $formData['name'];
        $from             =    $contactdetail['email'];
        $action           =   "new_user_contact_us";     
        // pr( $action )   ;
        $rep_Array        =   array($full_name,$request->name,$request->email,$request->subject,$request->message,); 
         
        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action,$from);

        if(isset($formData['api_from']) && !empty($formData['api_from'])){
            return $response = array('status' =>  "success",'message'   =>  'Your request has been sent successfully our team will contact you asap.');
          }else{
              // Toastr::success('Your password has been reset successfully.:)','success');
            return back()->with('success', 'Your request has been sent successfully our team will contact you asap.');
          }
    }   
}
