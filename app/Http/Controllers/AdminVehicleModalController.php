<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle_company;
use App\Vehicle_modal;
use App\libraries\CustomHelper;
use Auth,Blade,Config,Cache,Cookie,DB,File,Hash,Input,Mail,Redirect,Response,Session,URL,View,Validator;

class AdminVehicleModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

     

      // $vehicle_modals = Vehicle_modal::all();


       $newArray               =   [];


         if ($request->isMethod('post')) {
           
            $vehicle_companies      =   Vehicle_company::pluck('vehicle_company','id')->all();
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
           // $columnName             =   "vehicle_company_id";

            $totalRecords           =   Vehicle_modal::select('count(*) as allcount')->count();
            // $totalVehicle_modal    =   Vehicle_modal::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   Vehicle_modal::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
           
            $records                =   Vehicle_modal::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
                  
            $response = array(
                "draw"                  => intval($request->get('draw')),
                "data"                  => $records, 
                "iTotalRecords"         => $totalRecords,
                "iTotalDisplayRecords"  => $totalRecordswithFilter,
                "vehicle_companies"     => $vehicle_companies,
            );
            if($response){
                $response['sreq']    =   0;
                return json_encode($response);
            }
        }else{
            $vehicle_companies      =   Vehicle_company::pluck('vehicle_company', 'id')->all();
            $adminListUrl           =   route('vehicle_modal.index');
            return view('admin.vehicle_modal.index', compact('vehicle_companies', 'adminListUrl'));
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $vehicle_companies     =   Vehicle_company::pluck('vehicle_company', 'id')->all();

        return view('admin.vehicle_modal.create',compact('vehicle_companies')); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData						=	$request->all();
		if(!empty($formData)){
			$validator 					=	Validator::make(
				$request->all(),
				array(
                    'vehicle_modal'		    	=> 'required|unique:vehicle_modals,vehicle_modal|max:120',
				),
				array(
					"vehicle_modal.required"			        =>	trans("The vehicle modal field is required."),
					
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{ 
                $input = $request->all();

                Vehicle_modal::create($input);
        
                 return redirect('admin/vehicle_modal')->with('added', 'Vehicle Modal has been added');
			
			}
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $vehicle_modal = Vehicle_modal::findOrFail($id);
        $vehicle_companies     =   Vehicle_company::pluck('vehicle_company', 'id')->all();
        return view('admin.vehicle_modal.edit',compact('vehicle_modal','vehicle_companies')); //   //
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
                    'vehicle_modal'		    	=> 'required|unique:vehicle_modals,vehicle_modal|max:120',
				),
				array(
					"vehicle_modal.required"			        =>	trans("The vehicle modal field is required."),
					
				)
			);
			if ($validator->fails()){
				return Redirect::back()->withErrors($validator)->withInput();
			}else{ 
                $vehicle_modal = Vehicle_modal::findOrFail($id);

                $input = $request->all();
        
                $vehicle_modal->update($input);
        
                 return redirect('admin/vehicle_modal')->with('added', 'Vehicle Modal has been updated');
			
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

        $vehicle_modal = Vehicle_modal::findOrFail($id);
    
        $vehicle_modal->delete();

         return redirect('admin/vehicle_modal')->with('added', 'Vehicle Modal has been deleted');
    }
}
