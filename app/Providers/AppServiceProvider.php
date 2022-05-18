<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
     public function boot(Request $request)
     {

        $input  =   $request->all();


    //     $dataResponseObj                =   new \App\DataResponse;
    //     $dataResponseObj->main_req      =   json_encode($request['req']);
        
    //    $dataResponseObj->save();
      
        if(isset($input['api_from']) && !empty($input['api_from'])){
            $decordedData           =   json_decode(base64_decode($input['req']),true);
            $allData                =   isset($decordedData['data'])?$decordedData['data']:[];
            unset($request['debug']);
            unset($request['req']);
            $request->merge($allData);   
        }else if(isset($input['api_from_postman']) && !empty($input['api_from_postman'])){
            $decordedData   =   json_decode($input['req'],true);
            $allData        =   isset($decordedData['data'])?$decordedData['data']:[];
            $allData['api_from']    =   true;
            unset($request['debug']);
            unset($request['req']);
            $request->merge($allData);
            
        }

        $input  = $request->all();
       
       Schema::defaultStringLength(191);
     }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
