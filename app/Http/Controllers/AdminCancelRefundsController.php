<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddOnCreateRequest;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\CancellationRefunds;
use Razorpay\Api\Api;


class AdminCancelRefundsController extends Controller{

    
    /**
     * Function for display list of all cancel Refunds List
     *
     * @param null
     *
     * @return view page. 
     */

    public function cancelRefundsList(Request $request){

       
        if ($request->isMethod('post')) {
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];


            $recordsVal                =    CancellationRefunds::with('userDetails','cleanerDetails')
                                            ->where('status','<>','processed')
                                            ->orderBy($columnName, $columnOrderType)
                                            ->where($configDataTable['conditions'])
                                            ->skip($start)->take($rowperpage)->get();

           
            $api        =   new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));    
            foreach ($recordsVal as $key => $value) {
                try{
                    $refund =   $api->payment->fetch($value['payment_id'])->fetchRefund($value['refund_id']);
                    if(isset($refund) && !empty($refund)){
                        CancellationRefunds::where('id',$value['id'])->update(['status'=>$refund['status']]);
                    }
                }catch (\Exception $e) {
                }
    
            }



            $totalRecords           =   CancellationRefunds::with('userDetails','cleanerDetails')
                                        ->select('count(*) as allcount')->count();

            $totalRecordswithFilter =   CancellationRefunds::with('userDetails','cleanerDetails')
                                        ->select('count(*) as allcount')
                                        ->where($configDataTable['conditions'])->count();

            $records                =   CancellationRefunds::with('userDetails','cleanerDetails')
                                        ->orderBy($columnName, $columnOrderType)
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
            $adminListUrl   =   route('cancelRefundsList.index');
            return view('admin.cancelRefunds.index',compact('adminListUrl'));
        }

    }// end listTemplate()

}
