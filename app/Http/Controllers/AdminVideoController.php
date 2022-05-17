<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\libraries\CustomHelper;
class AdminVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        $newArray = [];
        if ($request->isMethod('post')) {
            $configDataTable = CustomHelper::configDatatable($request);
            $start = $request->get("start") ? intval($request->get("start")) : 0;
            $rowperpage = $request->get("length") ? intval($request->get("length")) : 10;
            // Get records, also we have included search filter as well
            $columnIndex = $request->get('order')[0]['column'];
            $columnOrderType = $request->get('order')[0]['dir'];
            $columnName = $request->get('columns')[$columnIndex]['data'];
            $totalRecords = Video::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Video::select('count(*) as allcount')
                ->where($configDataTable['conditions'])
                ->count();
            $records = Video::orderBy('id', 'DESC')
                ->orderBy($columnName, $columnOrderType)
                ->where($configDataTable['conditions'])
                ->skip($start)
                ->take($rowperpage)
                ->get();
                if (count($records) > 0) {
                    foreach ($records as $key => $activity) {
                       
                        if (isset($activity['video_image']) && !empty($activity['video_image']) && file_exists(public_path('images/videos' . $activity['video_image']))) {
                            //$records[$key]['image']   =   '/public/images/teams/'.$activity['image'];
                            $records[$key]['video_image'] = url(URL::asset('public/images/videos/' . $activity['image']));
                        } else {
                            //  $records[$key]['image']    =   WEBSITE_URL.'/public/images/blank-profile.png';
                        }
                    }
                }
           
            $response = [
                "draw" => intval($request->get('draw')),
                "data" => $records,
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
            ];
            if ($response) {
                $response['sreq'] = 0;
                return json_encode($response);
            }
        } else {
            $adminListUrl = route('videos.show');
            return view('admin.videos.show', compact('adminListUrl'));
        }
      

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $this->validate($request, [
            'video_url'     => 'required|mimes:mp4,mov,ogg,qt|max:150000', // 10 Mb
            'title'         => 'required|max:150',
            'video_image'   => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $video                          =   new \App\Video;
        if($file = $request->file('video_url')) {
            $name       = time().'_video'.'.'.$file->getClientOriginalExtension();
            $file->move(base_path('public/images/videos'), $name);  
            $video->video_url = $name;  
        } 

        if($file_image = $request->file('video_image')) {
            $video_image_name = time().'_video_image'.'.'.$file_image->getClientOriginalExtension();
            $file_image->move(base_path('public/images/videos'), $video_image_name);
            $video->video_image = $video_image_name;  
        } 
        $video->title                   =   $request['title'];
        $video->save();

    return redirect('admin/videos')->with('added', 'Data Your files has been successfully added');

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
    public function edit($id)
    {
       
        $videos = Video::findOrFail($id);
        return view('admin.videos.edit', compact('videos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      
        $video = Video::findOrFail($id);
      

        $input = $request->all();
        $this->validate($request, [
            // 'video_url' => 'required|mimes:mp4,mov,ogg,qt',
            // 'title' => 'required',
            // 'video_image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            // 'video_url.*' => 'mimes:doc,pdf,docx,zip'
        ]);
        // if($file = $request->hasFile('video_url')) {
        //   
        //    
           
        //     $fileName = $file->getClientOriginalName();
          
        // }
    
        if ($file = $request->file('video_url')) {
           
            $name = time() . $file->getClientOriginalName();
            $userImg = time().'_user_'.$file->getClientOriginalName();   
            
            $file->move('public/images/videos', $name);   
           
            copy('public/images/videos/'.$name, 'public/images/users/'.$userImg);
            // $input['video_url'] = $name;  
            $video->vidoe_url = $name;  
                          
        } 
        if ($file_image = $request->file('video_image')) {
       
            $video_name = time() . '_video' . '.' . $file_image->getClientOriginalExtension();
            $file_image->move(base_path('public/images/videos'),  $video_name);
            if (file_exists(public_path( $video_name))) {
                unlink(public_path( $video_name));
            }
            $video->video_image =  $video_name;
            // $input['video_image'] =  $video_name;
            
            
        }
        $video->title = $request['title']; 
        // $input['title'] = $request['title']; 
        // dd($video); 
        // $video->update($input);
        $video->save();
        return redirect('admin/videos')->with('updated', 'Videos Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
      
        $file = Video::findOrFail($id); 
        $file->delete();
        return redirect('admin/videos')->with('deleted', 'Video deleted');
       
    }
}
