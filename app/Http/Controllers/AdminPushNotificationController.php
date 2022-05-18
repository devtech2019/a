<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddOnCreateRequest;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator,Redirect,Input;
use Illuminate\Support\Str;
use App\NotificationTemplate;
use App\Notifications_Action;



class AdminPushNotificationController extends Controller
{

    
   /**
     * Function for display list of all email templates
     *
     * @param null
     *
     * @return view page. 
     */

    public function listTemplate(Request $request){
 
        $newArray               =   [];

         if ($request->isMethod('post')) {           
           $configDataTable        =   CustomHelper::configDatatable($request);
            $start                  =   ($request->get("start"))  ? intval($request->get("start"))  : 0;
            $rowperpage             =   ($request->get("length")) ? intval($request->get("length")) : 10;     

            // Get records, also we have included search filter as well
            $columnIndex            =   $request->get('order')[0]['column'];
            $columnOrderType        =   $request->get('order')[0]['dir'];
            $columnName             =   $request->get('columns')[$columnIndex]['data'];

            $totalRecords           =   NotificationTemplate::select('count(*) as allcount')->count();
            $totalRecordswithFilter =   NotificationTemplate::select('count(*) as allcount')->where($configDataTable['conditions'])->count();
            $records                =   NotificationTemplate::orderBy('id', 'DESC')->orderBy($columnName, $columnOrderType)
                                        ->where($configDataTable['conditions'])
                                        ->skip($start)->take($rowperpage)->get();
        if(count($records) > 0){
            foreach ($records as $key => $activity) {
                
                $records[$key]['subject']         =   $activity->subject;
                $records[$key]['name']             =   $activity->name;
                $records[$key]['created']             =   $activity->created_at->format('Y-m-d');
              
                $records[$key]['is_active']   =   isset($activity->is_active)? 'Active':'InActive';
                
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
            $adminListUrl   =   route('PushNotification.index');
            return view('admin.push_notifications.index',compact('adminListUrl'));
        }  
        
    }// end listTemplate()

    /**
     * Function for display page for add email template
     *
     * @param null
     *
     * @return view page. 
    */
    public function addTemplate(){
        $actionOptions  =   Notifications_Action::pluck('action','action')->toArray();
        return view('admin.push_notifications.create',compact('actionOptions'));
        
    }// end addTemplate()
    
     /**
     * Function for display save email template
     *
     * @param null
     *
     * @return redirect page. 
     */
    public function saveTemplate(Request $request,$Id=0){
        $validator = Validator::make(
            $request->all(),
            array(
                'name'          => 'required|min:3|max:100',
                'subject'       => 'required|min:3|max:200',
                'action'        => 'required',
                'body'          => 'required'
            ),
            array(
                'name.required' => 'Please enter name.',
                'subject.required'  => 'Please enter subject.',
                'action.required'   => 'Please select action.',
                'body.required'     => 'Please enter email body.',
                
            )
        );
        if ($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)->withInput();  
        }else{      
            $obj            =   new NotificationTemplate();
            if($Id){
                $obj        =   NotificationTemplate::find($Id);
            }   
            
            $obj->name      =   ucfirst($request->name);
            $obj->subject   =   ucfirst($request->subject);
            $obj->body      =   $request->body;
            $obj->action    =   $request->action;
            if(!$Id){
                $obj->slug      =   Str::slug($obj->name, '-');
            }
            $obj->save();
            
            //$this->createEntry(Banner::class, $attributes);
            if(!$Id){
                $messge = 'push notifications has been updated Successfully.';
            }else{
                $messge = 'New push notifications has been created Successfully.';
            }
        return redirect('admin/push-notifications')->with('added', 'push-notifications has been added');
           
            //Session::flash('flash_notice',  trans("messages.$this->model.added_message")); 
            //return Redirect::route("$this->model.index");
        }
    }//  end saveTemplate()

    /**
     * Function for display page for edit email template page
     *
     * @param $Id as id of email template
     *
     * @return view page. 
     */
    public function editTemplate($modelId,Request $request){
        $actionOptions  =   Notifications_Action::pluck('action','action')->toArray();
        $item           =   NotificationTemplate::find($modelId);
        
        ### breadcrumbs End ###
        if ($request->old() != null) {
            $item->name = $request->old('name');
            $item->subject = $request->old('subject');  
            $item->body = $request->old('body');           
        }
          return view('admin.push_notifications.edit',compact('actionOptions','item'));
        
    } // end editTemplate()

    /**
     * Function for update email template
     *
     * @param $Id as id of email template
     *
     * @return redirect page. 
     */
    public function updateTemplate($Id=0){
        
        $validator = Validator::make(
            Input::all(),
            array(
                'name'          => 'required',
                'subject'       => 'required',
                'body'          => 'required'
            ),
            array(
                'name.required' => 'Please enter name.',
                'subject.required'  => 'Please enter subject.',
                'body.required'     => 'Please enter email body.',
            )
        );
        if ($validator->fails()){
            return Redirect::back()
                ->withErrors($validator)->withInput();  
        }else{
            
            $obj            =   NotificationTemplate::find($Id);
            $obj->name      =   ucfirst(Input::get('name'));
            $obj->subject   =   ucfirst(Input::get('subject'));
            $obj->body      =   Input::get('body');
            $obj->save();
            
  
          return redirect('admin/push-notifications')->with('added', 'push-notifications has been updated');
        }
    } // end updateTemplate()
    
    /**
    * Function for get all  defined constant  for email template
    *
    * @param null
    *
    * @return all  constant defined for template. 
    */
    public function getConstant(Request $request){

        if($request->ajax()){
            $actionName     =   $request->action;
            $options        =   Notifications_Action::where('action', '=', $actionName)->pluck('option','action'); 
            $a = explode(',',$options[$actionName]);
            echo json_encode($a);
        }
        exit;
    }// end getConstant()
    
    
    /**
     * Remove the specified template from storage.
     *
     * @param User $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    */
   

    public function deletePushNotification($modelId = 0){

        if($modelId){
            $model = NotificationTemplate::findorFail($modelId);
            $model->delete();
            
        }

       return redirect('/admin/push-notifications')->with('added', 'push-notifications has been deleted');
    }// end deletePushNotification()
    // 

    /**
     * Function for delete multiple template
     *
     * @param null
     *
     * @return view page. 
     */
    public function performMultipleAction(){
        if(Request::ajax()){
            $actionType = ((Input::get('type'))) ? Input::get('type') : '';
            if(!empty($actionType) && !empty(Input::get('ids'))){
                if($actionType  ==  'delete'){
                    NotificationTemplate::whereIn('id', Input::get('ids'))->delete();
                    Session::flash('success', trans("messages.global.action_performed_message")); 
                }
            }
        }
    }//end performMultipleAction()
     
   
}