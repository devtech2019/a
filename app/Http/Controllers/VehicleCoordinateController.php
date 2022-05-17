<?php

namespace App\Http\Controllers;
use App\UserAddressBook;
use App\Cleaner_vehicle;
use App\Appointment;
use App\User;
use App\UserVehicle;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\libraries\CustomHelper;
use Auth,Blade,Config,Cache,Cookie,DB,File,Hash,Input,Mail,Redirect,Response,Session,URL,View,Validator;

class VehicleCoordinateController extends Controller
{
    
    /**
     * Display a listing of banner.
     *
     * @return Factory|View
     */
    public function index(){
             $response = [];
        return view('admin.vehicle_coordinate_data.index',compact('response'));
    }

    

    /**
     * Store a newly created banner in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function VehicleLocation(Request $request){
                $input = $request->all();
                $data = $input['formData'];
                $vehicle_number = $data['vehicle_number'];
                $client = new Client();
                $response = $client->get('https://loconav.com/api/v3/device/all_devices_with_count', [
                'headers' => [
                    'Authorization' => 'AhUuvrxg3aDqNhLp9oof',
                ],
                'form_params' => [
                    'vehicle_number' => $vehicle_number,
                ],
            ]);

            $response = json_decode($response->getBody(), true);
            return response($response);
                
		}

        public function VehicleCoordinate(Request $request){
            $input = $request->all();
            $data = $input['formData'];
            
            $start_time = strtotime($data['start_time']); 
            $end_time = strtotime($data['end_time']);
            $vehicle_number = $data['vehicle_number'];
            $date = date('Y-m-d', strtotime($data['start_time']));
            $stime = date("H:i", strtotime($data['start_time']));
            $etime = date('H:i', strtotime($data['end_time']));
            // dd($stime, $etime);
            
            $cleaner = Cleaner_vehicle::where('vehicle_registration_no',$vehicle_number)->pluck('cleaner_id');
            $appointment = Appointment::where('cleaner_id',$cleaner[0])->where('appointment_date',$date)
            //    ->where('time_frame','>=',$stime)->where('time_frame','>=',$etime)
            ->get(['id','cleaner_id','appointment_date','time_frame','address_id','user_id','vehicle_id'])->toArray();
            
            
            if(!empty($appointment)){
                foreach($appointment as $key => $item){
                    $address = UserAddressBook::where('id',$item['address_id'])->first(['lat','lng','address'])->toArray();
                    $user = User::where('id',$item['user_id'])->pluck('name')->toArray();
                    $user_vehicle = UserVehicle::where('id',$item['vehicle_id'])->pluck('vehicle_registration_no')->toArray();
                    $appointment[$key]['lat'] = $address['lat'];
                    $appointment[$key]['lng'] = $address['lng'];
                    $appointment[$key]['address'] = $address['address'];
                    $appointment[$key]['cleaner_name'] = $user[0];
                    $appointment[$key]['vehicle_registration_no'] = $user_vehicle[0];
                    
                }
                
            }
            // dd($appointment);
            $client = new Client();
            $response = $client->get('https://loconav.com/api/v3/vehicle/coordinate_data?start_time=1643766663000&end_time=1643806263000', [
                // $response = $client->get('https://loconav.com/api/v3/vehicle/coordinate_data', [
                'headers' => [
                    'Authorization' => 'AhUuvrxg3aDqNhLp9oof',
                ],
                'form_params' => [
                    // 'start_time' => $start_time,
                    // 'end_time' => $end_time,
                    'vehicle_number' => $vehicle_number,
                ],
            ]);

            $response = json_decode($response->getBody(), true);
            $finalresponse = array('apiresponse'=>$response,'addressesArray'=>$appointment);
            return response($finalresponse);
            
            
    }

}


// public function VehicleCoordinate(Request $request){
//     $input = $request->all();
//     $data = $input['formData'];
//     $previous = Session::get('previus_requested_data');
//     $start_time = strtotime($data['start_time']); 
//     $end_time = strtotime($data['end_time']);
//     $vehicle_number = $data['vehicle_number'];
//     $date = date('Y-m-d', strtotime($data['start_time']));
//     $stime = date("H:i", strtotime($data['start_time']));
//     $etime = date('H:i', strtotime($data['end_time']));

//     $cleaner = Cleaner_vehicle::where('vehicle_registration_no',$vehicle_number)->pluck('cleaner_id');
//     $appointment = Appointment::where('cleaner_id',$cleaner[0])->where('appointment_date',$date)
//                 //    ->where('time_frame','>=',$stime)->where('time_frame','>=',$etime)
//                 ->get(['id','cleaner_id','appointment_date','time_frame','address_id','user_id','vehicle_id'])->toArray();

                
//                 if(!empty($appointment)){
//                     foreach($appointment as $key => $item){
//                         $address = UserAddressBook::where('id',$item['address_id'])->first(['lat','lng','address'])->toArray();
//                         $user = User::where('id',$item['user_id'])->pluck('name')->toArray();
//                         $user_vehicle = UserVehicle::where('id',$item['vehicle_id'])->pluck('vehicle_registration_no')->toArray();
//                         $appointment[$key]['lat'] = $address['lat'];
//                         $appointment[$key]['lng'] = $address['lng'];
//                         $appointment[$key]['address'] = $address['address'];
//                         $appointment[$key]['cleaner_name'] = $user[0];
//                         $appointment[$key]['vehicle_registration_no'] = $user_vehicle[0];

//                     }
                    
//     }

//     // dd($stime, $etime);
//     if(!empty($previous) && $previous['end_time'] == $data['end_time'] && $previous['vehicle_number'] == $data['vehicle_number']){

//             $previosresponse = Session::get('Getresponse');
//             $finalresponse = array('apiresponse'=>$previosresponse,'addressesArray'=>$appointment);
//             // dd($finalresponse);
//             return response($finalresponse);

// }else{
        
//     unset($previosresponse);
//     unset($response);
//     Session::put('previus_requested_data', $data);


    
//     $client = new Client();
//     $response = $client->get('https://loconav.com/api/v3/vehicle/coordinate_data?start_time=1643766663000&end_time=1643806263000&vehicle_number=MH14JL3079', [
//         // $response = $client->get('https://loconav.com/api/v3/vehicle/coordinate_data', [
//         'headers' => [
//             'Authorization' => 'AhUuvrxg3aDqNhLp9oof',
//         ],
//         // 'form_params' => [
//         //     'start_time' => $start_time,
//         //     'end_time' => $end_time,
//         //     'vehicle_number' => $vehicle_number,
//         // ],
//     ]);

//     $response = json_decode($response->getBody(), true);
//     Session::put('Getresponse', $response);
//     $finalresponse = array('apiresponse'=>$response,'addressesArray'=>$appointment);
//     return response($finalresponse);
// }
    
    
    
// }
