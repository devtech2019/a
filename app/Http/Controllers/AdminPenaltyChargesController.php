<?php

namespace App\Http\Controllers;

use App\PenaltyCharges;
use App\CancellationChargesAmount;
use Illuminate\Http\Request;
use App\Http\Requests\PenaltyChargesRequest;
use App\libraries\CustomHelper;
use Validator;
use Razorpay\Api\Api;

class AdminPenaltyChargesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request){


        $data = $request->all();

        if ($request->isMethod('post')) {
            
            $rules = [
                'cancellation_before' => 'required',
                'cancellation_within' => 'required',
                'cancellation_after' => 'required',
            ];
            
            if (isset($data['cancellation_before']) && !empty($data['cancellation_before']) && $data['cancellation_before'] == '%') {
                $rules['cancellation_before_value'] = 'required|numeric|min:1|max:100';
            } else {
                $rules['cancellation_before_value'] = 'required|numeric|min:1';
            }

            if (isset($data['cancellation_within']) && !empty($data['cancellation_within']) && $data['cancellation_within'] == '%') {
                $rules['cancellation_within_value'] = 'required|numeric|min:1|max:100';
            } else {
                $rules['cancellation_within_value'] = 'required|numeric|min:1';
            }

            if (isset($data['cancellation_after']) && !empty($data['cancellation_after']) && $data['cancellation_after'] == '%') {
                $rules['cancellation_after_value'] = 'required|numeric|min:1|max:100';
            } else {
                $rules['cancellation_after_value'] = 'required|numeric|min:1';
            }
        
            $validate = Validator::make($data,$rules); 
            if($validate->fails()){
                return redirect()->back()->withInput($request->all())->withErrors($validate->errors());
            }else{
                PenaltyCharges::truncate();
                unset($data["_token"]);
                PenaltyCharges::create($data);
                return redirect()->back()->with('added', 'Penalty has been updated');
            }
        }else{
            $item = PenaltyCharges::find(1);
            return view('admin.penalty.edit', compact('item'));
        }
       
    }

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  cancellationChargesAmount(Request $request)
    {

        $newArray               =   [];
        if($request->isMethod('post')) {
            // $franchiseCleaners     =    UserFranchise::with('userCleaners')->where('franchise_id', $id)
            //                             ->get()->toArray();
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   CancellationChargesAmount::with(['cancellationUserDetail,cancellationCleanerDetail'])
                                        ->select('count(*) as allcount')->count();
            $totalRecordswithFilter =   CancellationChargesAmount::with(['cancellationUserDetail,cancellationCleanerDetail'])
                                        ->select('count(*) as allcount')
                                        ->where($configDataTable['conditions'])
                                        ->count();
            $records                =   CancellationChargesAmount::with(['cancellationCleanerDetail','cancellationUserDetail'])
                                        ->where($configDataTable['conditions'])
                                        ->orderBy('id', 'DESC')
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
            $adminListUrl   =   route('penalty.index');
          
            return view('admin.penalty.index', compact('adminListUrl'));
        }   
       
    }


    // public function cancellationValidation(Request $request){
       
    //     $data = request()->all();

        
    //     $rules= [
    //         'amount'            =>'required|numeric|digits_between:1,5',
    //     ];
    //     $msg = [
    //         'amount.required'          =>'Please enter amount',
    //     ];

    //     $validate=$this->validate($request, $rules, $msg);
       
    //     $transactiondetail = CancellationChargesAmount::with('cancellationTransactionDetail')->get();
    //     pr( $transactiondetail);
    //     if(isset($data['amount']) && !(empty($data['amount']))){
          
    //         $amountdetail = CancellationChargesAmount::where('id',$data['id'])->update(array('status' => 1));
    //         // pr( $amountdetail);

          
    //     }
    // }         
    public function   refundTransaction(Request $request,$type,$id){
        
       
            $data = request()->all();
           
            $transactiondetail = CancellationChargesAmount::with('cancellationTransactionDetail:id,payment_id')->where('id',$id)->first();
            //  pr( $transactiondetail->cancellationTransactionDetail->payment_id);
            //$api        =   new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));


            // $api->payment->fetch($transactiondetail->cancellationTransactionDetail->payment_id)->refund(array("amount"=> "100", "speed"=>"normal", "notes"=>array("notes_key_1"=>"Beam me up Scotty.", "notes_key_2"=>"Engage"), "receipt"=>"Receipt No. 31"));

            // $api->payment->fetch($transactiondetail->cancellationTransactionDetail->payment_id)->refund(array("amount"=> "100","speed"=>"optimum","receipt"=>"Receipt No. 31"));
          
    }
   
}
