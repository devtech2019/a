<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Requests\ZipCodeCreateRequest;
use App\Social_team;
use App\Team;
use App\Opening_hour;
use App\cleanerDailyOpeningRecord;
use App\Cleaner_vehicle;
use App\UserReviewRatings;
use App\User;
use Validator,Auth,URL,Config,Redirect;
use App\UserFranchise;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;

class AdminTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $socials  = Social_team::with('teams')->get();

        $input    = $request->all();

        $DB       = Team::query();

        if(isset($input['name']) && !empty($input['name'])){
            $DB->where('name','like','%'.$input['name'].'%');
        }

        if(isset($input['email']) && !empty($input['email'])){
            $DB->orWhere('email','like','%'.$input['email'].'%');
        }
        $DB->orderBy('id','DESC');
        $teams    = $DB->paginate(10)->setPath('/admin/team');
        
        $pagination = $teams->appends ( array (
          'name'  => $request->get('name'),
          'email' => $request->get('email') 
        ) );



        return view('admin.team.index', compact('teams', 'socials','input'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamCreateRequest $request)
    {
        $formData = $request->all();
        if(!empty($formData)){
			$validator 					=	Validator::make(
				$request->all(),
				array(
                    'post'		    => 'required||max:255',
					'password'	    => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
				),
				array(
					"post.required"			    =>	trans("The name field is required."),
					"password.required"			=>	trans("The password field is required.")
					
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{ 
                        $input = $request->all();
                    

                    if ($file = $request->file('photo')) {
                        $name = time() . $file->getClientOriginalName();
                        $userImg = time().'_user_'.$file->getClientOriginalName();   
                        $file->move('public/images/teams', $name);   
                        copy('public/images/teams/'.$name, 'public/images/users/'.$userImg);
                        $input['photo'] = $name;                 
                    }        
                    $input['password'] = bcrypt($request->password);
                    $input['dob'] = date("Y/m/d", strtotime($request->dob));
                    $input['join_date'] = date("Y/m/d", strtotime($request->join_date));

                    $obj = new User;
                    $obj->name = $input['name'];
                    $obj->email = $input['email'];
                    $obj->mobile = $input['mobile'];
                    $obj->phone = $input['phone'];
                    $obj->dob = $input['dob'];
                    $obj->address = $input['address'];
                    $obj->photo = isset($userImg) && !empty($userImg) ? $userImg : '';
                    $obj->role = 'S';
                    $obj->gender = 'M';
                    $obj->password = $input['password'];
                    if ($obj->save()) {
                        $input['user_id'] = $obj->id;
                    }

                    Team::create($input);
                    Session::flash('delete_user', 'User has been added');
                    return redirect('admin/team')->with('added', 'Franchise Member added');
    }
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
      */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, $id)
    {

        $team = Team::findOrFail($id);
        if ($request->password == '') {
            $input = $request->except('password');
        }else{
            $input = $request->all();
        }
        if ($file = $request->file('photo')) {
            $name = $file->getClientOriginalName();
            $file->move('public/images/teams', $name);
            if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                unlink(public_path($name));
            };
            $input['photo'] = $name;
        }
        if (!$request->password == '') {
            $input['password'] = bcrypt($request->password);

        }
        $input['dob'] = date("Y/m/d", strtotime($request->dob));
        $input['join_date'] = date("Y/m/d", strtotime($request->join_date));
        $team->update($input);
        return redirect('admin/team')->with('updated', 'Franchise Member Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        $file = Team::findOrFail($id);
        $user = User::findOrFail($file->user_id);
        $user->delete();
        $file->delete();
        $franchiseCleaners = User::where('franchise_id',  $file->id)->delete();
        Session::flash('delete_user', 'User has been deleted');
        return redirect('admin/team')->with('deleted', 'Franchise Member deleted');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function franchiseCleaners(Request $request,$id){
        
        $newArray               =   [];
        if($request->isMethod('post')) {
            $configDataTable        =   CustomHelper::configDatatable($request);

            $mainCondition          =   $configDataTable['conditions'];

            $franchiseCleaners      =   UserFranchise::whereHas('userCleaners', function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        })->with(['userCleaners' => function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        }])->where('franchise_id', $id)
                                        ->get()->toArray();
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            //$columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   UserFranchise::whereHas('userCleaners', function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        })->with(['userCleaners' => function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        }])->select('count(*) as allcount')
                                        ->where('franchise_id', $id)->count();

            $totalRecordswithFilter =   UserFranchise::whereHas('userCleaners', function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        })->with(['userCleaners' => function ($query) use ($mainCondition) {
                                             $query->where($mainCondition);
                                        }])->select('count(*) as allcount')
                                        ->where('franchise_id', $id)
                                        ->count();
           
           
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $franchiseCleaners,
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
            );
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }

        }else{
            $adminListUrl   =   route('franchise_cleaner.index',$id);
            $baseUrl        =   URL::to('/').'/franchise_zip_code/'.$id;
            $CleanersAvailabilityUrl        =   URL::to('/').'/franchise_cleaners_availability/'.$id;
            $CleanersDailyUrl = URL::to('/').'/franchise_daily_ride/';
            $CleanersReviewRatingUrl = URL::to('/') . '/cleaners_review_rating/';
            return view('admin.franchise_cleaner.index', compact('adminListUrl','baseUrl','CleanersAvailabilityUrl','CleanersDailyUrl','CleanersReviewRatingUrl'));
        }    
    }// End franchiseCleaners

     /**
     * Show the listing of Cleaners Review Rating.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function CleanersReviewRating(Request $request, $cleanerid)
    {
        $newArray = [];

        if ($request->isMethod('post')) {
        
            $configDataTable = CustomHelper::configDatatable($request);
            $start = $request->get("start") ? intval($request->get("start")) : 0;
            $rowperpage = $request->get("length") ? intval($request->get("length")) : 10;

            // Get records, also we have included search filter as well
            $columnIndex = $request->get('order')[0]['column'];
            $columnOrderType = $request->get('order')[0]['dir'];
            $columnName = $request->get('columns')[$columnIndex]['data'];

            $totalRecords = UserReviewRatings::select('count(*) as allcount')
                ->where('cleaner_id', $cleanerid)
                ->count();
            $totalRecordswithFilter = UserReviewRatings::select('count(*) as allcount')
                ->where('cleaner_id', $cleanerid)
                ->where($configDataTable['conditions'])
                ->count();
            $records = UserReviewRatings::with('appointmentDetails')
                ->where('cleaner_id', $cleanerid)
                ->orderBy('id', 'DESC')
                ->where($configDataTable['conditions'])
                ->skip($start)
                ->take($rowperpage)
                ->get();
            if (count($records) > 0) {
                foreach ($records as $key => $activity) {
                    if (isset($activity['rating']) && $activity['rating'] == 1) {
                        $records[$key]['ratinng'] = "*";
                    } else if (isset($activity['rating']) && $activity['rating'] == 2) {
                        $records[$key]['ratinng'] = "**";
                    }else if (isset($activity['rating']) && $activity['rating'] == 3) {
                        $records[$key]['ratinng'] = "***";
                    } else if (isset($activity['rating']) && $activity['rating'] == 4) {
                        $records[$key]['ratinng'] = "****";
                    }else{
                        $records[$key]['ratinng'] = "*****";
                    }
                    // $records[$key]['created_humen']    =  format_date($activity->created_at);
                }
            }
            $response = [
                "draw" => intval($request->get('draw')),
                "data" => $records,
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
            ];

            if ($response) {
                $response['sreq'] = 0;
                return json_encode($response);
            }
        } else {
            $adminListUrl = route('cleaners_review_rating.index', $cleanerid);

            return view('admin.cleaners_review_rating.index', compact('adminListUrl'));
        }
    } // End CleanersReviewRating


    /**
     * Display a view .
     * @param  $request as a data
     * @param  $franchiseId as a franchise Id
     * @param  $cleanerId as a cleaner Id
     * @return \Illuminate\Http\Response
    */
    public function view(Request $request, $franchiseId,$cleanerId){
        $cleanerDetails       = User::findOrFail($cleanerId);
        if($request->isMethod('post')) {
            $input  = $request->all();
            $rules  = [
              'postal_code'       => 'required|unique:users,postal_code',
              'location'          => 'required',
            ];  
            $validate = Validator::make($input,$rules); 
            if($validate->fails()){
              return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }else{
              
              $cleanerDetails->postal_code = $input['postal_code'];
              $cleanerDetails->location = $input['location'];
              $cleanerDetails->latitude = $input['latitude'];
              $cleanerDetails->longitude = $input['longitude'];
              $cleanerDetails->save();  
              return redirect()->route('franchise_cleaner.index',$franchiseId)->with('updated', 'Franchise ZipCode alloted');
            }
        }else{
            $team                 =   User::findOrFail($cleanerId);
            return view('admin.team.view', compact('team'));
        }
    }// End view

    /**
     * Display a Cleaners Vehicles.
     *
     * @return \Illuminate\Http\Response
    */
    public function CleanersVehicles(Request $request,$franchiseid = null,$cleanersId = null){
       
        $id       =     $cleanersId;
        $addedBy  =     Auth::id(); 
        $data     =     $request->all();
        $item     =     Cleaner_vehicle::where('cleaner_id',$id)->where('franchise_id',$franchiseid)->first();
        if ($request->isMethod('post')) {
            $rules = [
                'vehicle_insurance_no'  => 'required',
                'puc_no'                => 'required',
                'car_registration_img'  => 'required',
                'tracker_device_driver_id'  => 'required',
            ];
           
            if (!is_null($request->file('puc_no'))) {
                $rules['puc_no'] = 'image|file|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx|max:204800';
            }
            
            if (!is_null($request->file('car_registration_img'))) {
                $rules['car_registration_img'] = 'image|mimes:jpeg,png,jpg';
            }
            
            if (!is_null($request->file('vehicle_insurance_no'))) {
                $rules['vehicle_insurance_no'] = 'image|mimes:jpeg,png,jpg';
            }

            if(isset($item) && !empty($item)){
                $rules['vehicle_registration_no'] = 'unique:cleaners_franchise_vehicle,vehicle_registration_no,'.$item->id.',id|regex:/^[A-Z]{2}\s[0-9]{2}\s[A-Z]{2}\s[0-9]{4}$/';
            }else{
                $rules['vehicle_registration_no'] = 'required|unique:cleaners_franchise_vehicle|regex:/^[A-Z]{2}\s[0-9]{2}\s[A-Z]{2}\s[0-9]{4}$/'; 
            }

            $validate = Validator::make($data,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }else{

                if ($file = $request->file('car_registration_img')) {
                    $name = time().'_car_registration_img'.'.'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/teams'), $name);
                    $data['car_registration_img'] = $name;
                }
                if ($file = $request->file('puc_no')) {
                    $name = time().'_puc_no'.'.'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/teams'), $name);
                    $data['puc_no'] = $name;
                }
                if ($file = $request->file('vehicle_insurance_no')) {
                    $name = time().'_vehicle_insurance_no'.'.'.$file->getClientOriginalExtension();
                    $file->move(base_path('public/images/teams'), $name);
                    $data['vehicle_insurance_no'] = $name;
                }
                $data['cleaner_id'] = $id;
                $data['franchise_id'] = $franchiseid; 
                $data['id']=isset($item->id) && !empty($item->id)??'' ;
                $data['added_by'] =  $addedBy;
                Cleaner_vehicle::where('cleaner_id',$id)->where('franchise_id',$franchiseid)->delete();
                $obj                    		=  		new Cleaner_vehicle;
              	$obj->car_registration_img   	=    	$data['car_registration_img'];
              	$obj->puc_no   					=    	$data['puc_no'];
              	$obj->vehicle_insurance_no   	=    	$data['vehicle_insurance_no'];
              	$obj->vehicle_registration_no   =    	$data['vehicle_registration_no'];
                $obj->cleaner_id   				=    	$data['cleaner_id'];
              	$obj->franchise_id   			=    	$data['franchise_id'];
                $obj->tracker_device_driver_id  =    	$data['tracker_device_driver_id'];
                $obj->save();
              
              	if(Auth::user()->role == 'S'){
                	return redirect('admin/users')->with('added', 'Cleaners Vehicles has been updated');
                }else{
                    return redirect('/franchise_cleaner/'.$data['franchise_id'])->with('added', 'Cleaners Vehicles has been updated');
                }
            }
        }
        return view('admin.cleaners_vehicles.create',compact('id','franchiseid','data','item'))->with('updated', 'Cleaner Vehicle updated');
    }// End CleanersVehicles

     /**
     * Cleaners Availability.
     *
     * @return \Illuminate\Http\Response
    */
    public function CleanersAvailability(Request $request, $franchiseId,$cleanersId){
        
        $id           =   $cleanersId;
        $franchiseid  =   $franchiseId;
        $data         =   $request->all(); 
        if ($request->isMethod('post')) {
            $rules = [];
            $i=1;
          $weekDays =  array('Monday'=>'Monday', 'Tuesday'=>'Tuesday', 'Wednesday'=>'Wednesday', 'Thursday'=>'Thursday', 'Friday'=>'Friday', 'Saturday'=>'Saturday', 'Sunday'=>'Sunday'); 
            
            foreach($weekDays as $key => $value){
              if(isset($data['day_check_'.$i]) && !empty($data['day_check_'.$i])){
                $rules['opening_time_'.$i]        = 'required';
                $rules['closing_time_'.$i]        = 'required';
                $rules['lunch_opening_time_'.$i]  = 'required';
                $rules['lunch_closing_time_'.$i]  = 'required';  
              }
              $i++;
            }
            $validate = Validator::make($data,$rules); 
            if($validate->fails()){
                return redirect()->back()->withErrors($validate->errors());
            }else{
              Opening_hour::where('user_id',$cleanersId)->delete();
              $k=1;
              foreach($weekDays as $key => $value){
               
                if(isset($data['day_check_'.$k]) && !empty($data['day_check_'.$k])){
  
                  $obj  = new Opening_hour;
                  $obj->day                         = $data['day_'.$k];
                  $obj->user_id                     = $cleanersId;
                  $obj->opening_time                = $data['opening_time_'.$k];
                  $obj->closing_time                = $data['closing_time_'.$k];
                  $obj->day_check                   = "1";
                  $obj->lunch_opening_time          = $data['lunch_opening_time_'.$k];
                  $obj->lunch_closing_time          = $data['lunch_closing_time_'.$k];
                  $obj->save();
                }
                $k++;
              }
             return redirect()->route('franchise_cleaner.index',$franchiseId)->with('added', 'Cleaners Availability has been updated');
            }
        }
        $item   =   Opening_hour::where('user_id',$cleanersId)->get()->toArray();
        return view('admin.cleaners_availability.edit',compact('id','franchiseid','item'));
      }// End CleanersAvailability
  
    /**
     * Display a listing of the Cleaners Daily Ride Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function CleanersDailyRide(Request $request,$cleaner_id){
          $newArray               =   [];
        if ($request->isMethod('post')) {
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            $totalRecords           =    cleanerDailyOpeningRecord::select('count(*) as allcount')->where('cleaner_id',$cleaner_id)->count();          
            $totalRecordswithFilter =    cleanerDailyOpeningRecord::select('count(*) as allcount')->where('cleaner_id',$cleaner_id)->where($configDataTable['conditions'])->count();
            $records                =    cleanerDailyOpeningRecord::with('cleaners_name')->where('cleaner_id',$cleaner_id)->orderBy('id', 'DESC')
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();                                                                           
            if(count($records) > 0){
                foreach ($records as $key => $activity) {
                    $records[$key]['cleaner_name']   =   isset($activity['cleaners_name']['name'])? $activity['cleaners_name']['name']:'';
                    $records[$key]['is_active']   =   isset($activity->status)? 'Active':'InActive';
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
            $adminListUrl   =   route('cleaners_daily.index',$cleaner_id);
            return view('admin.cleaners_daily.index', compact('adminListUrl'));
        }
      
    }
    /**
     * Display a listing of the cleaners Daily Ride view.
     *
     * @return \Illuminate\Http\Response
     */
    public function  cleanersDailyRideview(Request $request)
    {
          $newArray               =   [];
        if ($request->isMethod('post')) {
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =    cleanerDailyOpeningRecord::select('count(*) as allcount')->count();          
            $totalRecordswithFilter =    cleanerDailyOpeningRecord::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =    cleanerDailyOpeningRecord::with('cleaners_name')->orderBy('id', 'DESC')
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
                                                                                        
            if(count($records) > 0){
                foreach ($records as $key => $activity) { 
                    $records[$key]['cleaner_name']   =   isset($activity['cleaners_name']['name'])? $activity['cleaners_name']['name']:'';
                    $records[$key]['is_active']   =   isset($activity->status)? 'Active':'InActive';
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
            $adminListUrl   =   route('cleaners_daily_ride.index');
          
            return view('admin.cleaners_daily_ride.index', compact('adminListUrl'));
        } 
    }


   

}