<?php
namespace App\Http\Controllers;
use App\libraries\CustomHelper;
use App\Banner;
use App\PageContent;
use App\Page;
use input;
use Illuminate\Http\Request;
use Validator;
class PagesController extends Controller
{
    /**
     * Display a listing of page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
     
        $items = Page::all();


          $newArray               =   [];


         if ($request->isMethod('post')) {
           
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =    Page::select('count(*) as allcount')->count();
            $totalRecordswithFilter =    Page::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =    Page::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
        if(count($records) > 0){
            foreach ($records as $key => $activity) {
                
   
                $records[$key]['parent']   = isset($activity->parent)? '$activity->parent->title':'-';


                    if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'I') {

                            $records[$key]['applicable_for'] = "Instant Booking";

                        } else if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'P') {
                            $records[$key]['applicable_for'] = "Pre Booking";

                        } else{
                            $records[$key]['applicable_for'] = "Both";

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
            $adminListUrl   =   route('pages.index');
            return view('admin.pages.index',compact('adminListUrl'));
        }
        
    }

    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
      
        $parents = Page::all();
        $banners = Banner::all();

        return view('admin.pages.create', compact('parents', 'banners'));
    }

    /**
     * Store a newly created page in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = request()->validate(Page::$rules);
      
    //    if(isset($attributes) && !empty($attributes) && $attributes['slug'] == 'app-about'){
       
    //     $obj = new Page;
    //     $obj->video_url = $attributes['video_url'];
       
    //     $obj->save();

    //    }

        // $attributes['is_header'] = (bool) input('is_header');
        // $attributes['is_hidden'] = (bool) input('is_hidden');
        // $attributes['is_footer'] = (bool) input('is_footer');
        // $attributes['is_featured'] = (bool) input('is_featured');
        // $attributes['url_parent_id'] = (int) $attributes['url_parent_id'] === 0 ? $attributes['parent_id'] : $attributes['url_parent_id'];

      $page =  Page::create( $attributes);

        // if ($page) {
        //     $page->updateUrl()->save();
        //     $page->banners()->sync(input('banners'));
        // }

        return redirect('admin/blocks')->with('added', 'Block has been added');
    }

    /**
     * Display the specified page.
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Page $page)
    {
        return view('pages.show')->with('item', $page);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // fix for when you
        // edit sections from the edit page
        // or delete photo/document then
        // need to update resource url
      
        $item = Page::findOrFail($id);

        // $parents = Page::all();
        // $banners = Banner::all();

        return view('admin.pages.edit', compact('item'));
    }

    /**
     * Update the specified page in storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,$id)
    {
        // $attributes = request()->validate(Page::$rules);

        // $attributes['is_header'] = (bool) input('is_header');
        // $attributes['is_hidden'] = (bool) input('is_hidden');
        // $attributes['is_footer'] = (bool) input('is_footer');
        // $attributes['is_featured'] = (bool) input('is_featured');
        $blocks    = Page::findOrFail($id);
        $input      = $request->all();
        if(isset($request) && !empty($request) && $request->slug == 'app-about') {
            
            $rules = [
                'video_url' => 'required|url',
                
            ];    
            $validate = Validator::make( $input,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }
        }
        if(isset($request) && !empty($request) && $request->slug == 'app-about'){
     
            $obj = new Page;
            $obj->video_url = $input['video_url'];
           
            $blocks->update($input);
    
           }
        $blocks->update($input);
       
        // $page = $this->updateEntry($page, $attributes);
        // $page->updateUrl()->save();
        // $page->banners()->sync(input('banners'));

        return redirect('admin/blocks')->with('added', 'Block has been added');
    }

    /**
     * Remove the specified page from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Page $page,$id)
    {
         $file = Page::findOrFail($id); 

         $file->delete();

        return redirect('admin/blocks')->with('added', 'Block has been deleted');
    }
}
