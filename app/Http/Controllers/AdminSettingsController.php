<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddOnCreateRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Settings;


class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $add_on_services = AddOn::all();
        return view('admin.add_on_services.index', compact('add_on_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.add_on_services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddOnCreateRequest $request)
    {
        //
        $input = $request->all();

        AddOn::create($input);
 
        Session::flash('delete_user', 'Coupon has been added');

        return redirect('admin/add_on_services')->with('added', 'AddOn added');
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
        
        $add_on_services = AddOn::findOrFail($id);
        return view('admin.add_on_services.edit', compact('add_on_services'));
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

  
       $add_on_services = AddOn::findOrFail($id);
        $input = $request->all();
        
        //  if (isset($_FILES['photo'])) {
        //     $file = $request->file('photo');
        //     $name = $file->getClientOriginalName();
        //     $file->move('images/teams', $name);

        //     if (file_exists(public_path($name =  $file->getClientOriginalName()))) 
        //     {
        //         unlink(public_path($name));
        //     };
        //     //Update Image
        //      $input['photo'] = $name;
        // }

       
        $add_on_services->update($input);


        return redirect('admin/add_on_services')->with('updated', 'Coupon Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

     // $team = Team::findOrFail($id);
     $file = AddOn::findOrFail($id); // File::find($id)



 //    $destinationPath = asset('public/images/teams/');



     $file->delete();
        

        // $team->delete();

        Session::flash('delete_user', 'add_on_services has been deleted');

        return redirect('admin/add_on_services')->with('deleted', 'add_on_services deleted');
    }
    
     
   
}
