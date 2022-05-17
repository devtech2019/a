<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use DB;
class UserExport implements FromCollection, WithHeadings
{

    protected $id;

    function __construct($id=null,$email_id=null) {
           $this->id = $id;
           $this->email_id = $email_id;
           
        
    }
    // protected $data;
  
    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    //  */
    // public function __construct($data)
    // {
    //     $this->data = $data;
    // }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function collection()
    {

       $query = DB::raw("(CASE WHEN gender='M' THEN 'Male' WHEN gender='F' THEN 'Female' ELSE '' END) as gender");
       if(isset( $this->id )&& !empty( $this->id) || isset( $this->email_id) && !empty( $this->email_id)){
        return User::where('name', 'like', '%' . $this->id. '%')->where('email', 'like', '%' . $this->email_id. '%')->select('name', 'email','gender', 
        'dob' ,
        'mobile', 
        'address' ,
        'postal_code',$query )
        ->get();
       }else{
        return User::select('name', 'email','gender', 
        'dob' ,
        'mobile', 
        'address' ,
        'postal_code',$query )
        
        ->get();
       }
     
       
       
    }
  
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
       
    //     return User::all();
        
    // }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings() :array
    {
        return [
            
            'Name',
            'Email',
            'Gender', 
            'Dob' ,
            'Mobile', 
            'Address' ,
            'License no' ,
            'Postal code' 
        ];
    }
}
