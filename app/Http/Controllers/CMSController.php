<?php
namespace App\Http\Controllers;
use App\libraries\CustomHelper;
use App\Banner;
use App\CMS;
use input;
use Illuminate\Http\Request;
class CMSController extends Controller
{
    /**
     * Display a listing of page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $newArray = [];
        if ($request->isMethod('post'))
        {
            $configDataTable = CustomHelper::configDatatable($request);
            $start = ($request->get("start")) ? intval($request->get("start")) : 0;
            $rowperpage = ($request->get("length")) ? intval($request->get("length")) : 10;
            // Get records, also we have included search filter as well
            $columnIndex = $request->get('order') [0]['column'];
            $columnOrderType = $request->get('order') [0]['dir'];
            $columnName = $request->get('columns') [$columnIndex]['data'];
            $totalRecords = CMS::select('count(*) as allcount')->count();
            $totalRecordswithFilter = CMS::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records = CMS::orderBy('id', 'DESC')->orderBy($columnName, $columnOrderType)->where($configDataTable['conditions'])->skip($start)->take($rowperpage)->get();
            if (count($records) > 0)
            {
                foreach ($records as $key => $activity)
                {
                    $records[$key]['parent'] = isset($activity->parent) ? '$activity->parent->title' : '-';
                    if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'I')
                    {
                        $records[$key]['applicable_for'] = "Instant Booking";
                    }
                    else if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'P')
                    {
                        $records[$key]['applicable_for'] = "Pre Booking";
                    }
                    else
                    {
                        $records[$key]['applicable_for'] = "Both";
                    }
                }
            }
            $response = array(
                "draw" => intval($request->get('draw')) ,
                "data" => $records,
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
            );
            if ($response)
            {
                $response['sreq'] = 0;
                return json_encode($response);
            }
        }
        else
        {
            $adminListUrl = route('cms.index');
            return view('admin.cms.index', compact('adminListUrl'));
        }
    }
    /**
     * Show the form for creating a new page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $parents = CMS::all();
        $banners = Banner::all();
        return view('admin.cms.create', compact('parents', 'banners'));
    }
    /**
     * Store a newly created page in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {

        $attributes = request()->validate(CMS::$rules);
        $page = CMS::create($attributes);
        return redirect('admin/cms')->with('added', 'Block has been added');
    }
    /**
     * Display the specified page.
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Page $page)
    {
        return view('cms.show')->with('item', $page);
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
        $item = CMS::findOrFail($id);
        return view('admin.cms.edit', compact('item'));
    }
    /**
     * Update the specified page in storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $cms = CMS::findOrFail($id);
        $input = $request->all();
        $cms->update($input);
        return redirect('admin/cms')->with('added', 'Pages has been updated');
    }
    /**
     * Remove the specified page from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        $file = CMS::findOrFail($id);
        $file->delete();
        return redirect('admin/cms')
            ->with('added', 'Page has been deleted');
    }
}

