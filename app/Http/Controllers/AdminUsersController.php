<?php

namespace App\Http\Controllers;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\libraries\CustomHelper;
use App\Appointment;
use App\Team;
use App\User;
use App\Washing_plan;
use App\Appointment_AddOn;
use App\UserFranchise;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Config,Hash ;
use Excel;
use PDF;
use DB;
use Carbon\Carbon;
use Validator,Redirect,Input;

use App\Exports\UserExport;
class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request){
      
        $users = User::all()->except(Auth::id());
        
      
        if (Auth::user()->role == 'A' || Auth::user()->role == 'S') {
        
            if ($request->isMethod('post')) {
                
                $newArray = [];
                $configDataTable = CustomHelper::configDatatable($request);
                $startDateVal   =   '';
                $endDateVal   =   '';
                foreach ($configDataTable['conditions'] as $key => $value) {
                    if(isset($value) && count($value) > 0){

                        if(isset($value[0]) && !empty($value[0]) && $value[0] == "role_type"){
                            unset($configDataTable['conditions'][$key]);
                            $val =  str_replace("%","",$value[2]);
                            array_push($configDataTable['conditions'], ['role' , '=',$val]);
                        } 
                        if(isset($value[0]) && !empty($value[0]) && $value[0] == "created"){
                            unset($configDataTable['conditions'][$key]);
                            $val =  str_replace("%","",$value[2]);

                            $valData    =   explode(' - ', $val);
                            
                            $startDateVal   = date("Y-m-d", strtotime($valData[0]));  
                            $endDateVal     = date("Y-m-d", strtotime($valData[1]));  
                            array_push($configDataTable['conditions'], ['updated_at','>=',$startDateVal.' 12:00:00']);
                            array_push($configDataTable['conditions'], ['updated_at','<=',$endDateVal.' 11:59:00']);
                        }          
                    }
                }
              

                $start = ($request->get("start")) ? intval($request->get("start")) : 0;
                $rowperpage = ($request->get("length")) ? intval($request->get("length")) : 10;
               
                 $startDate  = ($request->get("startDate")) ? $request->get("startDate") : '';
                 $endDate    = ($request->get("endDate")) ? $request->get("endDate") : '';

                //  $startDate =  '2021-07-08';
                //  $endDate =  '2021-07-09';


                
                // Get records, also we have included search filter as well
                $columnIndex = $request->get('order')[0]['column'];
                $columnOrderType = $request->get('order')[0]['dir'];
                $columnName = $request->get('columns')[$columnIndex]['data'];
                //$db =  User::whereBetween('created_at', [$startDate, $endDate])->get();
                
                if(Auth::user()->role   ==  "A"){
               
                    $totalRecordsDB           =     User::query();
                    if(isset($startDate) && !empty($startDate) ){
                       
                        if(isset($endDate) && !empty($endDate)){
                            $startDate =   date("F j, Y", strtotime( $startDate));
                          
                            $endDate   = date("F j, Y", strtotime(  $endDate ));
                            $totalRecordsDB->whereBetween('created_at', [$startDate, $endDate ]);
                        }
                       
                    }
                   
                    $totalRecords             =     $totalRecordsDB->select('count(*) as allcount')->where('id', '!=', 1)->count();
                    
                    $totalRecordswithFilterDB =   User::query();

                    // if(isset($startDate) && !empty($startDate) && isset($endDate) && !empty($endDate)){
                    //     $startDate =   date("F j, Y", strtotime( $startDate));
                    //     $endDate   = date("F j, Y", strtotime(  $endDate ));
                    //     //$totalRecordswithFilterDB->whereBetween('created_at', [$startDate, $endDate ]);
                    // }
                    $totalRecordswithFilter           =      $totalRecordswithFilterDB->select('count(*) as allcount')
                                                            ->where('id', '!=', 1)
                                                            ->where($configDataTable['conditions'])->count();
                   
                            $records =  User::query();
                                if(isset($startDate) && !empty($startDate) && isset($endDate) && !empty($endDate)){
                                   
                                    $startDate =   date("F j, Y", strtotime( $startDate));
                                  
                                    $endDate   = date("F j, Y", strtotime(  $endDate ));

                                    //$records->whereBetween('created_at', [$startDate, $endDate ]);  
                                  
                                }
                            
                                $records             =     $records->where('id', '!=', 1)
                                ->orderBy($columnName, $columnOrderType)
                                ->where($configDataTable['conditions'])
                                ->skip($start)->take($rowperpage)->get();
                   
                }else{
                   
                    $teamId         =   Team::where('user_id',Auth::user()->id)->first();
                    $totalRecords   =   User::where('franchise_id',$teamId->id)
                                        ->select('count(*) as allcount')->count();
                    $totalRecordswithFilter = User::where('franchise_id',$teamId->id)
                                                ->select('count(*) as allcount')    
                                                ->where($configDataTable['conditions'])
                                                ->count();
                    $records =  User::where('id', '!=', 1)
                                ->where('franchise_id',$teamId->id)
                                ->orderBy($columnName, $columnOrderType)
                                ->where($configDataTable['conditions'])
                                ->skip($start)->take($rowperpage)->get();
       
                }           
            
                if (count($records) > 0) {

                    foreach ($records as $key => $activity) {
                       
                        // $records[$key]['updated']       =   $activity->updated_at;
                         $records[$key]['created']       =   date('F j, Y', strtotime($activity->created_at));
                         $records[$key]['updated']       =   date('F j, Y', strtotime($activity->updated_at));
                         $records[$key]['gender'] = ($activity->gender == 'M') ? "Male" : "Female";
                         $records[$key]['address'] = str_limit($activity->address, 10);

                        if (isset($activity['role']) && $activity['role'] == 'C') {
                            $records[$key]['role_type'] = "Cleaner";
                        } else if (isset($activity['role']) && $activity['role'] == 'U') {
                            $records[$key]['role_type'] = "Customer";
                        } else if (isset($activity['role']) && $activity['role'] == 'S') {
                            $records[$key]['role_type'] = "Franchise";
                        }else{
                            $records[$key]['role_type'] = "Admin";
                        }

                    }
                }

                $response = array(
                    "draw" => intval($request->get('draw')),
                    "data" => $records,
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                );

                if ($response) {
                    $response['sreq'] = 0;
                    return json_encode($response);
                }
            } else {
                $adminListUrl = route('users.index');

                return view('admin.users.index', compact('adminListUrl', 'users'));
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $franchiseList = Team::all()->where('status','A')->pluck('name', 'id')->toArray();
        if (Auth::user()->role == 'A' || Auth::user()->role == 'S') {
            return view('admin.users.create', compact('franchiseList'));
        }
        if (Auth::user()->role == 'C') {
            return redirect('/admin');
        }

        // if (Auth::user()->role == 'S') {
        //   return redirect('/admin');
        // }$cleaners_count

        if (Auth::user()->role == 'U') {
            return redirect('/admin');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
//     public function test(){
//         $digits = CustomHelper::generateVerificationCode();
// dd($digits);
//     }


    public function store(UsersCreateRequest $request){
       
        $input  = $request->all();
      
        if(isset($input['email']) && !empty($input['email'])){
            $input['email']     =   strtolower($input['email']);
        }
       
        $from   = isset($input['api_from']) && !empty($input['api_from']) ? 'api' : '';
        if (!is_null($request->file('photo'))) {
            if ($file = $request->file('photo')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('public/images/users', $name);
                $input['photo'] = $name;
            }
        }else{
            $input['photo'] =   'male-blank-profile.jpg';
        }
      
        if (!is_null($request->dob)) {
            $input['dob'] = date("Y/m/d", strtotime($request->dob));
        }else{
            $input['dob'] = null;
        }
        if(isset($input['franchise_id']) && !empty($input['franchise_id'])){
            $franchiseId   =   $input['franchise_id'];
           
        }
        if(isset($input['tracker_device_driver_id']) && !empty($input['tracker_device_driver_id'])){
            $trackerdeviceId  =   $input['tracker_device_driver_id'];
           
        }
        if(isset($from) && $from != 'api'){
            if (Auth::user()->role  ==  "S") {
                $input['role'] = 'C';
                $teamId                 =   Team::where('user_id',Auth::user()->id)->first();
                $input['franchise_id']  =   $teamId->id;
            }
        }

        if(isset($from) && $from == 'api'){
            $input['verification_otp_time']            =   strtotime(Config::get('app.FORGOT_OTP_TIME'));
            $input['resend_otp_time']                  =   strtotime(Config::get('app.RESEND_OTP_TIME'));
            $otp                                       =   CustomHelper::generateVerificationCode();
            $input['otp_number']                       =   $otp;
            $input['is_verified']                      =   Config::get('app.IS_NOT_VERIFIED');
            $password                                  =   $request->password;
            $input['password']                         =   Hash::make($request->password);
        }else{
            $input['is_verified']                      =   Config::get('app.IS_VERIFIED');
            $password                                  =   CustomHelper::randomPassword(10);

            $input['password']                         =   Hash::make($password);
        }
        $input['is_block']                             =   Config::get('app.UNBLOCKED');

        $userId = User::create($input)->id;

        // if(isset($request->email) && !empty($request->email)){
      

        if(isset($request->email) && !empty($request->email)){
      
            if ($input['role'] == 'C') {
                $obj = new UserFranchise;
                $obj->user_id = $userId;
                if(Auth::user()->role  ==  "S"){
                    $teamId             =   Team::where('user_id',Auth::user()->id)->first();
                    $obj->franchise_id  =   $teamId->id;
                }else{
                    $obj->franchise_id  =   $franchiseId;
                }
                $obj->save();
            }

            if(isset($from) && $from != 'api'){
                if(isset($request->email) && !empty($request->email)){
                    $contactdetail  =   User::where('email',$input['email'])->first();
                    $to             =   $request->email;
                    $to_name        =   ucwords($request->name);
                    $full_name      =   $request->name;
                    $user_name      =   $contactdetail['email'];
                    $password       =   $password;
                    $action         =   "user_registration_by_admin";        
                    $rep_Array      =   array($full_name, $user_name,$password ); 
                    CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);

                    CustomHelper::_SendOtp( $contactdetail['mobile'], $otp);
                }
            }else{
                $contactdetail  =   User::where('email',$input['email'])->first();
                $to             =   $request->email;
                $to_name        =   ucwords($request->name);
                $full_name      =   $request->name;
                $action         =   "new_user_registration_successfully";        
                $rep_Array      =   array($full_name,$otp); 
                CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);
                CustomHelper::_SendOtp( $contactdetail['mobile'], $otp);

                $adminDetails   =   \App\Contact::first();
                if(!empty($adminDetails)){
                    $to             =   $adminDetails->email;
                    $to_name        =   ucwords($adminDetails->c_name);
                    $full_name      =   $request->name;
                    $action         =   "user_registered";        
                    $rep_Array      =   array($full_name); 
                    CustomHelper::callSendMail($to,$to_name,$rep_Array,$action);
                }
            }
        }


        if(isset($input['api_from']) && !empty($input['api_from'])){
            return ["status"=>"success","message"=>"Registration Successful."];
        }else{
            Session::flash('add_user', 'User has been added');
            return redirect('admin/users')->with('added', 'User has been added');
        }
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
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {

        $user = User::with('franchise_name:id,name')->find($id);
    
        $franchiseList = Team::all()->pluck('name', 'id')->toArray();
        
        return view('admin.users.edit', compact('user', 'franchiseList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, $id)
    {
     
        $user = User::findOrFail($id);
        // pr( $request->all());
        
        if ($request->password == '') {
            $input = $request->except('password');
        } else {
            $input = $request->all();
        }

        if ($file = $request->file('photo')) {
            $name = $file->getClientOriginalName();
            $file->move(base_path('public/images/users'), $name);

            if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                unlink(public_path($name));
            };
            $input['photo'] = $name;

        }

        //   if (isset($_FILES['photo'])) {
        //     $file = $request->file('photo');
        //     $name = $file->getClientOriginalName();
        //     $file->move('images/users', $name);

        //     if (file_exists(public_path($name =  $file->getClientOriginalName())))
        //     {
        //         unlink(public_path($name));
        //     };
        //     //Update Image
        //      $input['photo'] = $name;
        // }

        if (!$request->password == '') {
            $input['password'] = bcrypt($request->password);
        }
        if (!is_null($request->dob)) {
            $input['dob'] = date("Y/m/d", strtotime($request->dob));
        }
      
        unset($input['franchise_id']);
       // unset($input['role']);
        $user->update($input);

        return redirect('admin/users')->with('updated', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $user_franchise = UserFranchise::where('user_id', $id);
        $user_franchise->delete();
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('delete_user', 'User has been deleted');
        return redirect('admin/users')->with('deleted', 'User has been deleted');
    }
    public function view(Request $request,$id,$appointmentId){
       
        if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
         
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            
            $totalRecords           =   Transaction::select('count(*) as allcount')->where('id',$appointmentId)->count();
            $totalRecordswithFilter =   Transaction::select('count(*) as allcount')->where($configDataTable['conditions'])->where('id',$appointmentId)->count();
            $records                =  Transaction::with('washing_plan')->where('appointment_id',$appointmentId)
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
                                        ->skip($start)->take($rowperpage)->get();
                                                           
        if(count( $records) > 0){
          
            foreach ( $records as $key => $activity) {     
                $records[$key]['plan_name']                      =   isset($activity['washing_plan']['name'])? $activity['washing_plan']['name']:'System';
                 // $records[$key]['name']             =   $activity->name;   
            }
        }
           
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records, 
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
          
            $adminListUrl       =   route('users.view',[$id,$appointmentId]);
            return view('admin.users.view',compact('adminListUrl'));
        }  
    }



     /**
     * Function for update block status
     *
     * @param $modelId as id of block
     * @param $modelStatus as status of block
     *
     * @return redirect page. 
     */ 
    public function updateBlockStatus($Id = 0,$modelStatus = 0){
        $userData   =   User::where('id',$Id)->first();
        if($userData->is_block == 0){        

            $userData->is_block = 1;
        }else{
            $userData->is_block = 0;
        }
        $userData->save();

        return redirect('admin/users')->with('updated', 'status has been updated');
    }// end updateBlockStatus()

    /**Appoinment
     * Function for cleaner Appoinment
     *
     * @param $Reqquest as request 
     * @param $modelStatus as status of Appoinment
     *
     * @return redirect page. 
    */ 
    public function  cleanerAppoinment(Request $request,$cleanerId){
             
         if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            
            $totalRecords           =   Appointment::select('count(*) as allcount')->where('cleaner_id', $cleanerId)->where('id', '!=', 1)->count();
            $totalRecordswithFilter =   Appointment::select('count(*) as allcount')->where($configDataTable['conditions'])->where('cleaner_id', $cleanerId)->count();
            $records                =   Appointment::with(['washing_plan','user','cleaner','status','user_vehicle','user_address'])
                                        ->where('cleaner_id', $cleanerId)
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
                                        ->skip($start)->take($rowperpage)->get();
                                       
        
        if(count($records) > 0){
     
            foreach ($records as $key => $activity) {
               
                $records[$key]['name']                      =   isset($activity->washing_plan)? $activity->washing_plan->name:'System';
                $records[$key]['type']                      =   isset($activity['user_vehicle'] ['VehicleType']['type'] )? $activity['user_vehicle'] ['VehicleType'] ['type']:'System';
                $records[$key]['appoinment_status']         =   isset($activity['status']['status'] )? $activity ['status']['status']:'System';
                $records[$key]['user_name']                 =   isset($activity['user']['name'] )? $activity['user']['name']:'System';
                $records[$key]['cleaner_name']              =   isset($activity['cleaner']['name'] )? $activity['cleaner']['name']:'System';
                $records[$key]['user_address1']             =   isset($activity['user']['address'])? $activity['user']['address']:'System';
                $records[$key]['subject']                   =   $activity->subject;
  // $records[$key]['name']             =   $activity->name;
  
                if (isset($activity['booking_type']) && $activity['booking_type'] == 'pre_booking') {

                    $records[$key]['booking_type'] = "Pre Booking";

                } else if (isset($activity['booking_type']) && $activity['applicable_for'] == 'instant_booking') {
                    $records[$key]['booking_type'] = "Instant Booking";

                } else{
                    $records[$key]['booking_type'] = "Both";

                }
                
                // $records[$key]['created_humen']    =  format_date($activity->created_at);
             
               
            }
        }
           
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records,
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );

           

            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
            $adminListUrl       =   route('users.appoinment',$cleanerId);
            return view('admin.users.appoinment',compact('adminListUrl'));
        }

    }// end updateAppoinment()

    public function  allFreanchiesAppoinment(Request $request){
       
        if($request->isMethod('post')){
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            // Get records, also we have include$cleanerId->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            

            foreach ($configDataTable['conditions'] as $key => $value) {
                if(isset($value) && count($value) > 0){

                    if(isset($value[0]) && !empty($value[0]) && $value[0] == "appoinment_status"){
                        unset($configDataTable['conditions'][$key]);
                        $val =  str_replace("%","",$value[2]);
                        array_push($configDataTable['conditions'], ['status_id','=',$val]);
                    } 

                    if(isset($value[0]) && !empty($value[0]) && $value[0] == "appointment_date"){
                        unset($configDataTable['conditions'][$key]);
                        $val =  str_replace("%","",$value[2]);

                        $valData    =   explode(' - ', $val);
                        
                        $startDateVal   = date("Y-m-d", strtotime($valData[0]));  
                        $endDateVal     = date("Y-m-d", strtotime($valData[1]));  
                        array_push($configDataTable['conditions'], ['appointment_date','>=',$startDateVal]);
                        array_push($configDataTable['conditions'], ['appointment_date','<=',$endDateVal]);
                    }          
                }
            }


            $totalRecords           =   Appointment::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   Appointment::select('count(*) as allcount')->where($configDataTable['conditions'])->count();

            $records                =   Appointment::with(['washing_plan','user','cleaner','status','user_vehicle','user_address'])->where($configDataTable['conditions'])->orderBy('id', 'DESC')->skip($start)->take($rowperpage)->get();
            
            if(count($records) > 0){
                foreach ($records as $key => $activity) {
                   
                    $records[$key]['name']                      =   isset($activity->washing_plan)? $activity->washing_plan->name:'System';
                    $records[$key]['vehicle_type']              =   isset($activity['user_vehicle']['VehicleType']['type'] )? $activity['user_vehicle']['VehicleType']['type']:'System';
                    $records[$key]['appoinment_status']         =   isset($activity['status']['status'] )? $activity ['status']['status']:'System';
                    $records[$key]['user_name']                 =   isset($activity['user']['name'] )? $activity['user']['name']:'System';
                    $records[$key]['cleaner_name']              =   isset($activity['cleaner']['name'] )? $activity['cleaner']['name']:'System';
                  
                    if (isset($activity['booking_type']) && $activity['booking_type'] == 'pre_booking') {

                        $records[$key]['booking_type'] = "Pre Booking";

                    } else if (isset($activity['booking_type']) && $activity['applicable_for'] == 'instant_booking') {
                        $records[$key]['booking_type'] = "Instant Booking";

                    } else{
                        $records[$key]['booking_type'] = "Instant Booking";

                    }
                }
            }

            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records,
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
          
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
            $adminListUrl       =   route('users.freanchies.all');
            return view('admin.users.all',compact('adminListUrl'));
        }
    }// end updateAppoinment()


    public function view1(Request $request,$id){
       
        if ($request->isMethod('post')) {
           
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
         
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            
            $totalRecords           =   Transaction::select('count(*) as allcount')->where('original_appointment_id',$id)
                                        ->count();
    
            $totalRecordswithFilter =   Transaction::select('count(*) as allcount')
                                        ->where($configDataTable['conditions'])->where('original_appointment_id',$id)
                                        ->count();
    
            $records                =   Transaction::with('washing_plan')->where('original_appointment_id',$id)
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
                                        ->skip($start)->take($rowperpage)->get();
                                                           
            if(count( $records) > 0){
              
                foreach ( $records as $key => $activity) {     
                    $records[$key]['plan_name']                      =   isset($activity['washing_plan']['name'])? $activity['washing_plan']['name']:'System';
                     // $records[$key]['name']             =   $activity->name;  
                     
                     if (isset($activity['type']) && $activity['type'] == 'for_appointment') {
    
                        $records[$key]['type'] = "For Appointment";
    
                    } else if (isset($activity['booking_type']) && $activity['applicable_for'] == 'instant_booking') {
                        $records[$key]['booking_type'] = "Instant Booking";
    
                    } else{
                        $records[$key]['booking_type'] = "Both";
    
                    }
                
                }
            }
           
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records, 
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }
    
        }else{
            $adminListUrl       =   route('users.view1',$id);
            return view('admin.users.view1',compact('adminListUrl'));
        }  
    }

/**
     * Function for update block status
     *
     * @param $modelId as id of block
     * @param $modelStatus as status of block
     *
     * @return redirect page. 
     */ 
    public function updateStatus($Id = 0,$modelStatus = 0){
      
        $AppointmentData   =   Appointment::where('id',$Id)->first();
       
        if($AppointmentData->status_id == 2){        

            $AppointmentData->status_id = 4;

            // SEND NOTIFICATION 
            $rep_array  =   array($Id);
            $action     =   'booking_cancelled';
            CustomHelper::saveNotificationActivity($rep_array,$action,$AppointmentData['user_id']);
            CustomHelper::saveNotificationActivity($rep_array,$action,$AppointmentData['cleaner_id']);
            // END SEND NOTIFICATION 
            
           
        }
        $AppointmentData->save();
      
        return redirect('admin/users/all-franchies-appoinments')->with('updated', 'Appointment has been cancelled');
    }// end updateStatus()


    public function refund(Request $request,$id){
        dd('dd');

    }


     /**
     * Function for update bookings
     *
     * @param $modelId as id of bookings
     *
     * @return redirect page. 
     */ 

    public function bookings(Request $request,$id,$appointmentId){
       
        if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
         
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            
            $totalRecords           =   Transaction::select('count(*) as allcount')->where('id',$appointmentId)->where('id', '!=', 1)->count();
            $totalRecordswithFilter =   Transaction::select('count(*) as allcount')->where($configDataTable['conditions'])->where('id',$appointmentId)->count();
            $records                =   Transaction::with('washing_plan')->where('appointment_id',$appointmentId)
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
                                        ->skip($start)->take($rowperpage)->get();
                                                           
        if(count( $records) > 0){
          
            foreach ( $records as $key => $activity) {     
                $records[$key]['plan_name']                      =   isset($activity['washing_plan']['name'])? $activity['washing_plan']['name']:'System';
                 // $records[$key]['name']             =   $activity->name;   
            }
        }
           
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records, 
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
          
            $adminListUrl       =   route('users.view1',[$id,$appointmentId]);
            return view('admin.users.view1',compact('adminListUrl'));
        }  
    }



