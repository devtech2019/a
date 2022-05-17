<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\FranchiseRequest;
use App\libraries\CustomHelper;
use App\User;
use Validator,Redirect;

class ApplyFranchiseController extends Controller{
 
    /**
     * Remove the save franchise
     * @param  Request  $request
     * @return \Illuminate\Http\Response
    */
    public function savefranchise(Request $request){
        $input	=	$request->all();
		if(!empty($input)){
			$validator = Validator::make(
				$request->all(),
				array(
					'email' 			=> 'required|email',
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{
       FranchiseRequest::create($input);
        if(isset( $request->email) && !empty( $request->email)){
       
          $contactdetail   =    User::where('role','A')->first();
          $to              =    $contactdetail->email;
          $to_name         =    ucwords("Hello Admin");
          $admin_name      =    $input['name']??'';
          $full_name       =    $contactdetail->name;
          $email           =    $input['email']??'';
          $contact_no      =    $input['contact_no']??'';
          $company_name    =    $input['company_name']??'';
          $address         =    $input['address']??'';
          $state           =    $input['state']??'';
          $city            =    $input['city']??'';
          $pincode         =    $input['pincode']??'';
          // $content      =    $input['name']."has mail id".$input['email']."!!This franchise want to send you request to register";
          $action          =     "apply_franchise_registration"; 
          $rep_Array       =     array($admin_name,$email, $contact_no,$company_name,$address,$state,$city,$pincode); 
         
          CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);
          if(isset( $input['email']) && !empty( $input['email'])){

          $to               =    $input['email'];
          $to_name          =   ucwords($request->name);
          $full_name        =   $input['name'];
          $from             =    $contactdetail->name;
          $action           =   "apply_franchise";     
          $rep_Array        =   array($full_name,$request->name,$request->email); 
         //dd( $full_name,$to,$to_name,$rep_Array,$action1,$from  );
        $data = CustomHelper::callSendMail($to,$to_name,$rep_Array,$action,$from);
     
          } 
       
              // Toastr::success('Your password has been reset successfully.:)','success');
              return back()->with('success','franchise send request successfully!');
         
            
        
        }    
    }
    }
    }
}
