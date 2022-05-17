<?php

namespace App\Http\Controllers;
use App\FAQCategory;
use Illuminate\Http\Request;
use App\Http\Requests\FaqCategoryRequest;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class AdminCategoriesController extends Controller{
    /**
     * Display a listing of faq_category.
     *
     * @return Factory|View
     */
    public function index(Request $request){
        
        $newArray               =   [];
        if ($request->isMethod('post')) {
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   FAQCategory::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   FAQCategory::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   FAQCategory::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
            if(count($records) > 0){
                foreach ($records as $key => $activity) {
                    $records[$key]['name']             =   $activity->name;
                    $records[$key]['slug']             =   $activity->slug;
                   $records[$key]['created_humen']    = date('d-m-Y', strtotime($activity->created_at));
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
            $adminListUrl   =   route('faqs_categories.index');
           return view('admin.faqs.categories.index',compact('adminListUrl'));
        }
    }// end listTemplate()

    /**
     * Show the form for creating a new faq_category.
     *
     * @return Factory|View
     */
    public function create(){
        return view('admin.faqs.categories.create');
    }

    /**
     * Store a newly created faq_category in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(FaqCategoryRequest $request){


          $input = $request->all();
        FAQCategory::create($input);

        // $attributes = request()->validate(FAQCategory::$rules);
        // $category = FAQCategory::create($attributes);
        return redirect('admin/faqs/categories')->with('added', 'faq category has been added');
    }

    /**
     * Display the specified faq_category.
     *
     * @param FAQCategory $category
     * @return Factory|View
     */
    public function show(FAQCategory $category){
        return view('admin.faqs.categories.show',compact('item', $category));
    }

    /**
     * Show the form for editing the specified faq_category.
     *
     * @param FAQCategory $category
     * @return Factory|View
     */
    public function edit($modelId,FAQCategory $category){  
        $item  =   FAQCategory::find($modelId);
        return view('admin.faqs.categories.edit',compact('item'));
    }

    /**
     * Update the specified faq_category in storage.
     *
     * @param FAQCategory $category
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request,$Id=0){
          $category    = FAQCategory::findOrFail($Id);
        $input      = $request->all();
         $category->update($input);

        // $attributes = request()->validate(FAQCategory::$rules);
        // $category   = FAQCategory::find($Id)->update( $attributes);
       return redirect('admin/faqs/categories')->with('added', 'faq category has been updated');
    }

    /**
     * Remove the specified faq_category from storage.
     *
     * @param FAQCategory $category
     * @return RedirectResponse|Redirector
     */
    public function destroy($id){
        \App\FAQ::where('category_id',$id)->delete();
        $item = FAQCategory::findOrFail($id);

        $item->delete();
       return redirect('admin/faqs/categories')->with('added', 'faq category has been deleted');
    }
}
