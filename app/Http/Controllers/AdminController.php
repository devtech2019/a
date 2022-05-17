<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserFranchise;
use App\Team;
use App\Washing_plan;
use App\Team_task;
use App\Appointment;
use App\Service;
use App\Blog;
use App\Transaction;
use App\Testimonial;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function index(){
    $id =  Auth::id();
   
      $users              =     User::orderBy('created_at', 'desc')->offset(0)->limit(8)->get();
      $u_count            =     User::count();
      //to find out franchise id 
      $teamId             =     Team::with('userFranchise')->where('user_id', Auth::user()->id)->pluck('id')->first();
      //to determine  appoinments of cleaners
      $cleanersId         =     User::with('userCleaners')->where('franchise_id', $teamId )->pluck('id');
      $bookingCleaners    =     Appointment::whereIn('cleaner_id',  $cleanersId  )->count();

      //$cleanersId       =     User::with('bookedCleaners')->where('id',  $id )->get();
      //to determine latest memebers count
      $franchise_cleaners =     User::with('userCleaners')->where('franchise_id',$teamId)
                                ->orderBy('created_at','desc')->offset(0)->limit(8)->get();
      //to determine cleaners count from user table
      $cleaners_count         = User::with('userCleaners')->where('franchise_id', $teamId )->pluck('name')->count();
     

      //To find out payment transaction from appointments 
      $franchiseCleanersList  = User::where('franchise_id', $teamId)->pluck('id')->toArray();
      $cleanerAppointment     = Appointment::whereIn('cleaner_id',$franchiseCleanersList)->pluck('id')->toArray();
      $payment_count          = Transaction::whereIn('appointment_id',$cleanerAppointment)->sum('amount');
      
      if($payment_count > 0){
        $payment_count    =   ceil($payment_count/100);
      }

      $teams = Team::count();
      $washing_plan = Washing_plan::count();
      $team_task = Team_task::count();
      $appointment = Appointment::count();
      $services = Service::count();
      $blogs = Blog::count();
      $testimonials = Testimonial::count();
      
      return view('admin.index', compact('users', 'u_count','teams','washing_plan','team_task','appointment','services','blogs','testimonials','cleaners_count','franchise_cleaners','bookingCleaners','cleanersId','payment_count'));
    }
}
