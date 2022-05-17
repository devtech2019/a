<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Auth;
class AdminServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
         $services = Service::paginate(10);
        
        // $service = Service::paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
          'icon' => 'image|mimes:jpeg,png,jpg',
          'name' => 'required|max:120',
        ]);

        $input = $request->all();
        

        if ($file = $request->file('icon')) {

          $name = time() . $file->getClientOriginalName();

          $file->move('public/images/services', $name);

          $input['icon'] = $name;

        }

        Service::create($input);

        return back()->with('added', 'Service has been added');
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

        $request->validate([
          'icon' => 'image|mimes:jpeg,png,jpg',
          'name' => 'required|max:120',

        ]);

        $service = Service::findOrFail($id);

        $input = $request->all();

         if ($file = $request->file('icon')) {
            $name = $file->getClientOriginalName();
            $file->move(base_path('public/images/services'), $name);

            if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                unlink(public_path($name));
            };
            $input['icon'] = $name;

        }
        $service->update($input);

        return back()->with('updated', 'Service has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $service = Service::findOrFail($id);

        if ($service->icon) {

          unlink(public_path() . "/images/services/" . $service->icon);

        }

        $service->delete();

        return back()->with('deleted', 'Service has been deleted');
    }
}
