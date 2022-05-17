<?php
namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Validator,Auth,Config,Hash,URL;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Razorpay\Api\Api;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiController extends BaseController {

    public function __construct(Request $request) {
        header('Access-Control-Allow-Origin: *');
    }


    /**
    * Function for user login
    *
    * @param $formData as formData
    *
    * @return reponse.
    */
    public function login(Request $request){
        
    
        $formData   =   $request->all();

        $userdata   =   $response   =   array();
        $status     =   "error";
        $message    =   '';
        if(filter_var(trim($formData['email']), FILTER_VALIDATE_EMAIL)){
            $userdata = array(
                'email'         => strtolower(trim($formData['email'])),
                'password'      => $formData['password'],
            );
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($userdata)) {
                $response['status']     =   'error';
                $response['message']    =   'invalid credentials';
                return $response;
            }
        } catch (JWTException $e) {
            $response['status']     =   'error';
            $response['message']    =   'could not create token';
            return $response;
        }


        if (Auth::attempt($userdata)){
            if(!in_array(Auth::user()->role, array('U','C'))){
                Auth::logout();
                $message    =   trans("Invalid access.");                
            }               
            
            if(Auth::check()){
                $fullname   =   Auth::user()->name;
                //Check login condition for Auth User
                if(Auth::check() && (Auth::user()->role == 'C' || Auth::user()->role == 'U')){
                    if(Auth::check() && Auth::user()->is_block == 1){
                        Auth::logout();
                        $message    =   trans("messages.login.account_blocked");
                    }

                    // if(Auth::check() && Auth::user()->is_verified == Config::get('app.IS_NOT_VERIFIED')){
                    //     Auth::logout();
                    //     $message    =   trans("messages.login.account_unverified");
                    // }

                    if(Auth::check() && Auth::user()->is_verified == Config::get('app.IS_NOT_VERIFIED')){
                        $otp_number                 =   Config::get('app.OTP_NUMBERS');

                        \App\User::where('id',Auth::user()->id)->update([
                            'otp_number'=>$otp_number,
                            'verification_otp_time'=>strtotime(Config::get('app.FORGOT_OTP_TIME')),
                            'resend_otp_time'=>strtotime(Config::get('app.RESEND_OTP_TIME'))
                        ]);

                        // Send OTP sms to user
                        $mobile_no  = Auth::user()->mobile;
                        if(!empty($mobile_no)){
                            //CustomHelper::SendSms("9024649131","hello ");

                            /*CustomHelper::_SendOtp('account_verification', $mobile_no, $otp_number);
                            $action         =   "resend_otp";
                            $rep_Array      =   array($to_name, $otp_number);
                            CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                        }

                        $response['is_verified']            =   0;
                        $response['email']                  =   strtolower(Auth::user()->email);
                        $response['mobile']                 =   $mobile_no;
                        $response['otp']                    =   $otp_number;
                        $message    =   trans("Mobile verification is pending.");
                        Auth::logout();
                    }

                    if(Auth::user()){
                        $msg        =   ucfirst($fullname).", ".trans("You are successfully loggedin.");
                        //$token = JWTAuth::attempt($userdata); 
                        $userData   =   Auth::user()->toArray();
                        //$userData['token']    =   $token;
                        //$image                    =   isset($userData['image'])?$userData['image']:'';
                        //$userData['image_url']    =   CustomHelper::getUserImageUrl(USER_PROFILE_IMAGE_ROOT_PATH,USER_IMG_ONTHEFLY_PATH,$image);

                        $userData['user_img_url']   =   Config::get('app.USERS_IMG_URL');
                        $response['user_data']      =   $userData;
                        $status     =   "success";
                        $message    =   $msg;
                    }
                }
            }else{
                $message    =   trans("messages.dashboard.you_are_not_authorized_to_access_this_location");
            }
        }else{        
            $message    =   trans("Incorrect credential");
        }

        $response['status']     =   $status;
        $response['message']    =   $message;
        $response['token']      =   $token;
        return $response;
    }// end login()


    /**
     * LoginValidationHelper:: userForgetPassword()
     * @function for user Forget Password
     * @Used in overAll System
     * @param $form data as form data
     * @param $attribute as attribute array
     * @return response array
     */
    public static function userForgetPassword(Request $request){
        $response               =   array();
        $formData               =   $request->all();

        $message = array(
            'email.required'    => trans("Please enter a email address."),
            'email.email'       => trans("Please enter valid email address."),
        );

        $validate               =   array('email'  => 'required|email');
        $validator              =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }
        $email      =   isset($formData['email'])?$formData['email']:'';  
        $userDetail =   \App\User::where('email',$email)->first();


        $allowUsers =   array('U','C');
        if(!empty($userDetail) && in_array($userDetail->role,$allowUsers)){
            if(!empty($userDetail) && ($userDetail->role == 'C' || $userDetail->role == 'U')){
                if($userDetail->is_block == 0){
                        $otp_number                         =   Config::get('app.OTP_NUMBERS');
                        \App\User::where('email',$email)->update(array(
                            'forgot_otp_number'                     =>  $otp_number,
                            'forgot_verification_otp_time'          =>  strtotime(Config::get('app.FORGOT_OTP_TIME')),
                            'forgot_resend_otp_time'                =>  strtotime(Config::get('app.RESEND_OTP_TIME')),
                        ));
                
                        $data['phone']          =   $userDetail->mobile;
                        $data['forgot_otp']     =   $otp_number;
                        $data['email']          =   $userDetail->email;
                        $data['full_name']      =   ucwords($userDetail->name);
                        $data['user_role']      =   $userDetail->role;
                        
                        $response['status']     =   'success';
                        $response['data']       =   $data;
                        $response['message']    =   trans('Forget password verification otp sent successfully on your mobile number.');
                        return $response;

                }else{
                    $response['message']    =   trans('Your account has been blocked.');
                    $response['status']     =   'error';
                    return $response;
                }
            } else {
                $response['message']    =   trans('An email verification OTP has been sent on your reigsterd ').' '.$email.'. '.trans('Please check your email.');
                $response['status']   =   'success';
                return $response;
            }
        }else{
            $response['message']    =   trans('we could not find your email in our system if your email exists then OTP has been sent on').' '.$email.'. ';
            $response['status']   =   'success';
            return $response;
        }
    }//end userForgetPassword()


    /**
    * Function for verify Forgot Otp
    *
    * @param $formData as formData
    *
    * @return reponse.
    */
    public function verifyForgotOtp(Request $request){

        $formData       =   $request->all();
        $response       =   array();
        $from           =   'api';
        $model          =   'User';
        $pageSlug       =   'forgot_password';
        $attribute      =   array('model'=>$model,'from'=>$from,'pageSlug'=> $pageSlug);
        $response       =   $this->userVerifyOtp($formData,$attribute);
        
        if($response['status']=="error"){
            if(isset($response['validator']) && !empty($response['validator'])){
                $response['errors'] =   $response['validator']->errors()->toArray(); 
                unset($response['validator']);
            }else{
                $response['message'] =   $response['data']['message'];
                unset($response['data']);
            }
        }else{
            $response['message']    =   trans("OTP has been send successfully.");
        }
        return $response;
    }// end verifyForgotOtp()


    /**
     * function for resend otp 
     *
     * @param $formData as form data
     *
     * @return mail
    */
    public function resendOtp(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();      
  
        $emailId    =   isset($formData['otp_verify_invisible_slug']) && !empty($formData['otp_verify_invisible_slug']) ? $formData['otp_verify_invisible_slug'] : '';
        if (!empty($emailId)) {
            if (isset($formData['resend_otp_from']) && !empty($formData['resend_otp_from'])) {

                $userInfo = \App\User::where('email',$emailId)->first();
                if(!empty($userInfo)) {
                    $otp    =   "1234";
                    if ($formData['resend_otp_from'] == "verifysignupotp") {
                        $userInfo->verification_otp_time            =   strtotime(Config::get('app.FORGOT_OTP_TIME'));
                        $userInfo->resend_otp_time                  =   strtotime(Config::get('app.RESEND_OTP_TIME'));
                        $userInfo->otp_number                       =   $otp;
                    }else{
                        $userInfo->forgot_verification_otp_time     =   strtotime(Config::get('app.FORGOT_OTP_TIME'));
                        $userInfo->forgot_resend_otp_time           =   strtotime(Config::get('app.RESEND_OTP_TIME'));
                        $userInfo->forgot_otp_number                =   $otp;
                    }
                    $userInfo->save();

                    /*Re Send OTP sms to user */
                    if(!empty($userInfo->mobile)){
                        $mobile_no  = $userInfo->mobile;
                        //CustomHelper::_SendOtp('resend_otp', $mobile_no, $otp);

                        //CustomHelper::SendSms("9024649131","hello ");

                    }
                    
                    //Re Send OTP mail to user
                    if(!empty($userInfo->email)){
                        /*$to               =   $userInfo->email;
                        $to_name        =   ucwords($userInfo->full_name);
                        $username       =   $to_name;
                        $otp            =   $otp;
                        $action         =   "resend_otp";
                        $rep_Array      =   array($username, $otp);
                        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                    }
                    $response['status'] =   'success';
                    $response['message'] =   trans('OTP has been sent on your mobile number.');
                    return $response;
                }else{
                    $response['status'] =   'error';
                    $response['message'] =   trans('Sorry you are using wrong link.');
                    return $response;
                }
            }else{
                $response['status'] =   'error';
                $response['message'] =   trans('Sorry you are using wrong link.');
            }
        }else{
            $response['status'] =   'error';
            $response['message'] =   trans('Sorry you are using wrong link.');
        }
        return $response;
    }//end _resendOtp()


    /**
    * Function for verify signup otp
    *
    * @param $formData as formData
    *
    * @return reponse.
    */
    public function verifySignupOtp(Request $request){ 
        $formData       =   $request->all();

        $response       =   array();
        $from           =   'api';
        $model          =   'User';
        $attribute      =   array('model'=>$model,'from'=>$from,'pageSlug'=> '');
        $response       =   $this->userVerifyOtp($formData,$attribute);
        
        if($response['status']  ==  "error"){
            if(isset($response['validator']) && !empty($response['validator'])){
                $response['errors'] =   $response['validator']->errors()->toArray(); 
                unset($response['validator']);
            }else{
                $response['message'] =   $response['data']['message'];
                unset($response['data']);
            }
        }else{
            $response['message']    =   trans("OTP verification has been done successfully.");
        }
        return $response;
    }// end verifySignupOtp()

    /**
     * ApiController:: userVerifyOtp()
     * @function for resend Verification Link 
     * @Used in overAll System
     * @param $form data as form data
     * @param $attribute as attribute array
     * @return response array
    */
    public function userVerifyOtp($formData = array(),$attribute = array()){
        if(!empty($formData)){
           
            $pageSlug       =   $attribute['pageSlug'];
            $from           =   $attribute['from'];
            $model          =   $attribute['model'];
             
            //Check validation
            $message = array(
                'otp_verify.required'       =>  trans('otp verify is required'),
                'otp_verify.numeric'        =>  trans('Please enter a valid OTP'),
                'otp_verify.digits'         =>  trans('Please enter a valid OTP'),
                'otp_verify.check_otp'      =>  trans('Please enter a valid OTP'),
            );
            $validate = array(
                'otp_verify' => 'required|numeric|digits:4',
            );
            $validator                   = Validator::make($formData, $validate, $message);
            if($validator->fails()){ 
                $response = array('status'=>"error",'validator'=>$validator);
                return $response;
            }
            
            $userEmail      =   $formData['user_email'];
            if(!empty($pageSlug)){ // Forgot Time
                $userDetails    =   \App\User::where('email',$userEmail)->select('forgot_otp_number as otp_number','forgot_verification_otp_time as verification_otp_time','id')->first()->toArray();
            }else{

                $userDetails    =   \App\User::where('email',$userEmail)->select('otp_number','verification_otp_time','id')->first()->toArray();
            }

            if($userDetails['otp_number'] == $formData['otp_verify']){

                $userid     =   $userDetails['id'];
                if($userDetails['verification_otp_time'] < time()){             
                    $data['message']    =   trans('otp has been expired');
                    $data['msg_type']   =   'error';
                    $response           =   array('status'=>"error",'data'=>$data);
                    return $response;
                }else{          

                    if(!empty($pageSlug)){

                        \App\User::where('id',$userid)->update(array(
                            //'forgot_otp_number'                     =>  null,
                            'forgot_verification_otp_time'          =>  null,
                            'forgot_resend_otp_time'                =>  null,
                        ));

                        $response           =   array('status'=>"success",'data'=>['userid'=>$userid,'user_email'=>$userEmail,'otp'=>$formData['otp_verify']]);
                        return $response;
                    }else{
                        \App\User::where('id',$userid)->update(array(
                            'is_verified'                       =>  1,
                            'otp_number'                        =>  null,
                            'verification_otp_time'             =>  null,
                            'resend_otp_time'                   =>  null,
                        ));
                        $response           =   array('status'=>"success",'data'=>['userid'=>$userid,'userDetails'=>$userDetails]);
                        return $response;
                    }
                    
                }
            }else{
                $data['message']    =   trans('OTP is not validate.');
                $data['msg_type']   =   'error';
                $data['route']      =   'verify-otp';
                $response           =   array('status'=>"error",'data'=>$data);
                return $response;
            }
        }else{
            $data['message']    =   trans("OTP is not validate.");
            $data['msg_type']   =   'error';
            $response           =   array('status'=>"error",'data'=>$data);
            return $response;
        }
    }//end userVerifyOtp

    /**
     * ApiController:: userResetPasswordValidationAndSave()
     * @function for user Reset Password
     * @Used in overAll System
     * @param $form data as form data
     * @param $attribute as attribute array
     * @return response array
    */
    public function userResetPasswordValidationAndSave(Request $request){
        $response                   =   array();
        $formData                   =   $request->all();

        /* define validatation messages */
        $message = array(
            'password.required'                 =>  trans('Please enter your password.'),
            'confirm_password.same'             =>  trans('Password does not match'),
        );
        /* define validation */
        $validate = array(
            'password'                  =>  'required',
            'confirm_password'          =>  'same:password',
        );
        $validator          =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }       
        $newPassword        =   $formData['password'];
        $newPassword        =   Hash::make($newPassword);
        $otpNumber          =   $formData['otp_number'];
        $email              =   strtolower($formData['email']);
        $userInfo           =   \App\User::where('email',$email)->where('forgot_otp_number',$otpNumber)->first();

        if(isset($userInfo) && !empty($userInfo)){
                    

            \App\User::where('email',$email)
            ->where('forgot_otp_number',$otpNumber)
            ->update(array(
                'password'                          =>  $newPassword,
                'forgot_otp_number'                 =>  null
            ));
            $response = array(
                'status'    =>  "success",
                'data'      =>  [
                                    'userType'=> $userInfo->role,
                                    'email'=>$userInfo->email,
                                    'full_name'=>ucwords($userInfo->name)
                                ],
                'message'   =>  'Your password has been changed successfully now you can login with your new password.'
                );
            return $response;
        }else{
            $response = array('status'=>"error",'message'=>'Something went wrong.');
            return $response;
        }
    }//end userResetPasswordValidationAndSave()

    /**
     * ApiController:: faqList()
     * @function for faq List
     * @Used in overAll System
     * @param null
     * @return response array
    */
    public function faqList(){
        $faqList  =      \App\FAQ::orderBy('id', 'DESC')->get()->toArray();
        if(isset($faqList) && !empty($faqList)){         
            foreach ($faqList as $key => $value) {
                $faqList[$key]['answer']    =   strip_tags($value['answer']);
            }
            $response = array(
                'status'    =>  "success",
                'data'      =>  $faqList,
                'message'   =>  ''
            );
        }else{
            $response = array('status'=>"success",'message'=>'No Record Found','data' =>  []);
        }
        return $response;
    }//end faqList()

    /**
     * ApiController:: carwashDetails()
     * @function for contacts Details
     * @Used in overAll System
     * @param null
     * @return response array
    */
    public function carwashDetails(){
        $contactsDetails  =      \App\Contact::get()->toArray();
        if(isset($contactsDetails) && !empty($contactsDetails)){         
            
            $response = array(
                'status'    =>  "success",
                'data'      =>  $contactsDetails,
                'message'   =>  ''
            );
        }else{
            $response = array('status'=>"success",'message'=>'No Record Found','data' =>  []);
        }
        return $response;
    }//end carwashDetails()


    /**
     * Function for save change passwaord page
     * @param null
     * @return null
    */
    public function changePassword(Request $request) {
        $response                   =   array();
        $formData                   =   $request->all();

        /* define validatation messages */
        $message = array(
            'current_password.required'         =>  trans('Please enter your current password.'),
            'password.required'                 =>  trans('Please enter your password.'),
            'confirm_password.same'             =>  trans('Password does not match'),
        );
        /* define validation */
        $validate = array(
            'current_password'          =>  'required',
            'password'                  =>  'required',
            'confirm_password'          =>  'same:password',
        );
        $validator          =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }       
        $currentPassword    =   $formData['current_password'];
        $currentPassword    =   Hash::make($currentPassword);
        $newPassword        =   $formData['password'];
        $newPassword        =   Hash::make($newPassword);
        $userId             =   $formData['user_id'];
        $userInfo           =   \App\User::where('id',$userId)->first();


        if(isset($userInfo) && !empty($userInfo)){                    
            if (Hash::check($request->current_password, $userInfo->password)) { 
                $userInfo->update(array('password' => $newPassword));
                $response = array(
                    'status'    =>  "success",
                    'message'   =>  'Your password has been changed successfully now you can login with your new password.'
                );
                return $response;
            } else {
                return $response = array('status'=>"error",'message'=>'Password does not match');
            }
        }else{
            return $response = array('status'=>"error",'message'=>'Something went wrong.');
        }
    }//end changePassword()


    /**
     * Function for edit profile
     * @param null
     * @return response
    */
    public function editProfile(Request $request) {
        $response      =   array();
        $formData      =   $request->all();
  
        $userId        =   $formData['user_id'];
        $userInfo      =   \App\User::where('id',$userId)->first();

        /* define validatation messages */
        $message = array(
            'name.required'             =>  trans('Please enter your current password.'),
            'email.required'            =>  trans('Please enter a valid email.'),
            'mobile.required'           =>  trans('Please enter a mobile number.'),
            'photo.image'               =>  trans('Please select a valid image.'),
        );
        /* define validation */
        $validate  =    [
            'name'      => 'required|min:2|max:100',
            'email'     => 'required|email|unique:users,email,'.$userId.',id', 
            'mobile'    => 'required|numeric|digits:10',          
        ];

        if (!is_null($request->file('photo'))) {
            $validate['photo']     = 'image|mimes:jpeg,png,jpg|max:6000';
        }

        // if(isset($formData['photo']) && !empty($formData['photo'])){
        //     $validate['photo']     = 'image|mimes:jpeg,png,jpg|max:6000';
        // } 


        $validator          =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }       

        if(isset($userInfo) && !empty($userInfo)){   
            if ($file = $request->file('photo')) {
                $name = $file->getClientOriginalName();
                $file->move(base_path('public/images/users'), $name);
                if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                    unlink(public_path($name));
                };
                $formData['photo'] = $name;
            }

            $formValues                     =   [];
            $formValues['user_id']          =   $userInfo->id;
            if($request->email  !=  $userInfo->email){
                $formValues['type_email']       =   'email';
                $formValues['temp_email_id']    =   $request->email;
            }
            if($request->mobile  !=  $userInfo->mobile){
                $formValues['mobile_number']    =   $request->mobile;
                $formValues['type_mobile']      =   'mobile';
            }
            $updateValue    =   $this->updateEmailMobile($formValues);
            if(isset($updateValue['status']) && $updateValue['status'] == "error"){
                $response = array(
                    'status'        =>  "error",
                    'message'       =>  'Something went wrong with fiels.'
                );
                return $response;
            }
            unset($formData['email']);
            unset($formData['mobile']);
            $userInfo->update($formData);

            $userData       =   \App\User::where('id',$userId)->first()->toArray();
            $userData['user_img_url']   =   Config::get('app.USERS_IMG_URL');

            $response = array(
                'status'        =>  "success",
                'user_data'     =>  $userData,
                'message'       =>  'Your profile has been updated successfully.'
            );
            return $response;
            
        }else{
            return $response = array('status'=>"error",'message'=>'Something went wrong.');
        }
    }//end editProfile()


    /**
     * Function for get Addresses list
     * @param $formData as formdata
     * @return response
     */
    public function getAddressList(Request $request) {
        $formData       =   $request->all();
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] :'';
        $recordLimit    =   10;
        $page_number    =   isset($formData['page'])?$formData['page']:1;
        $userAddress    =   \App\UserAddressBook::where('user_id',$userId)->orderBy('created_at','DESC')
                            ->paginate((int)$recordLimit,['*'],'page',$page_number)->toArray();
        $response['data']       =   $userAddress;
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getAddressList()
    
    /**
     * Function for get Addresses list
     * @param $formData as formdata
     * @return response
     */
    public function getAddressDetail(Request $request) {
        $formData   =   $request->all();
        $status     =   'error';
        $message    =   '';
        $userId     =   $formData['user_id'];
        $addressId  =   $formData['address_id'];
        
        $userAddress    = \App\UserAddressBook::where('user_id',$userId)->where('id',$addressId)->first();
        if(empty($userAddress)){
            $message    =   trans('Sorry you are using wrong link.'); 
        }else{
            $status             =   "success";
            $response['data']   =   $userAddress->toArray();
        }
        $response['status']     =   $status;
        $response['message']    =   $message;
        return $response;
    }//end getAddressDetail()
    
    /**
     * Function for saveupdate Addresses
     * @param $formData as formdata
     * @return response
     */
    public function saveUpdateAddress(Request $request) {
        $response      =   array();
        $formData      =   $request->all();

        $userId        =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $userAddressId =   isset($formData['address_id']) && !empty($formData['address_id']) ? $formData['address_id'] : '';

        /* define validatation messages */
        $message = array(
            'pin_code.required'     =>  trans('Please enter your pin code.'),
            'location.required'     =>  trans('Please select a location.'),
            'city.required'         =>  trans('Please enter a city.'),
            'state.required'        =>  trans('Please enter a state.'),
            'address.required'      =>  trans('Please enter your address.'),
        );
        /* define validation */
        $validate  =    [
            'pin_code'      => 'required|numeric',
            'location'      => 'required', 
            'city'          => 'required',          
            'state'         => 'required',          
            'address'       => 'required',          
        ];


        $validator          =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }       
      
        $userAddressInfo    =   \App\UserAddressBook::where('user_id',$userId)
                                ->where('id',$userAddressId)->first();

        if(!empty($userAddressInfo)){
            $userAddressInfo->update($formData);
            $message    =   'Your address has been updated successfully.';
        }else{
            \App\UserAddressBook::create($formData);
            $message    =   'Your address has been added successfully.';
        }
        $response = array(
            'status'    =>  "success",
            'message'   =>  $message
        );
        return $response;
    }//end saveUpdateAddress()
    
    /**
     * Function for mark a user address as deleted 
     *
     * @param $address_id as id of address
     *
     * @return response. 
     */
    public function deleteAddress(Request $request){
        $status     =   "error";
        $message    =   '';
        $formData   =   $request->all();
        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            if(isset($formData['address_id']) && !empty($formData['address_id'])){

                $responseData   =   \App\UserAddressBook::where('user_id',$formData['user_id'])
                                    ->where('id',$formData['address_id'])->first();
                
                if(!empty($responseData)){ 
                    $responseData->delete();
                    $status     =   "success";
                    $message    =   trans("Address has been successfully deleted");
                    
                }else{
                    $message    =   trans('Sorry you are using wrong link');
                }
            }else{
                $message        =   trans('Sorry you are using wrong link');
            }
        }else{
            $message            =   trans('Sorry you are using wrong link');
        }
        $response['status']     =   $status;
        $response['message']    =   $message;
        return $response;
    } // end deleteAddress()

    /**
     * Function for get Vechicle Attribute
     * @param Request as $request
     * @return response
    */
    public function getVechicleAttribute(Request $request) {
        $message    =   '';

        $response['data']['vehicle_class_type']     =   \App\Vehicle_type::orderBy('id', 'DESC')
                                                        ->select('id as value','type as label')->get()->toArray();

        $response['data']['vehicle_make_company']   =   \App\Vehicle_company::orderBy('id', 'DESC')
                                                        ->select('id as value','vehicle_company as label')
                                                        ->get()->toArray();

        $response['data']['vehicle_modal']          =   \App\Vehicle_modal::orderBy('id', 'DESC')
                                                        ->select('id as value','vehicle_modal as label')
                                                        ->get()->toArray();

        $response['status']     =   "success";
        $response['message']    =   "";
        return $response;
    }//end getVechicleAttribute()

    /**
     * Function for get ZipCode
     * @param Request as $request
     * @return response
    */
    public function getZipCode(Request $request) {
        $message        =   '';
        $formData       =   $request->all();
        $zipCode        =   isset($formData['zip_code']) && !empty($formData['zip_code']) ? $formData['zip_code'] :'';

        if($zipCode !=  ''){
            $userExists     =   \App\User::where('postal_code',$zipCode)->first();
            if(!empty($userExists)){
                $response['status']     =   "success";
                $response['data']       =   $userExists;
            }else{
                $message                =   "No Zip Code Found.";
                $response['status']     =   "error";
            }
        }else{
            $message                    =   "No Zip Code Found.";
            $response['status']         =   "error";
        }

        $response['message']            =   $message;
        return $response;
    }//end getZipCode()    

    /**
     * Function for get saveNewVehicle
     * @param Request as $request
     * @return response
    */
    public function saveNewVehicle(Request $request) {
        $response      =   array();
        $formData      =   $request->all();

        $userId        =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        /* define validatation messages */
        $message = array(
            'vehicle_registration_no.required'          =>  trans('Please enter your vehicle registration number.'),
            'color.required'                            =>  trans('Please enter your color name.'),
            'vehicle_class.required'                    =>  trans('Please elect vehicle class.'),
            'vehicle_make.required'                     =>  trans('Please select vehicle make.'),
            'vehicle_model.required'                    =>  trans('Please select vehicle model.'),
            'top_photo.required'                        =>  trans('Please select top photo.'),
            'bottom_photo.required'                     =>  trans('Please select bottom photo.'),
            'front_photo.required'                      =>  trans('Please select front photo.'),
            'right_photo.required'                      =>  trans('Please select right photo.'),
            'left_photo.required'                       =>  trans('Please select left photo.'),
        );
        /* define validation */
        $validate  =    [
            'vehicle_registration_no'           => 'required',
            'color'                             => 'required', 
            'vehicle_class'                     => 'required',          
            'vehicle_make'                      => 'required',          
            'vehicle_model'                     => 'required',          
            'top_photo'                         => 'required|image|mimes:jpeg,png,jpg|max:6000',          
            'bottom_photo'                      => 'required|image|mimes:jpeg,png,jpg|max:6000',          
            'front_photo'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
            'right_photo'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
            'left_photo'                        => 'required|image|mimes:jpeg,png,jpg|max:6000',          
        ];


        $validator          =   Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }       
        
        if($file = $request->file('top_photo')) {
            $name = time().'_image_'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/new_vehicle'), $name);
            $formData['top_photo'] = $name;
        }
        if($file = $request->file('bottom_photo')) {
            $name = time().'_image_'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/new_vehicle'), $name);
            $formData['bottom_photo'] = $name;
        }
        if($file = $request->file('front_photo')) {
            $name = time().'_image_'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/new_vehicle'), $name);
            $formData['front_photo'] = $name;
        }
        if($file = $request->file('right_photo')) {
            $name = time().'_image_'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/new_vehicle'), $name);
            $formData['right_photo'] = $name;
        }
        if($file = $request->file('left_photo')) {
            $name = time().'_image_'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/new_vehicle'), $name);
            $formData['left_photo'] = $name;
        }

        \App\UserVehicle::create($formData);
        $message    =   'Your address has been added successfully.';

        $response = array(
            'status'    =>  "success",
            'message'   =>  $message
        );
        return $response;
    }//end saveNewVehicle()

    /**
     * Function for get New Vehicle List
     * @param $formData as formdata
     * @return response
    */
    public function getNewVehicleList(Request $request) {
        $formData       =   $request->all();
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] :'';
        $from           =   isset($formData['from']) && !empty($formData['from']) ? $formData['from'] :'';

        $DB             =   \App\UserVehicle::query();
        if(isset($from) && !empty($from)){
            $userVehicles       =   $DB->with('vehicleClass')->where('user_id',$userId)->orderBy('created_at','DESC')->get()->toArray();
        }else{
             $userVehicles      =   $DB->where('user_id',$userId)->orderBy('created_at','DESC')
                                    ->select('id as value','vehicle_registration_no as label')->get()->toArray();
        }
        

        $response['data']       =   $userVehicles;
        $response['img_url']    =   Config::get('app.FRONT_IMG_URL');
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getNewVehicleList()

     /**
     * Function for get New Vehicle Dtails
     * @param $formData as formdata
     * @return response
    */
    public function getVehicleDetails(Request $request) {
        $formData       =   $request->all();
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] :'';
        $vehicleId      =   isset($formData['vehicle_id']) && !empty($formData['user_id']) ? $formData['vehicle_id'] :'';

        $userVehicles   =   \App\UserVehicle::where('user_id',$userId)->where('id',$vehicleId)
                            ->first();
    
        $response['data']       =   $userVehicles;
        $response['img_url']    =   Config::get('app.FRONT_IMG_URL');
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getNewVehicleList()

    /**
     * Function for mark a user vehicle as deleted 
     *
     * @param $user_id as id of users
     * @param $vehicle_id as vehicle id 
     *
     * @return response. 
    */
    public function deleteUserVehicle(Request $request){
        $status     =   "error";
        $message    =   '';
        $formData   =   $request->all();
        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            if(isset($formData['vehicle_id']) && !empty($formData['vehicle_id'])){

                $responseData   =   \App\UserVehicle::where('user_id',$formData['user_id'])
                                    ->where('id',$formData['vehicle_id'])->first();
                
                if(!empty($responseData)){ 
                    $responseData->delete();
                    $status     =   "success";
                    $message    =   trans("Vehicle has been successfully deleted");
                    
                }else{
                    $message    =   trans('Sorry you are using wrong link');
                }
            }else{
                $message        =   trans('Sorry you are using wrong link');
            }
        }else{
            $message            =   trans('Sorry you are using wrong link');
        }
        $response['status']     =   $status;
        $response['message']    =   $message;
        return $response;
    } // end deleteAddress()


    /**
     * Function for get Wasing Plan list
     * @param $formData as formdata
     * @return response
     */
    public function getWashingPlanList(Request $request) {

        $formData       =   $request->all();
        $washingPlans   =   \App\Washing_price::with('washing_plan','vehicle_type')
                            ->where('vehicle_type_id',1)->get()->toArray();

        $response['data']       =   $washingPlans;
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getWashingPlanList()

    /**
     * Function for get Wasing Plan Details
     * @param $formData as formdata
     * @return response
     */
    public function getWashingPlanDetails(Request $request) {
        $formData       =   $request->all();

        $vehicleType    =   isset($formData['vehicle_type']) && !empty($formData['vehicle_type']) ? $formData['vehicle_type'] : "";
        $planId         =   isset($formData['washing_plan_id']) && !empty($formData['washing_plan_id']) ? $formData['washing_plan_id'] : "";

        $washingPlanDetail   =  \App\Washing_plan::with('WashingPlanInclude')
                                ->where('id',$planId)->first()->toArray();
        
        if(isset($washingPlanDetail) && is_array($washingPlanDetail) && count($washingPlanDetail) > 0){
            $washingPrices     =    \App\Washing_price::where('washing_plan_id',$planId)
                                    ->where('vehicle_type_id',$vehicleType)->first();
            if(isset($washingPrices) && !empty($washingPrices)){
                $washingPlanDetail['price_duration']     =   $washingPrices->price;
            }else{
                $washingPlanDetail['price_duration']     =   0;
            }
        }
        $response['data']       =   $washingPlanDetail;
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getWashingPlanDetails()

    /**
     * Function for get Booking Shedule
     * @param $formData as formdata
     * @return response
     */
    public function getBookingShedule($formData=array()) {
       
        $vehicleType    =   isset($formData['vehicle_type']) && !empty($formData['vehicle_type']) ? $formData['vehicle_type'] : "";

        $planId         =   isset($formData['washing_plan_id']) && !empty($formData['washing_plan_id']) ? $formData['washing_plan_id'] : "";
        
        $duration               =   Config::get('app.DURATION_TIME'); // how much the is the duration of a time slot
        //$selectedDate           =   '2021-09-03';
        $selectedDate           =   isset($formData['selected_date']) && !empty($formData['selected_date']) ? $formData['selected_date'] : '';
        $newArray               =   [];
        $dayofweek              =   date('l', strtotime($selectedDate));

        $cleanerId              =   isset($formData['cleaner_id']) && !empty($formData['cleaner_id']) ? $formData['cleaner_id'] : '';
        
        $addressId              =   isset($formData['address_id']) && !empty($formData['address_id']) ? $formData['address_id'] : '';

        if($cleanerId   ==  ''){
            $userAddress        =   \App\UserAddressBook::where('id',$addressId)->first();
            if(isset($userAddress) && !empty($userAddress)){
                $userCleaner    =   \App\User::where('postal_code',$userAddress->pin_code)->first();
                if(isset($userCleaner) && !empty($userCleaner)){
                    $cleanerId  =   $userCleaner->id;
                }
            }
        }

        $OpeningHour            =   \App\Opening_hour::where('user_id',$cleanerId)
                                    ->where('day',$dayofweek)->first();

        if(isset($OpeningHour) && !empty($OpeningHour)){
            $openingData            =  $OpeningHour->toArray();
            $start                  =  $openingData['opening_time']; // start time
            $end                    =  $openingData['closing_time']; // end time

            $bufferTime             =  Config::get('app.BUFFER_TIME');
            $timeSlots              =  CustomHelper::getTimeSlots($duration,$start,$end);
            // pr($end); 
            // die;
            $lunchOpeningTime       =  $openingData['lunch_opening_time'];
            $lunchOpeningTime       =  strtotime(date('Y-m-d H:i', strtotime("$selectedDate $lunchOpeningTime")));
            $lunchClosingTime       =  $openingData['lunch_closing_time'];
            $lunchClosingTime       =  strtotime(date('Y-m-d H:i', strtotime("$selectedDate $lunchClosingTime")));

            // $closeingTime   =       date('Y-m-d H:i', strtotime("$date $openingData['lunch_closing_time']"));
           
                   // pr($timeSlots); die;

            foreach ($timeSlots as $key => $value) {
                $time          =     $value['start'];
                $startTime     =     date('Y-m-d H:i', strtotime("$selectedDate $time"));
                $startTime     =     strtotime("$startTime");

                //$combinedDT  =     strtotime("$startTime".'+'."$bufferTime");
               
                $flag   =   CustomHelper::checkValidSlots($startTime,$lunchOpeningTime,$lunchClosingTime);
                if($flag){
                    array_push($newArray, $value);
                }
            } 
        }

        $response['data']       =   $newArray;
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getBookingShedule()

    /**
     * Function for get Valid Booking Shedule
     * @param $formData as formdata
     * @return response
     */
    public function getValidBookingShedule(Request $request) {

        $bufferTime         =   Config::get('app.BUFFER_TIME');

        $formData           =   $request->all();

        $withoutLunchData   =   $this->getBookingShedule($formData);
        $selectedDate       =   isset($formData['selected_date']) && !empty($formData['selected_date']) ? $formData['selected_date'] : '';
        $cleanerId          =   isset($formData['cleaner_id']) && !empty($formData['cleaner_id']) ? $formData['cleaner_id'] : '';
        $bookedAppointment  =   \App\Appointment::where('appointment_date',$selectedDate)->where('cleaner_id',$cleanerId)->where('status_id',2)->get()->toArray();

        $newArray           =   [];
        $i = 0;
        foreach ($withoutLunchData['data'] as $k => $val) {
            $exist          =     1;
            $time           =     $val['start'];
            $startTime      =     date('Y-m-d H:i', strtotime("$selectedDate $time"));
            $slotStartTime  =     strtotime("$startTime");

            foreach ($bookedAppointment as $key => $value) {
                
                $bookingTakingTime      =  $value['appx_hour'];  // BOOKING TAKING TIME
                $appointmentDate        =  $value['appointment_date']; // BOOKING APPOINTMENT DATE
                $bookingStartTime       =  $value['time_frame']; // BOOKING START TIME
                $bookingOpeningTime     =  date('Y-m-d H:i', strtotime("$selectedDate $bookingStartTime"));
                $bookingOpeningFream    =  strtotime("$bookingOpeningTime");

                $totalTakingTime        =  $bufferTime+$bookingTakingTime;
                $bookingClosingFream    =  strtotime("$bookingOpeningTime".'+'."$totalTakingTime"." minutes");

                 $flag      =   CustomHelper::checkValidSlots($slotStartTime,$bookingOpeningFream,$bookingClosingFream);
               
                if(!$flag){
                    $exist  =   0;
                    break;
                }
                
                // if($i == 0){
                //     if($flag){
                //         array_push($newArray, $val);
                //         $i++;
                // }
                // }
            }

            if($exist == 1){
                 array_push($newArray, $val);
            }
        }
        $finalArray =   [];
        if(count($newArray) > 0){
            foreach ($newArray as $key => $value) {
               $finalArray[$key]['label'] =   $value['start'];
               $finalArray[$key]['value'] =   $value['start'];
            }
        }
        //array_unique();
        $response['data']       =   $finalArray;
        $response['status']     =   'success';
        $response['message']    =   '';
        return $response;
    }//end getValidBookingShedule()

    /**
     * function for update Email Mobile Number 
     * @param $formData as form data
     * @return mail
    */
    public function updateEmailMobile($formData = array()){ 
        $response       =   array();  
        $message        =   '';    
  
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $typeEmail      =   isset($formData['type_email']) && !empty($formData['type_email']) ? $formData['type_email'] : '';

        $typeMobile     =   isset($formData['type_mobile']) && !empty($formData['type_mobile']) ? $formData['type_mobile'] : '';
        $userInfo       =   \App\User::where('id',$userId)->first();
       
        if (isset($userInfo) && !empty($userInfo)) {  
            
            if(isset($typeEmail) && $typeEmail == "email"){

                $tempEmailId        =   isset($formData['temp_email_id']) && !empty($formData['temp_email_id']) ? $formData['temp_email_id'] : '';
                $userInfo->otp_number               =   Config::get('app.OTP_NUMBERS');
                $userInfo->temp_email_id            =   strtolower($tempEmailId);
                $userInfo->save();

                //Re Send OTP mail to user
                if(!empty($userInfo->temp_email_id)){
                    /*$to           =   $userInfo->email;
                    $to_name        =   ucwords($userInfo->full_name);
                    $username       =   $to_name;
                    $otp            =   $otp;
                    $action         =   "resend_otp";
                    $rep_Array      =   array($username, $otp);
                    CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                }
                $response['message']        =   trans("OTP has been sent on your email address ".$userInfo->temp_email_id.".");
            }

            if(isset($typeMobile) && $typeMobile == "mobile"){

                $tempMobileNumber    =   isset($formData['mobile_number']) && !empty($formData['mobile_number']) ? $formData['mobile_number'] : '';

                $userInfo->mobile_otp_number                =   Config::get('app.OTP_NUMBERS');
                $userInfo->temp_mobile_number               =   $tempMobileNumber;
                $userInfo->save();
            
                if(!empty($userInfo->temp_mobile_number)){
                    
                }
                $response['message']                =   trans("OTP has been sent on your mobile number ".$userInfo->temp_mobile_number.".");
            }
            $response['status'] =   'success';
            
            return $response;
        }else{
            $response['status'] =   'error';
            $response['message'] =   trans('Sorry you are using wrong link.');
        }
        return $response;
    }//end updateEmailMobile()

    /**
     * function for Verify Temp Email Mobile
     * @param $formData as form data
     * @return mail
    */
    public function VerifyTempEmailMobile(Request $request){ 
        $formData       =   $request->all();
        $response       =   array(); 
        $message        =   "";
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $type           =   isset($formData['type']) && !empty($formData['type']) ? $formData['type'] : '';
        $tempValue      =   isset($formData['temp_value']) && !empty($formData['temp_value']) ? $formData['temp_value'] : '';
        $otpValue       =   isset($formData['otp_number']) && !empty($formData['otp_number']) ? $formData['otp_number'] : '';

        $userInfo       =   \App\User::where('id',$userId)->first();
        if (isset($userInfo) && !empty($userInfo)) {  
            if(isset($type) && $type == "email" && !empty($userInfo->temp_email_id)){
                
                $userTempEmailId        =   isset($userInfo->temp_email_id) && !empty($userInfo->temp_email_id) ? $userInfo->temp_email_id : '';

                if($tempValue   ==  $userTempEmailId && $userInfo->otp_number  ==  $otpValue){
                    $userInfo->email                    =   $userTempEmailId;
                    $userInfo->otp_number               =   null;
                    $userInfo->temp_email_id            =   null;
                    $userInfo->save();
                
                    $message    =   trans('Email has been changed successfully.');
                    //Re Send OTP mail to user
                    if(!empty($userInfo->email)){
                        /*$to           =   $userInfo->email;
                        $to_name        =   ucwords($userInfo->full_name);
                        $username       =   $to_name;
                        $otp            =   $otp;
                        $action         =   "resend_otp";
                        $rep_Array      =   array($username, $otp);
                        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                    }
                    $userData       =   \App\User::where('id',$userId)->first()->toArray();
                    $userData['user_img_url']   =   Config::get('app.USERS_IMG_URL');

                    $response['status']         =   'success';
                    $response['user_data']      =   $userData;
                    $response['message']        =   $message;
                    return $response;
                }

            }else if(isset($type) && $type == "mobile" && !empty($userInfo->temp_mobile_number)){


                $userTempMobileNumber       =   isset($userInfo->temp_mobile_number) && !empty($userInfo->temp_mobile_number) ? $userInfo->temp_mobile_number : '';

                if($tempValue ==  $userTempMobileNumber && $userInfo->mobile_otp_number ==  $otpValue){
                    $userInfo->mobile                           =   $userTempMobileNumber;
                    $userInfo->mobile_otp_number                =   null;
                    $userInfo->temp_mobile_number               =   null;
                    $userInfo->save();
                
            
                    $message    =   trans('Mobile number has been changed successfully.');
                    //Re Send OTP mail to user
                    if(!empty($userInfo->mobile)){
                        /*$to           =   $userInfo->email;
                        $to_name        =   ucwords($userInfo->full_name);
                        $username       =   $to_name;
                        $otp            =   $otp;
                        $action         =   "resend_otp";
                        $rep_Array      =   array($username, $otp);
                        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                    }

                    $userData       =   \App\User::where('id',$userId)->first()->toArray();
                    $userData['user_img_url']   =   Config::get('app.USERS_IMG_URL');

                    $response['status']         =   'success';
                    $response['user_data']      =   $userData;
                    $response['message']        =   $message;
                    return $response;
                }
            }
            
        }
        $response['status'] =   'error';
        $response['message'] =   trans('Please enter valid OTP.');
        return $response;
    }//end VerifyTempEmailMobile()

    /**
     * function for get  UserDetails
     * @param $request as form data
     * @return mail
    */
    public function getUserDetails(Request $request){ 
        $formData       =   $request->all();
        $response       =   array('message'=>'','status'=>'error','user_data'=>[]); 

        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';

        $userData       =   \App\User::where('id',$userId)->first();
        $userData['user_img_url']   =   Config::get('app.USERS_IMG_URL');
        if(isset($userData) && !empty($userData)){
            $response['status']     =   "success";
            $response['user_data']  =   $userData->toArray();
        }
        return $response;
    }

    /**
     * function for resend Otp For Change User Auth (Email/Mobile) 
     *
     * @param $request as form data
     *
     * @return mail
    */
    public function resendOtpForChangeAuth(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();      
  
        $resendType     =   isset($formData['resend_type']) && !empty($formData['resend_type']) ? $formData['resend_type'] : '';
        
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';

        if (!empty($resendType) && !empty($userId)) {
                $userInfo = \App\User::where('id',$userId)->first();

                if(!empty($userInfo)) {
                    $otp    =   "1234";
                    if ($resendType == "email") {
                        $userInfo->otp_number           =   $otp;
                        $userInfo->save();
                        
                        //Re Send OTP mail to user
                        /*$to           =   $userInfo->email;
                        $to_name        =   ucwords($userInfo->full_name);
                        $username       =   $to_name;
                        $otp            =   $otp;
                        $action         =   "resend_otp";
                        $rep_Array      =   array($username, $otp);
                        CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);*/
                        
                        $response['message'] =   trans('OTP has been sent on your email address.');
                    }

                    if ($resendType == "mobile") {
                        $userInfo->mobile_otp_number    =   $otp;
                        $userInfo->save();
                        
                        /*Re Send OTP sms to user */
                        $mobile_no  = $userInfo->mobile;

                        //CustomHelper::SendSms("9024649131","hello ");
                        //CustomHelper::_SendOtp('resend_otp', $mobile_no, $otp);
                        
                        $response['message'] =   trans('OTP has been sent on your mobile number.');
                    }
                    
                    $response['status'] =   'success';
                    return $response;
                }else{
                    $response['status'] =   'error';
                    $response['message'] =   trans('Sorry you are using wrong link.');
                    return $response;
                }
            
        }else{
            $response['status'] =   'error';
            $response['message'] =   trans('Sorry you are using wrong link.');
        }
        return $response;
    }//end resendOtpForChangeAuth()


    /**
     * function for Book Appointment 
     *
     * @param $formData as form data
     *
     * @return mail
    */
    public function bookAppointment(Request $request){ 

        $formData       =   $request->all();
      
    //     $couponDetail = \App\Coupon::where('id',$formData['coupon_id'])->where('status','A')->first();
   
    //     $current_time = Carbon::now();
   
    //   $rates = '5000';
    //  if(isset($couponDetail['value_type']) && !empty($couponDetail['value_type']) && $couponDetail['value_type'] == '%'){
    //    $coupon_percentage = $rates*$couponDetail['value']/100;
    //    pr( $coupon_percentage);

    //  }else {
    //     $coupon_value =  $rates -$couponDetail['value'];
    //  }

   
    //     $couponDetail1 = \App\Coupon::where('id',18)
    //     ->where('status','A')
    //     ->whereYear('start_date',"<=", $current_time)
    //     ->whereYear("end_date", ">=",  $current_time)
    //     ->first();
        
    //     echo  $current_time;
     
    //      die;
       
        $response       =   array();     
        $message = array(
            'booking_date.required'     => trans("Please select a booking date."),
            'slot_time.required'        => trans("Please select a slot time."),
        );

        $validate               =       array('booking_date'=>'required','slot_time'=>'required');
        $validator              =       Validator::make($formData, $validate, $message);

        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }

        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            if(isset($formData['select_vehicle']) && !empty($formData['select_vehicle'])){
                if(isset($formData['address_id']) && !empty($formData['address_id'])){
                    if(isset($formData['booking_type']) && !empty($formData['booking_type'])){
                        if(isset($formData['plan_id']) && !empty($formData['plan_id'])){
                            if(isset($formData['cleaner_id']) && !empty($formData['cleaner_id'])){
                                if(isset($formData['razorpay_payment_id']) && !empty($formData['razorpay_payment_id'])){
                                    if(isset($formData['coupon_id']) && !empty($formData['coupon_id'])){
                                        $couponDetail = \App\Coupon::where('coupon_id',$formData['coupon_id'])->first();
                                       
                                    }
                                  
                                    $api        =   new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                                  
                                    $payment    =   $api->payment->fetch($formData['razorpay_payment_id']);
               
                                    if(isset($payment)  && !empty($payment)) {
                                        // pr(  $payment);die('dcfd');
                                        try {
                                            if($payment->status !=  'captured'){
                                                $paymentData            =   $api->payment->fetch($formData['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));

                                                if(!empty($paymentData)){
                                                  
                                                    $paymentData            =   $paymentData->toArray();
                                                    if(!empty($paymentData)){
                                                       
                                                        $transectionObj                    =   new \App\Transaction;
                                                        $transectionObj->user_id           =   $formData['user_id'];
                                                        $transectionObj->plan_id           =   $formData['plan_id'];
                                                        $transectionObj->payment_id        =   $formData['razorpay_payment_id'];
                                                        $transectionObj->amount            =   $paymentData['amount'];
                                                        $transectionObj->email             =   $paymentData['email'];
                                                        $transectionObj->contact           =   $paymentData['contact'];
                                                        $transectionObj->status            =   $paymentData['status'];
                                                        $transectionObj->type              =   'for_appointment';
                                                        $transectionObj->razorpay_details  =   json_encode($paymentData);
                                                     
                                                        if($transectionObj->save()){
                                                            $obj                    =   new \App\Appointment;
                                                            $obj->user_id           =   $formData['user_id'];
                                                            $obj->cleaner_id        =   $formData['cleaner_id'];
                                                            $obj->vehicle_id        =   $formData['select_vehicle'];
                                                            $obj->address_id        =   $formData['address_id'];
                                                            $obj->booking_type      =   $formData['booking_type'];
                                                            $obj->washing_plan_id   =   $formData['plan_id'];
                                                            $obj->appointment_date  =   $formData['booking_date'];
                                                            $obj->time_frame        =   $formData['slot_time'];
                                                            $obj->otp               =   '1234';
                                                            $obj->status_id         =   2;
                                                            $obj->otp               =   '1234';
                                                            $obj->save();
                                                        }
                                                       
                                                        \App\Transaction::where('id',$transectionObj->id)
                                                        ->update(['appointment_id' => $obj->id]);
                                                    }
                                                    // $response['status']     =   'success';
                                                    // $response['message']    =   'Payment successful';
                                                    $response['status']     =   'success';
                                                    $response['message']    =   trans('You have successfully booked your appointment.');
                                                    return $response;
                                                    return $response;
                                                }
                                            }else{
                                                $response['status']     =   'error';
                                                $response['message']    =   "This payment is already captured.";
                                                return $response;
                                            }
                                        } catch (Exception $e) {
                                            $response['status']     =   'error';
                                            $response['message']    =   $e->getMessage();
                                            return $response;
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end bookAppointment()

    /**
     * function for get Booking Final Details
     * @param $request as form data
     * @return response
    */
    public function getBookingFinalDetails(Request $request){ 
        $formData   =   $request->all();

        $planId                 =   isset($formData['plan_id']) && !empty($formData['plan_id']) ? $formData['plan_id'] : "";
        $washingPlanDetail      =  \App\Washing_plan::with(['WashingPlanInclude','washing_price'])
                                    ->where('id',$planId)->first();

        $addressId      =   isset($formData['address_id']) && !empty($formData['address_id']) ? $formData['address_id'] : "";
        $userAddress    = \App\UserAddressBook::where('id',$addressId)->first();

        $selectVehicle  =   isset($formData['select_vehicle']) && !empty($formData['select_vehicle']) ? $formData['select_vehicle'] : '';
        $userVehicles   =   \App\UserVehicle::with(['vehicleClass','vehicleModel','VehicleType'])->where('id',$selectVehicle)->first();

        $washingPlanData    =   $userAddressData    =   $userVehiclesData    =  [];
        if(isset($washingPlanDetail) && !empty($washingPlanDetail)){
            $washingPlanData    =   $washingPlanDetail->toArray();
        }

        if(isset($userAddress) && !empty($userAddress)){
            $userAddressData    =   $userAddress->toArray();
        }

        if(isset($userVehicles) && !empty($userVehicles)){
            $userVehiclesData   =   $userVehicles->toArray();
        }

        $response['status']                 =   "success";
        $response['data']['washing_plan']   =   $washingPlanData;
        $response['data']['user_address']   =   $userAddressData;
        $response['data']['user_vehicle']   =   $userVehiclesData;
        
        return $response;
    }//end getBookingFinalDetails()

    /**
     * function for get Appointment Booking Listing
     * @param $request as form data
     * @return response
    */
    public function getAppointmentBookingListing(Request $request){ 
        $formData       =   $request->all();
        $statusId       =   isset($formData['status_id']) && !empty($formData['status_id']) ? $formData['status_id'] : Config::get('app.REQ_COMPLETED');
        
        $userId     =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : $formData['cleaner_id'];

        if(isset($userId) && !empty($userId)){

            $DB      =   \App\Appointment::query();
            $DB->with(['washing_plan','user','cleaner','status','user_vehicle','user_address','CleanerBookingStatusData']);
            
            if(isset($formData['user_id']) && !empty($formData['user_id']) ){
                $DB->where('user_id',$formData['user_id']);
            }else{
                $DB->where('cleaner_id',$formData['cleaner_id']);
            }

            $bookedAppointment      =   $DB->where('status_id',$statusId)->get()->toArray();

            $response['status']             =   "success";
            $response['data']               =   $bookedAppointment;
            $response['user_img_url']       =   Config::get('app.USERS_IMG_URL');
            return $response;


        }else{
            $response['status'] =   'error';
            $response['message'] =   trans('Sorry you are using wrong link.');
            return $response;
        }

    }//end getAppointmentBookingListing()


    // /**
    //  * function for get Cleaner All Appointment Booking Listing
    //  * @param $request as form data
    //  * @return response
    // */
    // public function getCleanerAllBookingList(Request $request){ 
    //     $formData       =   $request->all();
        
    //     if(isset($formData['cleaner_id']) && !empty($formData['cleaner_id'])){

    //         $DB      =   \App\Appointment::query();
    //         $DB->with(['washing_plan','user','cleaner','status','user_vehicle','user_address'])->where('cleaner_id',$formData['cleaner_id']);
            
    //         if(isset($formData['status_id']) && !empty($formData['status_id']) ){
    //             $DB->where('status_id',$formData['status_id']);
    //         }
    //         $cleanerBookingLists            =   $DB->get()->toArray();
    //         $response['status']             =   "success";
    //         $response['data']               =   $cleanerBookingLists;
    //         $response['user_img_url']       =   Config::get('app.USERS_IMG_URL');
    //         return $response;

    //     }else{
    //         $response['status'] =   'error';
    //         $response['message'] =   trans('Sorry you are using wrong link.');
    //         return $response;
    //     }

    // }//end getCleanerAllBookingList()

    /**
     * function for get Cleaner All Appointment Booking Listing
     * @param $request as form data
     * @return response
    */
    public function getCleanerAllBookingList(Request $request){ 
        $formData       =   $request->all();
        
        $recordLimit            =   5;
        $page_number            =   isset($formData['page'])?$formData['page']:1;

        if(isset($formData['cleaner_id']) && !empty($formData['cleaner_id'])){

            $DB      =   \App\Appointment::query();
            $DB->with(['washing_plan','user','cleaner','status','user_vehicle','user_address'])->where('cleaner_id',$formData['cleaner_id']);
            
            if(isset($formData['status_id']) && !empty($formData['status_id']) ){
                
               $DB->where('status_id',$formData['status_id']);
            }
            $cleanerBookingLists            =   $DB->paginate((int)$recordLimit,['*'],'page',$page_number)->toArray();
            $response['status']             =   "success";
            $response['data']               =   $cleanerBookingLists;
            $response['user_img_url']       =   Config::get('app.USERS_IMG_URL');
            $response['page_number']        =   $page_number;
            return $response;

        }else{
            $response['status'] =   'error';
            $response['message'] =   trans('Sorry you are using wrong link.');
            return $response;
        }

    }//end getCleanerAllBookingList()

    /**
     * function for get Booking Details
     * @param $request as form data
     * @return response
    */
    public function getBookingDetails(Request $request){ 
        $formData   =   $request->all();
        if(isset($formData['booking_id']) && !empty($formData['booking_id'])){

            $bookedAppointment      =   \App\Appointment::with(['washing_plan','user','cleaner','status',
                                        'user_vehicle','user_address','CleanerPreWashPhoto','CleanerAfterWashPhoto','CleanerBookingStatusData'])
                                        ->where('id',$formData['booking_id'])->first();

            $finalArray =   [];
            if(isset($bookedAppointment) && !empty($bookedAppointment)){
                $finalArray   =   $bookedAppointment->toArray();
                
            }
            $response['status']                         =   "success";
            $response['data']                           =   $finalArray;
            $response['data']['user_img_url']           =   Config::get('app.USERS_IMG_URL');
            $response['data']['cleaner_wash_img_url']   =   Config::get('app.CLEANER_PHOTO_IMG');
            return $response;
        }else{
            $response['status']             =   'error';
            $response['data']               =   [];
            $response['message']            =   trans('Sorry you are using wrong link.');
            return $response;
        }
    }//end getBookingDetails()

    /**
     * function for Cancel Booked Appointment 
     *
     * @param $formData as form data
     *
     * @return array
    */
    public function cancelBookedAppointment(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();    

        $userId                         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $bookedAppointmentId            =   isset($formData['booked_appointment_id']) && !empty($formData['booked_appointment_id']) ? $formData['booked_appointment_id'] : '';


         $message = array(
            'cancel_reson.required'     => trans("Please enter a reson."),
        );

        $validate               =       array('cancel_reson'=>'required');
        $validator              =       Validator::make($formData, $validate, $message);
        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }


        if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
            if(isset($userId) && !empty($userId)){

                $bookedAppointment      =   \App\Appointment::where('id',$bookedAppointmentId)
                                            ->where('user_id',$userId)->where('status_id',2)->first();

                if(isset($bookedAppointment) && !empty($bookedAppointment)){
                    $bookedAppointment->update(['status_id'=>4,'cancel_reason'=>$formData['cancel_reson']]);

                    $response['status']     =   'success';
                    $response['message']    =   trans('You have successfully cancel your booked appointment.');
                    return $response;
                }

            }
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end cancelBookedAppointment()



    /**
     * function for Accept Booked Appointment 
     *
     * @param $formData as form data
     *
     * @return array
    */
    public function acceptBookedAppointment(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();    

        $userId                =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $bookedAppointmentId   =   isset($formData['booked_appointment_id']) && !empty($formData['booked_appointment_id']) ? $formData['booked_appointment_id'] : '';


        if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
            if(isset($userId) && !empty($userId)){

                $bookedAppointment      =   \App\Appointment::where('id',$bookedAppointmentId)
                                            ->where('user_id',$userId)->where('status_id',2)->first();

                if(isset($bookedAppointment) && !empty($bookedAppointment)){
                    $bookedAppointment->update(['status_id'=>1]);

                    $response['status']     =   'success';
                    $response['message']    =   trans('You have successfully accept appointment.');
                    return $response;
                }

            }
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end acceptBookedAppointment()

    /**
     * function for Reshedule Booked Appointment 
     *
     * @param $formData as form data
     *
     * @return array
    */
    public function resheduleBookedAppointment(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();   

        $message = array(
            'booking_date.required'     => trans("Please select a booking date."),
            'slot_time.required'        => trans("Please select a slot time."),
        );

        $validate               =       array('booking_date'=>'required','slot_time'=>'required');
        $validator              =       Validator::make($formData, $validate, $message);
        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }

        $userId                         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $bookedAppointmentId            =   isset($formData['booked_appointment_id']) && !empty($formData['booked_appointment_id']) ? $formData['booked_appointment_id'] : '';
        if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
            if(isset($userId) && !empty($userId)){

                $bookedAppointment      =   \App\Appointment::where('id',$bookedAppointmentId)
                                            ->where('user_id',$userId)
                                            //->where('status_id',2)
                                            ->first();
        //pr($bookedAppointment); die;

                if(isset($bookedAppointment) && !empty($bookedAppointment)){
                    $bookedAppointment->update(['appointment_date'=>$formData['booking_date'],'time_frame'=>$formData['slot_time']]);
                
                    $response['status']     =   'success';
                    $response['message']    =   trans('You have successfully resheduled your booked appointment.');
                    return $response;
                }
            }
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end resheduleBookedAppointment()

    /**
     * Function for get Addone Service List
     * @param $formData as formdata
     * @return response
     */
    public function getAddoneServices(Request $request) {

        $formData           =   $request->all();

        $selectedAddon      =   isset($formData['selected_addon']) && !empty($formData['selected_addon']) ? $formData['selected_addon']: [];
        $selectedAddonExist =   isset($formData['type']) && !empty($formData['type']) ? $formData['type']: '';

        if(isset($selectedAddonExist) && !empty($selectedAddonExist)){
           
            if(count($selectedAddon) > 0){
                $addOnServices      =   \App\AddOn::whereIn('id',$selectedAddon)->where('status','A')->get()->toArray();
            }else{
                $addOnServices      =   [];   
            }

        }else{
            $addOnServices      =   \App\AddOn::where('status','A')->get()->toArray();  
        }

        $response['data']       =   $addOnServices;
        $response['status']     =   'success';
        $response['selectedAddon']     =   $selectedAddon;
        $response['message']    =   '';
        return $response;
    }//end getAddoneServices()

   
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function refresh() {

        $token = JWTAuth::getToken();
        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $token = JWTAuth::refresh($token);
        }catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }
        if($token){

            $response['access_token']       =      $token;
            $response['token_type']         =     'bearer';
            $response['expires_in']         =      auth()->factory()->getTTL() * 60;
            $response['data']               =      auth()->user();
        }
        $response['status']         =   'error';
        $response['access_token']   =   "";
        return $response;
    }


    /**
     * Function for get Banner List
     * @param $formData as formdata
     * @return response
     */
    public function getBannerList(Request $request) {
        $formData           =   $request->all();
        $records            =   \App\Banner::get()->toArray();

        if(count($records) > 0){
            foreach ($records as $key => $activity) {
                if(isset($activity['image']) && !empty($activity['image']) && file_exists(public_path('images/teams/'.$activity['image']))){
                    $records[$key]['image']     =   url(URL::asset('public/images/teams/'.$activity['image']) );
                }else{
                    $records[$key]['image']     =   WEBSITE_URL.'/public/images/blank-profile.png';
                }
            }
        }
       
        $response['data']       =   $records;
        $response['status']     =   'success';
        return $response;
    }//end getBannerList()

    /**
     * function for Book Appointment Addon
     *
     * @param $formData as form data
     *
     * @return mail
    */
    public function bookAppointmentAddon(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();     
        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            if(isset($formData['appointment_id']) && !empty($formData['appointment_id'])){
                if(isset($formData['addon_ids']) && count($formData['addon_ids']) > 0 ){
                    if(isset($formData['razorpay_payment_id']) && !empty($formData['razorpay_payment_id'])){
                        $api        =   new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                        $payment    =   $api->payment->fetch($formData['razorpay_payment_id']);
                        if(isset($payment)  && !empty($payment)) {
                               
                            try {
                                if($payment->status !=  'captured'){
                                    $paymentData            =   $api->payment->fetch($formData['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                                    if(!empty($paymentData)){
                                        $paymentData            =   $paymentData->toArray();
                                        if(!empty($paymentData)){

                                            $appointmentDetails =   \App\Appointment::where('id',$formData['appointment_id'])->first();
                                            if(!empty($appointmentDetails)){
                                                $transectionObj                    =   new \App\Transaction;
                                                $transectionObj->user_id           =   $formData['user_id'];
                                                $transectionObj->plan_id           =   $appointmentDetails->washing_plan_id;
                                                $transectionObj->payment_id        =   $formData['razorpay_payment_id'];
                                                $transectionObj->amount            =   $paymentData['amount'];
                                                $transectionObj->email             =   $paymentData['email'];
                                                $transectionObj->contact           =   $paymentData['contact'];
                                                $transectionObj->status            =   $paymentData['status'];
                                                $transectionObj->type              =   'for_addon';
                                                $transectionObj->razorpay_details  =   json_encode($paymentData);

                                                if($transectionObj->save()){
                                                    foreach ($formData['addon_ids'] as $key => $value) {
                                                        $obj                    =   new \App\AppointmentAddons;
                                                        $obj->user_id           =   $formData['user_id'];
                                                        $obj->appointment_id    =   $appointmentDetails->id;
                                                        $obj->addon_id          =   $value;
                                                        $obj->save();
                                                    }
                                                }
                                                \App\Transaction::where('id',$transectionObj->id)
                                                ->update(['appointment_id' => $obj->id]);
                                            }
                                        }
                                        $response['status']     =   'success';
                                        $response['message']    =   trans('You have successfully purchase your addon.');
                                        return $response;
                                        return $response;
                                    }
                                }else{
                                    $response['status']     =   'error';
                                    $response['message']    =   "This payment is already captured.";
                                    return $response;
                                }
                            } catch (Exception $e) {
                                $response['status']     =   'error';
                                $response['message']    =   $e->getMessage();
                                return $response;
                            }
                           
                        }
                    }
                }
            }
                    
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end bookAppoinmentAddon()

    /**
     * Function for get uploadCleanerPreWashPhoto
     * @param Request as $request
     * @return response
    */
    public function uploadCleanerPreWashPhoto(Request $request) {
        $response       =   array();
        $formData       =   $request->all();
        $status         =   "error";
        $message        =   '';       
        
        /* define validatation messages */
        if(isset($formData['appointment_id']) && !empty($formData['appointment_id'])){
            if(isset($formData['cleaner_id']) && !empty($formData['cleaner_id'])){
                
                $message = array(
                    'top_img.required'                        =>  trans('Please select top image.'),
                    'back_img.required'                       =>  trans('Please select back image.'),
                    'front_img.required'                      =>  trans('Please select front image.'),
                    'right_img.required'                      =>  trans('Please select right image.'),
                    'left_img.required'                       =>  trans('Please select left image.'),
                );
                /* define validation */
                $validate  =    [          
                    'top_img'                         => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'back_img'                        => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'front_img'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'right_img'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'left_img'                        => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                ];
                $validator          =   Validator::make($formData, $validate, $message);
                if ($validator->fails()){ 
                    $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
                    return $response;
                }  
                

                if($file = $request->file('top_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['top_img'] = $name;
                }
             
                if($file = $request->file('back_img')) { 
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['back_img'] = $name;
                }  
                                  
                if($file = $request->file('front_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['front_img'] = $name;
                }
                
                if($file = $request->file('right_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['right_img'] = $name;
                }
              
                if($file = $request->file('left_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['left_img'] = $name;
                   
                }
                $cleaners_photo  =  \App\CleanerPrePhoto::where('appointment_id',$formData['appointment_id'])->where('cleaner_id',$formData['cleaner_id'])->first();

                if(isset( $cleaners_photo) && !empty( $cleaners_photo)){
                    $cleaners_photo->delete(); 
                }
                \App\CleanerPrePhoto::create($formData);
                $message        =   'Your photo has been added successfully.';
                $status         =   "success";
            
            }else{
                $message        =   trans('Sorry you are using wrong link');
            }
        }else{
            $message            =   trans('Sorry you are using wrong link');
        }
       
        $response['status']     =   $status;
        $response['message']    =   $message;
        return $response;
    }//end uploadCleanerPreWashPhoto()

    /**
     * Function for get uploadCleanerPostWashPhoto
     * @param Request as $request
     * @return response
    */
    public function uploadCleanerPostWashPhoto(Request $request) {
        $response       =   array();
        $formData       =   $request->all();
        $status         =   "error";
        $message        =   '';       
    
        /* define validatation messages */
        if(isset($formData['appointment_id']) && !empty($formData['appointment_id'])){
            if(isset($formData['cleaner_id']) && !empty($formData['cleaner_id'])){
                
                $message = array(
                    'top_img.required'                        =>  trans('Please select top image.'),
                    'back_img.required'                       =>  trans('Please select back image.'),
                    'front_img.required'                      =>  trans('Please select front image.'),
                    'right_img.required'                      =>  trans('Please select right image.'),
                    'left_img.required'                       =>  trans('Please select left image.'),
                );
                /* define validation */
                $validate  =    [          
                    'top_img'                         => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'back_img'                        => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'front_img'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'right_img'                       => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                    'left_img'                        => 'required|image|mimes:jpeg,png,jpg|max:6000',          
                ];
                $validator          =   Validator::make($formData, $validate, $message);
                if ($validator->fails()){ 
                    $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
                    return $response;
                }  
                

                if($file = $request->file('top_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['top_img'] = $name;
                }
             
                if($file = $request->file('back_img')) { 
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['back_img'] = $name;
                }  
                                  
                if($file = $request->file('front_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['front_img'] = $name;
                }
                
                if($file = $request->file('right_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['right_img'] = $name;
                }
              
                if($file = $request->file('left_img')) {
                    $name = time().'_image_'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/cleaner_photo'), $name);
                    if (file_exists(public_path($name))) {
                        unlink(public_path($name));
                    };
                    $formData['left_img'] = $name;
                   
                }
                $cleaners_photo  =  \App\CleanerPostPhoto::where('appointment_id',$formData['appointment_id'])->where('cleaner_id',$formData['cleaner_id'])->first();

                if(isset( $cleaners_photo) && !empty( $cleaners_photo)){
                    $cleaners_photo->delete(); 
                }
                \App\CleanerPostPhoto::create($formData);
                $message        =   'Your photo has been added successfully.';
                $status         =   "success";
            
            }else{
                $message        =   trans('Sorry you are using wrong link');
            }
        }else{
            $message            =   trans('Sorry you are using wrong link');
        }
       
        $response['status']     =   $status;
        $response['message']    =   $message;
        return $response;
    }//end uploadCleanerPostWashPhoto()

    /**
     * function for cleaner Booking Start
     *
     * @param $formData as form data
     *
     * @return array
    */
    public function cleanerBookingStart(Request $request){ 
        $formData               =   $request->all();
        $response               =   array();    
        $response['message']    =   trans('Sorry you are using wrong link.');

        $userId                         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $bookedAppointmentId            =   isset($formData['booked_appointment_id']) && !empty($formData['booked_appointment_id']) ? $formData['booked_appointment_id'] : '';


        $message = array(
            'otp.required'     => trans("Please enter a reson."),
        );

        $validate               =       array('otp'=>'required');
        $validator              =       Validator::make($formData, $validate, $message);
        if ($validator->fails()){ 
            $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
            return $response;
        }

        if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
            if(isset($userId) && !empty($userId)){

                $bookedAppointment      =   \App\Appointment::where('id',$bookedAppointmentId)
                                            ->where('user_id',$userId)->where('status_id',Config::get('app.REQ_PENDING'))
                                            ->where('otp',$formData['otp'])->first();

                if(isset($bookedAppointment) && !empty($bookedAppointment)){


                    $bookedAppointment->status_id   =   Config::get('app.REQ_START');
                    $bookedAppointment->otp         =   NULL;
                    $bookedAppointment->save();

                    /*send notification to user*/
                    $rep_array  =   array($bookedAppointment->user->name,$bookedAppointment->cleaner->name);
                    $action     =   'booking_start_by_cleaner';
                    CustomHelper::saveNotificationActivity($rep_array,$action,$bookedAppointment->user->id);
                    /*send notification to user*/

                    $response['status']     =   'success';
                    $response['message']    =   trans('You have successfully start your appointment.');
                    return $response;
                }else{
                    $response['message']    =   trans('Sorry you are using wrong otp.');
                }
            }
        }

        $response['status'] =   'error';
        return $response;
    }//end cleanerBookingStart()

    /**
     * function for Resend Cleaner Booking Start OTP
     *
     * @param $formData as form data
     *
     * @return array
    */
    public function resendCleanerBookingStartOTP(Request $request){ 
        $formData       =   $request->all();
        $response       =   array();    

        $userId                         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $bookedAppointmentId            =   isset($formData['booked_appointment_id']) && !empty($formData['booked_appointment_id']) ? $formData['booked_appointment_id'] : '';

       
        if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
            if(isset($userId) && !empty($userId)){

                $bookedAppointment      =   \App\Appointment::where('id',$bookedAppointmentId)
                                            ->where('user_id',$userId)->where('status_id',Config::get('app.REQ_PENDING'))
                                            ->first();

                if(isset($bookedAppointment) && !empty($bookedAppointment)){
                    $otp_number             =   Config::get('app.OTP_NUMBERS');

                    $bookedAppointment->update(['otp'=>$otp_number]);

                    $response['status']     =   'success';
                    $response['message']    =   trans('We have successfully sent OTP.');
                    return $response;
                }

            }
        }

        $response['status'] =   'error';
        $response['message'] =   trans('Sorry you are using wrong link.');
        return $response;
    }//end resendCleanerBookingStartOTP()

    /**
     * function for get user Notification Listing
     * @param $request as form data
     * @return response
    */
    public function getUserNotificationListing(Request $request){ 
        $formData   =   $request->all();
        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            $recordLimit            =   10;
            $page_number            =   isset($formData['page'])?$formData['page']:1;

            $userNotifications      =    \App\Notifications::where('user_id',$formData['user_id'])
                                        ->paginate((int)$recordLimit,['*'],'page',$page_number)->toArray();

            $response['status']     =     "success";
            $response['data']       =     $userNotifications;
            return $response;
        }
        $response['status']         =    'error';
        $response['data']           =    [];
        $response['message']        =    trans('Sorry you are using wrong link.');
        return $response;
    }//end getUserNotificationListing()


    /**
     * Function for mark a delete User Notification
     *
     * @param $address_id as id of address
     *
     * @return response. 
     */
    public function deleteUserNotification(Request $request){
        $formData   =   $request->all();
        if(isset($formData['user_id']) && !empty($formData['user_id'])){
            if(isset($formData['notification_id']) && !empty($formData['notification_id'])){

                $responseData   =   \App\Notification::where('user_id',$formData['user_id'])
                                    ->where('id',$formData['notification_id'])->first();
                
                if(!empty($responseData)){ 
                    $responseData->delete();
                    $status     =   "success";
                    $message    =   trans("Notification has been successfully deleted");
                    
                }
            }
        }
        $response['status']     =   "error";
        $response['message']    =   trans('Sorry you are using wrong link');
        return $response;
    } // end deleteUserNotification()


    /**
     * function for user Review Rating
     * @param $formData as form data
     * @return mail
    */
    public function userReviewRating(Request $request){ 
        $formData               =   $request->all();
        $response['status']     =   "error";
        $response['message']    =   trans('Sorry you are using wrong link');
        $userId         =   isset($formData['user_id']) && !empty($formData['user_id']) ? $formData['user_id'] : '';
        $cleanerId      =   isset($formData['cleaner_id']) && !empty($formData['cleaner_id']) ? $formData['cleaner_id'] : '';
        $bookingId      =   isset($formData['booking_id']) && !empty($formData['booking_id']) ? $formData['booking_id'] : '';

 

        if (isset($userId) && !empty($cleanerId) && !empty($bookingId)) { 

            $message = array(
                'rating.required'     => trans("Please enter a rating."),
                'reviews.required'    => trans("Please enter a reviews."),
            );

            $validate               =       array('rating'=>'required','reviews'=>'required');
            $validator              =       Validator::make($formData, $validate, $message);
            if ($validator->fails()){ 
                $response = array('status'=>"error",'message'=>$validator->errors()->toArray());
                return $response;
            } 
            $userRatingInfo       =     \App\UserReviewRatings::where('user_id',$userId)
                                        ->where('booking_id',$bookingId)
                                        ->where('cleaner_id',$cleanerId)
                                        ->first();


            if(isset($userRatingInfo) && !empty($userRatingInfo)){
                $response['status']         =  'success';
                $response['message']        =  trans('You already given the review.');
            }else{
                $userRatingInfo                 =   new \App\UserReviewRatings;
                $userRatingInfo->user_id        =   $userId;
                $userRatingInfo->cleaner_id     =   $cleanerId;
                $userRatingInfo->booking_id     =   $bookingId;
                $userRatingInfo->rating         =   $formData['rating'];
                $userRatingInfo->reviews        =   $formData['reviews'];
                $userRatingInfo->save();
                $response['status']             =  'success';
                $response['message']            =   trans('Your rating have been applyed successfully.');
            }    
        }
        return $response;
    }//end userReviewRating()


    /**
     * function for update Cleaner Status
     * @param $formData as form data
     * @return mail
    */
    public function updateCleanerStatus(Request $request){ 
        $formData               =   $request->all();
        $response['message']    =   '';
        $response['status']     =  'success';
        $cleanerId      =   isset($formData['cleaner_id']) && !empty($formData['cleaner_id']) ? $formData['cleaner_id'] : '';
        $bookingId      =   isset($formData['booking_id']) && !empty($formData['booking_id']) ? $formData['booking_id'] : '';

 

        if (!empty($cleanerId) && !empty($bookingId)) { 

            
            $cleanerBookingStatusInfo       =       \App\CleanerBookingStatus::where('appointment_id',$bookingId)
                                                    ->where('cleaner_id',$cleanerId)
                                                    ->first();


            if(isset($cleanerBookingStatusInfo) && !empty($cleanerBookingStatusInfo)){
                if(isset($formData['current_state']) && !empty($formData['current_state'])){
                    $cleanerBookingStatusInfo->current_state  =   $formData['current_state'];
                }else{
                    $response['status']     =   "error";
                }
            }else{
                $cleanerBookingStatusInfo                 =   new \App\CleanerBookingStatus;
                $cleanerBookingStatusInfo->cleaner_id     =   $cleanerId;
                $cleanerBookingStatusInfo->appointment_id =   $bookingId;
                $cleanerBookingStatusInfo->current_state  =   isset($formData['current_state']) && !empty($formData['current_state']) ? $formData['current_state'] :Config::get('app.CLEANER_REQ_START');
            }    
            $cleanerBookingStatusInfo->save();
        }else{
            $response['status']     =   "error";
        }

        return $response;
    }//end userReviewRating()


}


