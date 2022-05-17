<?php

namespace App\Http\Controllers;
use App\Http\Requests\CouponCreateRequest;
use App\Http\Requests\CouponsUpdateRequest;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Coupon;
use Carbon\Carbon;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            $totalRecords           =    Coupon::select('count(*) as allcount')->count();
            $totalRecordswithFilter =    Coupon::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =    Coupon::orderBy('id', 'DESC')->
                                        orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                            ->skip($start)->take($rowperpage)->get();
            if(count($records) > 0){
                foreach ($records as $key => $activity) {
                    $records[$key]['is_active']   =   isset($activity->status)? 'Active':'InActive';
                        if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'I') {
                        $records[$key]['applicable_for'] = "Instant Booking";
                        }else if (isset($activity['applicable_for']) && $activity['applicable_for'] == 'P') {
                                $records[$key]['applicable_for'] = "Pre Booking";
                        }else{
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
            $adminListUrl   =   route('coupons.index');
            return view('admin.coupons.index', compact('adminListUrl'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponCreateRequest $request) {
        $input = $request->all();
        if( isset($input['coupon_code']) && !empty($input['coupon_code'])){
            $input['coupon_code'] = strtoupper($input['coupon_code']);  
            $input['start_date']  = Carbon::parse($request['start_date'])->format('Y-m-d');
            $input['end_date']    = Carbon::parse($request['end_date'])->format('Y-m-d');
            Coupon::create($input);
        }
        Session::flash('delete_user', 'Coupon has been added');
        return redirect('admin/coupons')->with('added', 'Coupon added');
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
    public function edit($id){
        $coupons = Coupon::findOrFail($id);
        return view('admin.coupons.edit', compact('coupons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponsUpdateRequest $request, $id){
        $coupons    = Coupon::findOrFail($id);
        $input      = $request->all();
        $coupons->update($input);
        return redirect('admin/coupons')->with('updated', 'Coupon Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $file = Coupon::findOrFail($id); // File::find($id)
        $file->delete();
        Session::flash('delete_user', 'Coupon has been deleted');
        return redirect('admin/coupons')->with('deleted', 'Coupon deleted');
    }
    /**
     * Function for update coupon status
     *
     * @param $modelId as id of coupon status
     * @param $modelStatus as status of coupon
     *
     * @return redirect page. 
     */ 
    public function updateCouponStatus($Id = 0,$modelStatus = 0){
        $couponData   =   Coupon::where('id',$Id)->first();
        if($couponData->status == 'A'){       
            $couponData->status = 'I';
        }else{
            $couponData->status = 'A';
        }
        $couponData->save();
        return redirect('admin/coupons')->with('updated', 'Coupon status has been updated');
    }// end updatecouponstatus()
     
   
}
