<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle_company;
use App\libraries\CustomHelper;
use Auth,Blade,Config,Cache,Cookie,DB,File,Hash,Input,Mail,Redirect,Response,Session,URL,View,Validator;


class AdminVehicleCompController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $vehicle_companies = Vehicle_company::all();

        $newArray               =   [];


         if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   Vehicle_company::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   Vehicle_company::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   Vehicle_company::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
        if(count($records) > 0){
            foreach ($records as $key => $activity) {

                
                $records[$key]['subject']         =   $activity->subject;
                $records[$key]['vehicle_modal']             =   $activity->vehicle_modal;
                
              
                // $records[$key]['is_active']   =   isset($activity->is_active)? 'Active':'InActive';
                
               $records[$key]['created_humen']    = date('d-m-Y', strtotime($activity->created_at));
                $records[$key]['updated_humen']    = date('d-m-Y', strtotime($activity->updated_at)); 
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
            $adminListUrl   =   route('vehicle_company.index');
            return view('admin.vehicle_company.index', compact('adminListUrl'));
        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle_company.create');//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    public function store(Request $request){
		$formData						=	$request->all();
		if(!empty($formData)){
			$validator 					=	Validator::make(
				$request->all(),
				array(
                    'vehicle_company'		    	=> 'required|unique:vehicle_companies,vehicle_company|max:120',
				),
				array(
					"vehicle_company.required"			        =>	trans("The vehicle company field is required."),
					
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{ 
        $input = $request->all();

        Vehicle_company::create($input);

          return redirect('admin/vehicle_company')->with('added', 'Vehicle Company has been added');
			
			}
		}
	}//end save()

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
        $vehicle_company = Vehicle_company::findOrFail($id);
        return view('admin.vehicle_company.edit',compact('vehicle_company')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formData						=	$request->all();
		if(!empty($formData)){
			$validator 					=	Validator::make(
				$request->all(),
				array(
                    'vehicle_company'		    	=> 'required|unique:vehicle_companies,vehicle_company',
				),
				array(
					"vehicle_company.required"			        =>	trans("The vehicle company field is required."),
					
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{ 
                $vehicle_company = Vehicle_company::findOrFail($id);


                $input = $request->all();
        
                $vehicle_company->update($input);
        
                return redirect('admin/vehicle_company')->with('added', 'Vehicle Company has been updated');
			
			}
		}
	}
        
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle_company = Vehicle_company::findOrFail($id);

        $vehicle_company->delete();

       return redirect('admin/vehicle_company')->with('added', 'Vehicle Company has been deleted');
    }
}
