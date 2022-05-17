<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddOnCreateRequest;
use App\Http\Requests\AddOnUpdateRequest;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\AddOn;


class AdminAddOnServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $add_on_services = AddOn::all();



         $newArray               =   [];


         if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   AddOn::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   AddOn::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   AddOn::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
        if(count($records) > 0){
            foreach ($records as $key => $activity) {
                $records[$key]['subject']           =   $activity->subject;
                $records[$key]['name']              =   $activity->name;
                $records[$key]['is_active']         =   isset($activity->status)? 'Active':'InActive';
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
            $adminListUrl   =   route('add_on_services.index');
              return view('admin.add_on_services.index', compact('adminListUrl'));
        }


      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.add_on_services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddOnCreateRequest $request)
    {
        //
        $input = $request->all();

        AddOn::create($input);
 
        Session::flash('delete_user', 'AddOn has been added');

        return redirect('admin/add_on_services')->with('added', 'AddOn added');
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

        $add_on_services = AddOn::findOrFail($id);
       
        return view('admin.add_on_services.edit', compact('add_on_services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddOnUpdateRequest $request, $id)
    {

       $add_on_services = AddOn::findOrFail($id);
        $input = $request->all();
        $add_on_services->update($input);

        return redirect('admin/add_on_services')->with('updated', 'AddOn Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

     // $team = Team::findOrFail($id);
     $file = AddOn::findOrFail($id); // File::find($id)



 //    $destinationPath = asset('public/images/teams/');



     $file->delete();
        

        // $team->delete();

        Session::flash('delete_user', 'add_on_services has been deleted');

        return redirect('admin/add_on_services')->with('deleted', 'Add on services deleted');
    }
    
     
   
}
