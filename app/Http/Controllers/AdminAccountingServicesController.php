<?php

namespace App\Http\Controllers;
use App\AccountingServices;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\libraries\CustomHelper;
use Input,URL,Auth;
use Validator;
class AdminAccountingServicesController extends Controller
{
    
    /**
     * Display a listing of banner.
     *
     * @return Factory|View
     */
    public function index(Request $request){
        $newArray               =   [];
         if ($request->isMethod('post')) {
            $banners = AccountingServices::all();
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     
            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];
            $totalRecords           =       AccountingServices::select('count(*) as allcount')->count();
            $totalRecordswithFilter =       AccountingServices::select('count(*) as allcount')
                                            ->where($configDataTable['conditions'])->count();

            $records                =       AccountingServices::orderBy('id', 'DESC')->
                                            orderBy($columnName, $columnOrderType)
                                            ->where($configDataTable['conditions'])
                                            ->skip($start)->take($rowperpage)->get();
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
            $adminListUrl = route('accounting_services.index');
            return view('admin.accounting_services.index',compact('adminListUrl'));
        }      
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.accounting_services.create');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request){
        $input = $request->all();
        if ($request->isMethod('post')) {
            $rules = [
                'amount' => 'required|numeric|min:1|digits_between:1,10',
            ];
            $validate = Validator::make($input,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }
        }
        $input['amount'] = $request->amount;
        $input['date'] = date("Y-m-d", strtotime( $request->date));
        $input['franchise_id'] = Auth::id();
        AccountingServices::create($input);
        return redirect('admin/accounting-services')->with('added', 'Account has been added');
    }

    /**
     * Display the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function show(Banner $banner)
    {
        return $this->view('accounting_services.show')->with('item', $banner);
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function edit($id)
    {
        $accounts = AccountingServices::findOrFail($id);
        return view('admin.accounting_services.edit', compact('accounts'));
    }

    /**
     * Update the specified banner in storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request,$id)
    {
        $accounts = AccountingServices::findOrFail($id);
        $input = $request->all();
        if ($request->isMethod('post')) {
            $rules = [
                'amount' => 'required|numeric|min:1|digits_between:1,10',
            ];
            $validate = Validator::make($input,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }
        }
        $accounts->update($input);
        return redirect('admin/accounting-services')->with('updated', 'Account Updated');    
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
     $file = AccountingServices::findOrFail($id); 
     $file->delete();
        return redirect('admin/accounting-services')->with('deleted', 'Account deleted');
    }
}