    public function allCleanersBookings (Request $request ,$paymentId=null){
    
        if($request->isMethod('post')){
            
          
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            // Get records, also we have include$cleanerId->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
          
            if(Auth::user()->role   ==  "A"){
                
                    $totalRecords           =   Transaction::select('count(*) as allcount')->where('id', '!=', 1)->count();
                    $totalRecordswithFilter =   Transaction::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
                    $records                =   \App\Transaction::with(['payment_count','appointmentAddons','appointmentAddons.appointment_addon','userCancellationRefunds','appointmentDetails.washingPrice','appointmentDetails.user','appointmentDetails.cleaner','appointmentDetails.status','appointmentDetails.user_vehicle','appointmentDetails.user_address','appointmentDetails.CleanerBookingStatusData','appointmentDetails.UserReviewRatingsData','appointmentDetails.appointmentTransactionData','appointmentDetails.appointmentTransactionData.userCancellationRefunds','appointmentDetails.appointment_addons','appointmentDetails.couponDetails'])
                    ->where($configDataTable['conditions'])
                    ->orderBy('id', 'DESC')
                    ->skip($start)->take($rowperpage)->get();
                                            
            }else{
        
    
                $teamId                 =       Team::with('userFranchise')->where('user_id', Auth::user()->id)->pluck('id')->first();
                $cleanerId              =       User::where('franchise_id', $teamId)->pluck('id')->toArray();
            
                $cleanerAppointment     =       Appointment::whereIn('cleaner_id', $cleanerId )->pluck('id')->toArray();
            
                $totalRecords           =       Transaction::select('count(*) as allcount')->whereIn('appointment_id',$cleanerAppointment)->where('id', '!=', 1)->count();
                $totalRecordswithFilter =       Transaction::select('count(*) as allcount')->whereIn('appointment_id',$cleanerAppointment)->where($configDataTable['conditions'])->count();
                $records                =       Transaction::with(['washing_plan','user_name'])->whereIn('appointment_id',$cleanerAppointment)
                                                ->where($configDataTable['conditions'])
                                                ->orderBy('id', 'DESC')
                                                ->skip($start)->take($rowperpage)->get();

            }            
            if(count( $records) > 0){

                foreach ( $records as $key => $activity) {     
                
                    $records[$key]['plan_name']                      =   isset($activity['washing_plan']['name'])? $activity['washing_plan']['name']:'System';
                    $records[$key]['cleaner_name']                      =   isset($activity['user_name']['name'])? $activity['user_name']['name']:'System';
                    if (isset($activity['type']) && $activity['type'] == 'for_appointment') {
                        $records[$key]['type'] = "For Appointment";
                    } else if (isset($activity['type']) && $activity['type'] == 'for_addon') {
                        $records[$key]['type'] = "For AddOn";
                    }else if (isset($activity['booking_type']) && $activity['applicable_for'] == 'instant_booking') {
                        $records[$key]['booking_type'] = "Instant Booking";
                    } else{
                        $records[$key]['booking_type'] = "Both";
                    }
                }
            }
    
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records,
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );

            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

       }else{
            if(isset($paymentId) && !empty($paymentId)){
 
                $appointmentDetail                =     \App\Transaction::with(['payment_count','appointmentAddons','appointmentAddons.appointment_addon',
                                                        'userCancellationRefunds','appointmentDetails.washingPrice','appointmentDetails.user','appointmentDetails.cleaner',
                                                        'appointmentDetails.status','appointmentDetails.user_vehicle','appointmentDetails.user_address',
                                                        'appointmentDetails.CleanerBookingStatusData','appointmentDetails.UserReviewRatingsData',
                                                        'appointmentDetails.appointmentTransactionData',
                                                        'appointmentDetails.appointmentTransactionData.userCancellationRefunds',
                                                        'appointmentDetails.appointment_addons','appointmentDetails.couponDetails'])
                                                        ->where('payment_id',$paymentId)->orderBy('id', 'DESC')
                                                        ->first(); 
                if(isset($appointmentDetail) && !empty( $appointmentDetail)){
                    $appointmentDetail = $appointmentDetail->toArray();
                }   
                return view('admin.users.appointment_data',compact('appointmentDetail'));
            }else{
                $adminListUrl       =   route('users.cleanersBookings');
                return view('admin.users.cleanersBookings',compact('adminListUrl'));
            }
        }
    }// end updateAppoinment()

     /**
     * Function for update block status
     *
     * @param $modelId as id of bloc   die(); of block
     *
     * @return redirect page. 
     */ 

    public function Reschedule(Request $request,$bookedAppointmentId,$cleanerId,$userId){
        if($request->isMethod('post')){
            $formData       =   $request->all();
            $response       =   array();   

            $message = array(
                'booking_date.required'     => trans("Please select a booking date."),
                'slot_time.required'        => trans("Please select a slot time."),
            );

            $validate               =       array('booking_date'=>'required','slot_time'=>'required');
            $validator              =       Validator::make($formData, $validate, $message);
            if ($validator->fails()){ 
                return Redirect::back()->withErrors($validator)->withInput();  
            }

            if(isset($bookedAppointmentId) && !empty($bookedAppointmentId)){
                if(isset($userId) && !empty($userId)){

                    $bookedAppointment      =   \App\Appointment::with('appointment_transaction')
                                                ->where('id',$bookedAppointmentId)
                                                ->where('user_id',$userId)
                                                ->where('status_id',2)
                                                ->first();

                    if(isset($bookedAppointment) && !empty($bookedAppointment)){
                        // $penaltyCharges   =   \App\PenaltyCharges::get()->toArray();

                        // if(isset($penaltyCharges) && count($penaltyCharges) > 0){
                        //     if(isset($penaltyCharges[0]) && !empty($penaltyCharges[0])){
                        //         $penaltyCharges         =       $penaltyCharges[0];
                        //     }
                        // }

                        // $bookedAppointmentData      =       $bookedAppointment->toArray();   
                        // $appointmentAmount          =       0;  
                        // if(isset($bookedAppointmentData['appointment_transaction'][0]['amount']) && !empty($bookedAppointmentData['appointment_transaction'][0]['amount'])){
                        //     $appointmentAmount      =       $bookedAppointmentData['appointment_transaction'][0]['amount'];
                        // }

                        // $currentTime                =       time();
                        // $appointmentTimeFrame       =       strtotime(date($bookedAppointmentData['appointment_date']." ".$bookedAppointmentData['time_frame']));
                        // $beforeDesidedHours          =       $appointmentTimeFrame - (24 * 60 * 60);

                        
                        // if($currentTime >= $beforeDesidedHours && $currentTime <= $appointmentTimeFrame){

                           
                        //     if(isset($penaltyCharges['cancellation_after']) && !empty($penaltyCharges['cancellation_after']) && $penaltyCharges['cancellation_after'] == '%'){
                        //         $cancellationPrice          =       $appointmentAmount*$penaltyCharges['cancellation_after_value']/100;
                        //     }else{
                        //         $cancellationPrice          =       $appointmentAmount-$penaltyCharges['cancellation_after_value'];
                        //     }

                        //     $obj                    =   new \App\CancellationChargesAmount;
                        //     $obj->user_id           =   $formData['user_id'];
                        //     $obj->cleaner_id        =   $bookedAppointmentData['cleaner_id'];
                        //     $obj->real_amount       =   $appointmentAmount;
                        //     $obj->return_amount     =   $cancellationPrice;
                        //     $obj->save();

                        // }



                        $bookedAppointment->update(['appointment_date'=>$formData['booking_date'],'time_frame'=>$formData['slot_time']]);
                        return redirect()->route('users.freanchies.all')->with('added', 'You have successfully resheduled your booked appointment');

                    }
                }
            }
            
            return redirect()->route('users.freanchies.all')->with('deleted', 'Something went wrong.');


            
        }else{
            $appointmentDetails    =   Appointment::where('id',$bookedAppointmentId)->where('user_id',$userId)->where('cleaner_id',$cleanerId)->first();
            $minDate    =   $maxDate    =   Carbon::now()->format('Y-m-d');
            if(isset($appointmentDetails) && !empty($appointmentDetails)){
                if(isset($appointmentDetails->booking_type) && $appointmentDetails->booking_type == "pre_booking"){
                    $minDate        =       Carbon::tomorrow()->format('Y-m-d');
                    $maxDate        =       Carbon::tomorrow()->addDays(7)->format('Y-m-d');
                }
                if($appointmentDetails->status_id  ==  2){
                    return view('admin.users.reschedule',compact('bookedAppointmentId','cleanerId','userId','minDate','maxDate','appointmentDetails'));
                }else{
                    return redirect('admin/')->with('deleted', 'Something went wrong.');
                }

            }else{
                return redirect('admin/')->with('deleted', 'Something went wrong.');
            }
        }
    }

    /**
     * Function for update rescheduleBookings
     *
     * @param $modelId as id of bloc   die(); of block
     *
     * @return redirect page. 
     */ 

    public function rescheduleBookings(Request $request,$appointmentId,$cleanerId,$userId){
        pr($request->all());
        die("dd");
        // return redirect()->route('Api.resheduleBookedAppointment',$request->all());         
    }

    public function allFreanchiesAppoinmentDetail(Request $request,$id){
       
       
            $appointmentDetail       =   Appointment::with(['washing_plan','washingPrice','user','cleaner','status','user_vehicle','user_address','appointment_addons','appointment_transaction'])
                                        ->orderBy('id', 'DESC')->where('id',$id)->first();
          

            if(isset($appointmentDetail) && !empty( $appointmentDetail)){
                $appointmentDetail = $appointmentDetail->toArray();
            }
         
            return view('admin.users.show',compact('appointmentDetail'));
        
    }// end updateAppoinment()

    public function exportInvoicePDF(Request $request,$id){
                                 
   
        $appointmentDetail    =   \App\Transaction::with(['payment_count','appointmentAddons','appointmentAddons.appointment_addon',
                                                        'userCancellationRefunds','appointmentDetails.washingPrice','appointmentDetails.user',
                                                        'appointmentDetails.cleaner','appointmentDetails.status','appointmentDetails.user_vehicle',
                                                        'appointmentDetails.user_address','appointmentDetails.CleanerBookingStatusData',
                                                        'appointmentDetails.UserReviewRatingsData','appointmentDetails.appointmentTransactionData',
                                                        'appointmentDetails.appointmentTransactionData.userCancellationRefunds',
                                                        'appointmentDetails.appointment_addons','appointmentDetails.couponDetails'])
                                                        ->orderBy('id', 'DESC')->where('id',$id) 
                                                        ->first(); 
        if(isset($appointmentDetail) && !empty( $appointmentDetail)){
            $appointmentDetail = $appointmentDetail->toArray();
        }            
       
        view()->share('appointmentDetail',$appointmentDetail);
        $pdf = PDF::loadView('admin.users.pdfview');
        return $pdf->download('show.pdf');
           
    }// end updateAppoinment()
 


    



    public function  allcleanersAppoinment(Request $request,$id){
        if($request->isMethod('post')){
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            // Get records, also we have include$cleanerId->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            
            $totalRecords           =   Appointment::select('count(*) as allcount')->where('id', '!=', 1)->where('user_id',$id)->count();
            $totalRecordswithFilter =   Appointment::select('count(*) as allcount')->where($configDataTable['conditions'])->where('id', '!=', 1)->where('user_id',$id)->count();
            $records                =   Appointment::with(['washing_plan','user','cleaner','status','user_vehicle','user_address'])->where('user_id',$id)
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
                                         ->skip($start)->take($rowperpage)->get();
                                       
            if(count($records) > 0){
                foreach ($records as $key => $activity) {
                   
                    $records[$key]['name']                      =   isset($activity->washing_plan)? $activity->washing_plan->name:'System';
                    $records[$key]['vehicle_type']                 =   isset($activity['user_vehicle']['VehicleType']['type'] )? $activity['user_vehicle']['VehicleType']['type']:'System';
                    $records[$key]['appoinment_status']         =   isset($activity['status']['status'] )? $activity ['status']['status']:'System';
                    $records[$key]['user_name']                 =   isset($activity['user']['name'] )? $activity['user']['name']:'System';
                    $records[$key]['cleaner_name']              =   isset($activity['cleaner']['name'] )? $activity['cleaner']['name']:'System';
                  
                    if (isset($activity['booking_type']) && $activity['booking_type'] == 'pre_booking') {

                        $records[$key]['booking_type'] = "Pre Booking";

                    } else if (isset($activity['booking_type']) && $activity['applicable_for'] == 'instant_booking') {
                        $records[$key]['booking_type'] = "Instant Booking";

                    } else{
                        $records[$key]['booking_type'] = "Instant Booking";

                    }
                }
            }

            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records,
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
          
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
            $adminListUrl       =   route('users.cleanersAppointmnents',$id);
            return view('admin.users.cleanersAppointmnents',compact('adminListUrl'));
        }
    }// end updatecleanersAppoinment()   

    public function export() 
    {
            return Excel::download(new UserExport(request()->name,request()->email), 'user.xlsx');
            //return Excel::download(new UserExport, 'user.csv');
    }
    public function  exportcsv() 
    {

            return Excel::download(new UserExport(request()->name,request()->email), 'user.csv');
    }
   
}