@extends('layouts.admin')
@section('sidebar_active')
@include('include.sidebar_links', [
'users' => 'active', 'all_user' => 'active', 'create_user' => '',
'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
'plan' => '', 'all_plan' => '', 'plan_price' => '',
'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '',
'opening_hours' => '', 'company_social' => '',
'profile' => '', 'sub_appointment' => '',
])
@endsection
@section('breadcum')
@include('include.breadcum', [
'title' => 'All Appointment Details',
'from' => 'Admin',
'to' => 'All Appointment Details',
])
@endsection
@section('content')
<div class="invoice-box">
   <table cellpadding="0" cellspacing="0">
      @if(isset($appointmentDetail)&& !empty($appointmentDetail))
     
         <tr class="top">
            <td colspan="4">
               <table width="100%">
                  <tr>
                     <td>
                        <table width="100%" cellpadding="10">
                           <tr>
                              <td valign="top"><img src="{{asset('public/images/logo.svg')}}" /></td>
                              <td width="50%">
                                 <p style="margin:0;">Appointment Date: {{$appointmentDetail['appointment_details']['appointment_date'] ?? ''}}
                                 </p>
                                 <p style="margin: 0;"> Created at: {{$appointmentDetail['appointment_details']['created_at'] ?? ''}}</p>
                              </td>
                           </tr>
                           <tr  >
                              <td width="50%">
                                 <p style="margin: 0;">User Name: {{$appointmentDetail['appointment_details']['user']['name'] ?? ''}}</p>
                                 <p style="margin: 0;">Email: {{$appointmentDetail['appointment_details']['user']['email'] ?? ''}}</p>
                                 <p style="margin: 0;">Address: {{$appointmentDetail['appointment_details']['user']['address'] ??''}}</p>
                              </td>
                              <td>
                                 <p style="margin: 0;">Cleaner Name: {{$appointmentDetail['appointment_details']['cleaner']['name'] ??''}}
                                 </p>
                                 <p style="margin: 0;">Email: {{$appointmentDetail['appointment_details']['cleaner']['email'] ??''}}</p>
                                 <p style="margin: 0;">Address : {{$appointmentDetail['appointment_details']['cleaner']['address'] ?? ''}}</p>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  
                  <tr class="top">
                     <td colspan="4">
                        <table class="table" width="80%" cellpadding="8" cellspacing="0"  >
                           <thead>
                              <tr bgcolor="#eeeeee">
                                 <th width="50%" scope="col" style="text-align:left">Type</th>
                                 <th scope="col" style="text-align:right">Value</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <tr>
                                 <td width="50%">Vehicle Registration no</td>
                                 <td width="50%">
                                    {{$appointmentDetail['appointment_details']['user_vehicle']['vehicle_registration_no'] ??''}}
                                 </td>
                              </tr>
                              <tr>
                                 <td >Vehicle Colour</td>
                                 <td>{{$appointmentDetail['appointment_details']['user_vehicle']['color'] ?? ""}}</td>
                              </tr>
                              <tr>
                                 <td>Vehicle Type</td>
                                 <td>{{$appointmentDetail['appointment_details']['washing_price']['vehicle_type']['type']??''}}</td>
                              </tr>
                              <tr>
                                 <td>Washing Plan Name</td>
                                 <td>{{$appointmentDetail['appointment_details']['washing_price']['washing_plan']['name']??''}}</td>
                              </tr>
                              <tr>
                                 <td>Base Price</td>
                                 <td>{{"Rs."}} {{ceil($appointmentDetail['appointment_details']['base_amount'])??''}}</td>
                              </tr>
                              
                              <tr>
                                 <td>Washing Duration</td>
                                 <td>{{$appointmentDetail['appointment_details']['washing_price']['duration']??''}} MIN</td>
                              </tr>
                              <tr>
                                 <td>GST</td>
                                 <td>{{$appointmentDetail['appointment_details']['gst']??''}} %</td>
                              </tr>
                              <tr>
                                 <td>Total Price</td>
                                 <td>{{"Rs."}} {{ceil($appointmentDetail['appointment_details']['amount'])??''}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         
         
      @else 
         No Record Found
      @endif
     
   </table>
</div>
<div class="invoice-download">
   <a href="{{route('users.exportInvoicePDF',$appointmentDetail['id'])}}" class="btn btn-primary">Export To Pdf</a>
</div>
<style>
   .invoice-box table {
   width: 100%;
   line-height: inherit;
   text-align: left;
   }
   .invoice-box table td {
   padding: 5px;
   vertical-align: top;
   }
   .invoice-box table tr td:nth-child(2) {
   text-align: right;
   }
   .crud-content table img {
   border-radius: 0;
   }

   .invoice-download {
    margin: 0px 16px;
    display: flex;
    padding-bottom: 25px;
    text-align: right;
    align-items: flex-end;
    justify-content: flex-end;
}
</style>
@endsection