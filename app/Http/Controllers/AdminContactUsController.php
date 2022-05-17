<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddOnCreateRequest;
use Illuminate\Http\Request;
use App\ContactUs;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class AdminContactUsController extends Controller
{

    
    /**
     * Function for display list of all email templates
     *
     * @param null
     *
     * @return view page. 
     */

    public function listlogs(Request $request){

       
           if ($request->isMethod('post')) {
            
            $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   ContactUs ::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   ContactUs ::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   ContactUs ::orderBy($columnName, $columnOrderType)->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();

            if(count($records) > 0){
            foreach ($records as $key => $activity) {
              
                $records[$key]['mail_sent']   =   isset($activity->mail_sent)? 'pass':'fail';

                 if (isset($activity['status']) && $activity['status'] == '0') {
                            $records[$key]['status_type'] = "Pending";
                        } else if (isset($activity['status']) && $activity['status'] == '1') {
                            $records[$key]['status_type'] = "Approved";
                        } else if (isset($activity['status']) && $activity['status'] == '2') {
                            $records[$key]['status_type'] = "Rejected";
                        }else{
                            $records[$key]['status_type'] = "Admin";
                        }
                
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
               $adminListUrl   =   route('contactUsList.index');
              return view('admin.contactUsList.index',compact('adminListUrl'));
          
        }

      
        
    }// end listTemplate()

 //    /**
 //     * Function for display page for add email template
 //     *
 //     * @param null
 //     *
 //     * @return view page. 
 //    */
 //    public function addlogs(){
 //        $actionOptions  =   EmailAction::pluck('action','action')->toArray();
 //        return view('admin.email-logs.create',compact('actionOptions'));
       
 //    }// end addTemplate()
    
 //     /**
 //     * Function for display save email template
 //     *
 //     * @param null
 //     *
 //     * @return redirect page. 
 //     */
 //    public function savelogs(Request $request,$Id=0){
 //        $validator = Validator::make(
 //            $request->all(),
 //            array(
 //                'email_to'          => 'required',
 //                'subject'       => 'required',
 //                'email_from'        => 'required',
 //                'message'           => 'required'
 //            ),
 //            array(
 //                'email_to.required' => 'Please enter name.',
 //                'subject.required'  => 'Please enter subject.',
 //                'email_from.required'   => 'Please email_from.',
 //                'message.required'  => 'Please enter message.',
                
 //            )
 //        );
 //        if ($validator->fails()){
 //            return Redirect::back()
 //                ->withErrors($validator)->withInput();  
 //        }else{      
 //            $obj            =   new EmailLogs();
 //            if($Id){
 //                $obj        =   EmailLogs::find($Id);
 //            }   
            
 //            $obj->name      =   ucfirst($request->name);
 //            $obj->subject   =   ucfirst($request->subject);
 //            $obj->body      =   $request->body;
 //            $obj->action    =   $request->action;
 //            if(!$Id){
 //                $obj->slug      =   Str::slug($obj->name, '-');
 //            }
 //            $obj->save();
            
 //            //$this->createEntry(Banner::class, $attributes);
 //            if(!$Id){
 //                $messge = 'Email template has been updated Successfully.';
 //            }else{
 //                $messge = 'New Email template has been created Successfully.';
 //            }
 //            notify()->success('Successfully',$messge);
 //             return redirect('admin/email-logs')->with('added', 'User has been added');
 //            //Session::flash('flash_notice',  trans("messages.$this->model.added_message")); 
 //            //return Redirect::route("$this->model.index");
 //        }
 //    }//  end saveTemplate()

 //    /**
 //     * Function for display page for edit email template page
 //     *
 //     * @param $Id as id of email template
 //     *
 //     * @return view page. 
 //     */
 //    public function editlogs($modelId,Request $request){
 //        $actionOptions  =   EmailAction::pluck('action','action')->toArray();
 //        $item           =   EmailLogs::find($modelId);
        
 //        ### breadcrumbs End ###
 //        if ($request->old() != null) {
 //            $item->name = $request->old('name');
 //            $item->subject = $request->old('subject');  
 //            $item->body = $request->old('body');           
 //        }
 //         return view('admin.email-logs.edit',compact('actionOptions','item'));
       
 //    } // end editTemplate()

 //    *
 //     * Function for update email template
 //     *
 //     * @param $Id as id of email template
 //     *
 //     * @return redirect page. 
     
 //    public function updatelogs($Id=0){
        
 //        $validator = Validator::make(
 //            Input::all(),
 //            array(
 //                'name'          => 'required',
 //                'subject'       => 'required',
 //                'body'          => 'required'
 //            ),
 //            array(
 //                'name.required' => 'Please enter name.',
 //                'subject.required'  => 'Please enter subject.',
 //                'body.required'     => 'Please enter email body.',
 //            )
 //        );
 //        if ($validator->fails()){
 //            return Redirect::back()
 //                ->withErrors($validator)->withInput();  
 //        }else{
            
 //            $obj            =   EmailLogs::find($Id);
 //            $obj->name      =   ucfirst(Input::get('name'));
 //            $obj->subject   =   ucfirst(Input::get('subject'));
 //            $obj->body      =   Input::get('body');
 //            $obj->save();
            
 //             notify()->success('Successfully',trans("messages.EmailTemplate.added_message"));
 //            return redirect('admin/email-logs')->with('added', 'User has been added');
 //        }
 //    } // end updateTemplate()
    
 //    /**
 //    * Function for get all  defined constant  for email template
 //    *
 //    * @param null
 //    *
 //    * @return all  constant defined for template. 
 //    */
 //    public function getConstant(Request $request){

 //        if($request->ajax()){
 //            $actionName     =   $request->action;
 //            $options        =   EmailAction::where('action', '=', $actionName)->pluck('option','action'); 
 //            $a = explode(',',$options[$actionName]);
 //            echo json_encode($a);
 //        }
 //        exit;
 //    }// end getConstant()
    
    
 //    /**
 //     * Remove the specified template from storage.
 //     *
 //     * @param User $id
 //     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
 //    */
 //    // public function destroy($id){
 //    //  $emailTemplate = EmailTemplate::find($id);
 //    //  $this->deleteEntry($emailTemplate, request());
 // //        return redirect_to_resource();
 //    // }

    public function deleteFranchiseList($modelId = 0){
  
        if($modelId){
            $model = FranchiseRequest::findorFail($modelId);
            $model->delete();
          
            // Session::flash('flash_notice',trans("messages.user.deleted_message")); 
        }
       
     return redirect('admin/FranchiseList')->with('added', 'Franchise list has been deleted');
    }// end deleteEmailTemplate()
    // 

  /**
     * Function for update block status
     *
     * @param $modelId as id of block
     * @param $modelStatus as status of block
     *
     * @return redirect page. 
     */ 
    public function updateStatus($Id = 0,$modelStatus = 0){
        $franchiseData   =   FranchiseRequest::where('id',$Id)->first();
        if($franchiseData->status == 1){        
           
            $franchiseData->status = 2;
        }else{
            $franchiseData->status = 1;
        }
       $franchiseData->save();

        return redirect('admin/FranchiseList')->with('updated', 'status has been updated');
    }// end updateBlockStatus()
     
   
}
