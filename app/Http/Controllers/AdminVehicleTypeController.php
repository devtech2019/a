<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle_type;
use App\libraries\CustomHelper;
use Validator;
class AdminVehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $vehicle_types = Vehicle_type::all();


          $newArray               =   [];


         if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   Vehicle_type::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   Vehicle_type::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   Vehicle_type::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
        if(count($records) > 0){
            foreach ($records as $key => $activity) {
               
                $records[$key]['icon']         =   $activity->icon;
                $records[$key]['vehicle_modal']             =   $activity->vehicle_modal;
                
              
                // $records[$key]['is_active']   =   isset($activity->is_active)? 'Active':'InActive';
                
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
            $adminListUrl   =   route('vehicle_type.index');
             return view('admin.vehicle_type.index', compact('adminListUrl'));
        }

       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.vehicle_type.create'); //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        if ($request->isMethod('post')) {
             $rules  =    [
                'icon'      => 'required',
                'type'     => 'required',    
            ];
            
            
            if (isset($input['icon']) && !empty($input['icon'])) {
                $rules['icon'] = 'required';
            } else {
                $rules['icon'] = 'required';
            }

            if (isset($input['type']) && !empty($input['type'])) {
                $rules['type'] = 'required|max:50';
            } else {
                $rules['type'] = 'required|max:50';
            }

           
            $validate = Validator::make($input,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }
               
                Vehicle_type::create($input);
                return redirect('admin/vehicle_type')->with('added', 'Vehicle Class has been updated');
            
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
       $vehicle_type = Vehicle_type::findOrFail($id);
       return view('admin.vehicle_type.edit',compact('vehicle_type')); // //
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
        $vehicle_type = Vehicle_type::findOrFail($id);

        $input = $request->all();

        if ($request->isMethod('post')) {
            $rules  =    [
               'icon'      => 'required',
               'type'     => 'required',    
           ];
           
           
           if (isset($input['icon']) && !empty($input['icon'])) {
               $rules['icon'] = 'required';
           } else {
               $rules['icon'] = 'required';
           }

           if (isset($input['type']) && !empty($input['type'])) {
               $rules['type'] = 'required|max:50';
           } else {
               $rules['type'] = 'required|max:50';
           }

          
           $validate = Validator::make($input,$rules); 
           if($validate->fails()){
               return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
           }
              
               Vehicle_type::create($input);
               return redirect('admin/vehicle_type')->with('added', 'Vehicle Class has been updated');
           
       }

        $vehicle_type->update($input);

         return redirect('admin/vehicle_type')->with('added', 'Vehicle Class has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle_type = Vehicle_type::findOrFail($id);

        $vehicle_type->delete();

       return redirect('admin/vehicle_type')->with('added', 'Vehicle Class has been deleted');
    }
}
