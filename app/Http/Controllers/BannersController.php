<?php

namespace App\Http\Controllers;
use App\Banner;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\libraries\CustomHelper;
use Input,URL;

class BannersController extends Controller
{
    
    /**
     * Display a listing of banner.
     *
     * @return Factory|View
     */
    public function index(Request $request){

        $newArray               =   [];
         if ($request->isMethod('post')) {
            $banners = Banner::all();
            $configDataTable        =   CustomHelper::configDatatable($request);

            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
       
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
 
            $totalRecords           =       Banner::select('count(*) as allcount')->count();

            $totalRecordswithFilter =       Banner::select('count(*) as allcount')
                                            ->where($configDataTable['conditions'])->count();

            $records                =       Banner::orderBy('id', 'DESC')->
                                            orderBy($columnName, $columnOrderType)
                                            ->where($configDataTable['conditions'])
                                            ->skip($start)->take($rowperpage)->get();
            if(count($records) > 0){
                foreach ($records as $key => $activity) {

                    if(isset($activity['image']) && !empty($activity['image']) && file_exists(public_path('images/teams/'.$activity['image']))){
                        
                        //$records[$key]['image']   =   '/public/images/teams/'.$activity['image'];
                        $records[$key]['image']     =   url(URL::asset('public/images/teams/'.$activity['image']) );
                    }else{
                        //  $records[$key]['image']    =   WEBSITE_URL.'/public/images/blank-profile.png';
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
            $banners = Banner::all();
             $adminListUrl = route('banners.index');
            return view('admin.banners.index',compact('adminListUrl',compact('banners')));
        }      
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)

    {
        
        $attributes = request()->validate(Banner::$rules); 
        if($file = $request->file('image')) {
            $name = time().'_banner'.'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/teams'), $name);
            if (file_exists(public_path($name))) {
                unlink(public_path($name));
            };
            $attributes['image'] = $name;
            Banner::create( $attributes);
        }



        // if ($file = $request->file('image')) {
        //     $name = $file->getClientOriginalName();
        //     $file->move(base_path('public/images/teams'), $name);
        
        //     if (file_exists(public_path($name = $file->getClientOriginalName()))) {
        //         unlink(public_path($name));
        //     };
        //     $input['image'] = $name;


        // }

        return redirect('admin/banners')->with('added', 'Banner has been added');
    }

    /**
     * Display the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function show(Banner $banner)
    {
        return $this->view('banners.show')->with('item', $banner);
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function edit($id)
    {
        $banners = Banner::findOrFail($id);

        return view('admin.banners.edit_banner', compact('banners'));
    }

    /**
     * Update the specified banner in storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request,$id)
    {
        $banners = Banner::findOrFail($id);
        $input = $request->all();

        if($file = $request->file('image')) {
            $name = time().'_banner'.'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/teams'), $name);
            if (file_exists(public_path($name))) {
                unlink(public_path($name));
            };
            $input['image'] = $name;
        }
         
        $banners->update($input);
        return redirect('admin/banners')->with('updated', 'Banner Updated');    
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
     $file = Banner::findOrFail($id); 

     $file->delete();

        return redirect('admin/banners')->with('deleted', 'Banner deleted');
    }
}
