<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Auth;
use App\FAQ;
use App\FAQCategory;




class AdminFAQController extends Controller
{
    /**
     * Display a listing of faq.
     *
     * @return Factory|View
     */
    public function index(Request $request){
       // $items = FAQ::with('category')->get();
        $newArray               =   [];
        if ($request->isMethod('post')) {
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   FAQ::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   FAQ::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =    FAQ::with('category')->orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
                                         if(count($records) > 0){
            foreach ($records as $key => $activity) {

                
                // $records[$key]['subject']         =   $activity->subject;
                // $records[$key]['vehicle_modal']             =   $activity->vehicle_modal;
                
              
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
            $adminListUrl   =   route('faqs.index');
            return view('admin.faqs.index',compact('adminListUrl'));
        }
    }

    /**
     * Show the form for creating a new faq.
     *
     * @return Factory|View
     */
    public function create(){
        $categories = FAQCategory::getAllList();
        return view('admin.faqs.create')->with('categories', $categories);
    }

    /**
     * Store a newly created faq in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(){
        $attributes = request()->validate(FAQ::$rules);
        $faq = FAQ::create($attributes);
        return redirect('admin/faqs')->with('added', 'faq has been added');
    }

    /**
     * Display the specified faq.
     *
     * @param FAQ $faq
     * @return Factory|View
     */
    public function show(FAQ $faq){
        return $this->view('faqs.show')->with('item', $faq);
    }

    /**
     * Show the form for editing the specified faq.
     *
     * @param FAQ $faq
     * @return Factory|View
     */
    public function edit($modelId,FAQ $faq){
        $categories  =      FAQCategory::getAllList();
        $item        =      FAQ::find($modelId);
        return view('admin.faqs.edit',compact('item','categories'));
    }

    /**
     * Update the specified faq in storage.
     *
     * @param FAQ $faq
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request,$Id=0){
        $attributes = request()->validate(FAQ::$rules);
        $faq  = FAQ::find($Id)->update( $attributes);
        return redirect('admin/faqs')->with('added', 'faq  has been updated');
    }

    /**
     * Remove the specified faq from storage.
     *
     * @param FAQ $faq
     * @return RedirectResponse|Redirector
     */
    public function destroy($id){
        $item = FAQ::findOrFail($id);
        $item->delete();
        return redirect('admin/faqs')->with('added', 'faq has been deleted');
    }
   
}
