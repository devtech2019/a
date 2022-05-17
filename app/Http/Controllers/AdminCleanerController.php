<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\UserFranchise;
use App\Team;
use App\User;
use App\Social_team;
use File;

class AdminCleanerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (Auth::user()->role == 'A' || Auth::user()->role == 'S') {
            if(Auth::user()->role == 'A' ){
                $users = User::where('id', '!=', Auth::id())->get(); 
                return view('admin.cleaners.index', compact('users'));  
            }else{
                if ( Auth::user()->role == 'S'){
                    $user_id     = Auth::user()->id;
                    $id = Team::where('user_id',$user_id)->pluck('id')->first();
                    $users  = UserFranchise::with('userCleaners')->where('franchise_id',$id)->get()->toArray();
                    return view('admin.cleaners.index',compact('users','id'));  
                }
            }
        }
        if (Auth::user()->role == 'C') {
           return redirect('/admin');
        }
        if (Auth::user()->role == 'U') {
           return redirect('/admin');
        }
        return view('admin.cleaners.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $franchiseList = Team::all()->pluck('name','id')->toArray();
        if (Auth::user()->role == 'A'|| Auth::user()->role == 'S') {
            return view('admin.cleaners.create',compact('franchiseList'));
        }

     //  if (Auth::user()->role == 'S') {
     //    $user_id     = Auth::user()->id;
     //    $id = Team::where('user_id',$user_id)->pluck('id')->first();
     //    $franchiseList = Team::where('id',$id)->pluck('name','id')->first();

     //    return view('admin.cleaners.create',compact('franchiseList','id'));
     // }


      if (Auth::user()->role == 'C') {

        return redirect('admin.cleaners.index');
     }


    if (Auth::user()->role == 'U') {
        return redirect('/admin');
      }
      return view('admin.cleaners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersCreateRequest $request){
        $input = $request->all();
        if ($file = $request->file('photo')) {
          $name = time() . $file->getClientOriginalName();
          $file->move('public/images/users', $name);
          $input['photo'] = $name;
        }

        $input['password'] = bcrypt($request->password);
        $input['dob'] = date("Y/m/d", strtotime($request->dob));

        if(Auth::user()->role  ==  "S"){
            $input['role']          = "C";
            $input['franchise_id']  = Auth::user()->id;
        }
        pr( $input); die;
        //unset($input["_token"]);
        $userId   =   User::create($input)->id;
        if ($input['role'] == 'C') {
            $obj                     = new UserFranchise;
            $obj->user_id            =  $userId;
            $obj->franchise_id       =  $input['franchise_id'];
            $obj->save();
         }
        Session::flash('add_user', 'User has been added');
        return redirect('admin/cleaners')->with('added', 'Team Member added');
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
        //
       $user = User::findOrFail($id);
      
         
      
         $franchiseList = Team::all()->pluck('name','id')->toArray();
        return view('admin.cleaners.edit', compact('user','franchiseList'));
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


        $user = User::findOrFail($id);


        if ($request->password == '') {

          $input = $request->except('password');

        }
        else {
          $input = $request->all();
        }

         if ($file = $request->file('photo')) {


         $name = $file->getClientOriginalName();

       
           $file->move('images/users', $name);

            if (file_exists(public_path($name =  $file->getClientOriginalName()))) 
           {
               unlink(public_path($name));
            };
           $input['photo'] = $name;

        }




        //   if (isset($_FILES['photo'])) {
        //     $file = $request->file('photo');
        //     $name = $file->getClientOriginalName();
        //     $file->move('images/users', $name);

        //     if (file_exists(public_path($name =  $file->getClientOriginalName()))) 
        //     {
        //         unlink(public_path($name));
        //     };
        //     //Update Image
        //      $input['photo'] = $name;
        // }

        if (!$request->password == '') {

          $input['password'] = bcrypt($request->password);

        }
        $input['dob'] = date("Y/m/d", strtotime($request->dob));

        $user->update($input);


         return redirect('admin/cleaners')->with('updated', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $user_franchise = UserFranchise::where('user_id',$id);
   
     $user_franchise->delete();
        $user = User::findOrFail($id);
        $user->delete();
        Session::flash('delete_user', 'User has been deleted');
        return redirect('admin/cleaners')->with('deleted', 'User has been deleted');
      
        // if ($user->photo) {

        //   $path = public_path()."\images\users" .$user->photo;
        //   unlink($path);
         

        // }   

    }
}
