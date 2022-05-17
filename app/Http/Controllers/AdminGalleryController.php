<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();

        return view('admin.gallery.index', compact('galleries'));
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
          'gallery_img' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $input = $request->all();
     
        if ($file = $request->file('gallery_img')) {
          
            $name = time() . $file->getClientOriginalName();
            $file->move(base_path('public/images/gallery'), $name);
          
            $input['gallery_img'] = $name;
          
        }

        // $file = $request->file('gallery_img');

        // $name = time() . $file->getClientOriginalName();

        // $file->move('images/gallery', $name);

        // $input['gallery_img'] = $name;

        Gallery::create($input);
      
        return back()->with('added', 'Gallery has been added');
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
        
        $input = $request->all();
        $request->validate([
          'gallery_img' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $gallery = Gallery::findOrFail($id);

        if ($file = $request->file('gallery_img')) {
         
            $name = $file->getClientOriginalName();
         
            $file->move(base_path('public/images/gallery'), $name);

            if (file_exists(public_path($name = $file->getClientOriginalName()))) {
                unlink(public_path($name));
            };
            $input['gallery_img'] = $name;

        }


       

        $gallery->update($input);

        return back()->with('updated', 'Gallery has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        unlink(public_path() . "/images/gallery/" . $gallery->gallery_img);

        $gallery->delete();

        return back()->with('deleted', 'Gallery has been deleted');
    }
}
