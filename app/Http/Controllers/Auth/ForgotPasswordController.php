<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Contact;
use App\User;
use DB; 
use Mail;
use Carbon\Carbon; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\libraries\CustomHelper;
use Auth,View,Hash,Validator,Redirect;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function showResetPassword(){
     
      $contacts = Contact::all();
      return view('auth.passwords.email', compact('contacts'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)

    {

         $email      =   $request->email;
         $userDetail=User::find(1);
         $request->validate([
              'email' => 'required|email|exists:users',
          ]);
        
          $token = Str::random(64);
       
                $forgot_password_validate_string    =   DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' =>   $token, 

              'created_at' => Carbon::now()
            ]);

                // \App\User::where('email', $email)->update(array('forgot_password_validate_string'=>$forgot_password_validate_string));
                 
                 //mail sent to user
                $to             =    $request->email;

                $to_name        =   ucwords($userDetail->name);
               
                $validateString =   $forgot_password_validate_string;

                $full_name      =   $to_name;

                $route_url      =   route('user.resetpassword',  $token);


                $varify_link    =   $route_url;


                $action         =   "forgot_password";
             
                //forgot password mail to user
                $rep_Array = array($full_name, $varify_link, $route_url, $token);

                 
                CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);

               
                 return back()->with('success','password change request send successfully!');        
    }


    // /**
    //  * Send a reset link to the given user.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    //  */
    // public function sendResetLinkEmail(Request $request)
    // {
    //     die('sfdesg');
    //     $this->validateEmail($request);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $response = $this->broker()->sendResetLink(
    //         $request->only('email')
    //     );

    //     return $response == Password::RESET_LINK_SENT
    //                 ? $this->sendResetLinkResponse($response)
    //                 : $this->sendResetLinkFailedResponse($request, $response);
    // }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }


}
