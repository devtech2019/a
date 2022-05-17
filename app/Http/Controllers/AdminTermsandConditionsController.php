<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\libraries\CustomHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\TermsandCondition;


class AdminTermsandConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      die("efg");
      $testimonials_heading = Page::all();
      pr($testimonials_heading);
      return view('terms&conditions',compact('TermsandCondition',compacts('testimonials_heading')));     
    }       
}
