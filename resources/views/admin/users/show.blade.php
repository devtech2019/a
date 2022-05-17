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
                        <?php 
                           $variable= CustomHelper::price_symbol();
                           
                           
                           ?>
                        <tr>
                           <td valign="top"><img src="{{asset('public/images/logo.svg')}}" /></td>
                           <td width="50%">
                              <p style="margin: 0;">Appointment Date:
                                 {{$appointmentDetail['appointment_date'] ?? ''}}
                              </p>
                              <p style="margin: 0;"> Created at: {{$appointmentDetail['created_at'] ?? ''}}</p>
                           </td>
                        </tr>
                        <tr  >
                           <td width="50%">
                              <p style="margin: 0;">User Name: {{$appointmentDetail['user']['name'] ?? ''}}</p>
                              <p style="margin: 0;">Email : {{$appointmentDetail['user']['email'] ?? ''}}</p>
                              <p style="margin: 0;"> Address : {{$appointmentDetail['user']['address'] ??''}}</p>
                           </td>
                           <td>
                              <p style="margin: 0;">Cleaner Name: {{$appointmentDetail['cleaner']['name'] ??''}}
                              </p>
                              <p style="margin: 0;"> Email :{{$appointmentDetail['cleaner']['email'] ??''}}</p>
                              <p style="margin: 0;">Address : {{$appointmentDetail['cleaner']['address'] ?? ''}}</p>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr class="top">
                  <td colspan="4">
                     <table class="table" width="80%" cellpadding="8" cellspacing="0">
                        <thead>
                           <tr>
                              <th width="50%" scope="col">Type</th>
                              <th scope="col" style="text-align:right">Value</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td width="50%">Vehicle Registration no</td>
                              <td width="50%">
                                 {{$appointmentDetail['user_vehicle']['vehicle_registration_no'] ??''}}
                              </td>
                           </tr>
                           <tr>
                              <td>Vehicle Colour</td>
                              <td>{{$appointmentDetail['user_vehicle']['color']}}</td>
                           </tr>
                           <tr>
                              <td>Vehicle Type</td>
                              <td>{{$appointmentDetail['user_vehicle']['vehicle_type']['vehicle_company']??''}}</td>
                           </tr>
                           <tr>
                              <td>Washing Plan Name</td>
                              <td>{{$appointmentDetail['washing_price']['washing_plan']['name']??''}}</td>
                           </tr>
                           <tr>
                              <td>Washing price</td>
                              <td>{{$appointmentDetail['washing_price']['price']??''}}</td>
                           </tr>
                           <tr>
                              <td>Washing Duration</td>
                              <td>{{$appointmentDetail['washing_price']['duration']??''}}</td>
                           </tr>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </table>
         </td>
      </tr>
      @if(isset($appointmentDetail['appointment_addons']) && !empty($appointmentDetail['appointment_addons']))
      <tr>
         <td>
            <table width="100%" cellpadding="10" cellspacing="0">
               <tr bgcolor="#eeeeee">
                  <td width="33%"><strong>AddOn Name</strong></td>
                  <td width="33%" style="text-align:center"><strong>Description</strong></td>
                  <td width="33%" style="text-align:right"><strong>Price</strong></td>
               </tr>
               @php $total = 0; @endphp
               @if(isset($appointmentDetail['appointment_addons']) && !empty($appointmentDetail['appointment_addons']) && count($appointmentDetail['appointment_addons']) >= 1)
               @foreach($appointmentDetail['appointment_addons'] as $appoinment_users)
               <tr>
                  <td>{{$appoinment_users['appointment_addon']['name'] ??''}}</td>
                  <td style="text-align:center">{{$appoinment_users['appointment_addon']['description'] ??''}}</td>
                  <td style="text-align:right">{{$variable}}{{ $appoinment_users['appointment_addon']['price']??'' }}</td>
                  @php
                  $total += $appoinment_users['appointment_addon']['price']
                  @endphp
               </tr>
               @endforeach
               @else
               <tr>
                  <td>-</td>
                  <td style="text-align:center">-</td>
                  <td style="text-align:right">-</td>
               </tr>
               @endif
            </table>
         </td>
      </tr>
      <tr>
         <td>
            <table width="100%" cellpadding="10">
               <tr>
                  <td>&nbsp;</td>
                  <td width="50%" valign="right"><b>Total :{{$variable}}{{$total}}</b></td>
               </tr>
            </table>
         </td>
      </tr>
      @endif
      <tr>
         <td>
            <table width="100%" cellpadding="10" cellspacing="0">
               <tr bgcolor="#eeeeee">
                  <td width="33%"><strong>Payment Transaction Details</strong></td>
                  <td width="33%" style="text-align:center"><strong>Type</strong></td>
                  <td width="33%" style="text-align:right"><strong>Amount</strong></td>
               </tr>
               <div style="display: none">
                  {{$total = 0 }}
               </div>
               @foreach($appointmentDetail['appointment_transaction'] as $appoinment_transaction)
               <tr>
                  <td>{{$appoinment_transaction['payment_id']}}</td>
                  @if($appoinment_transaction['type'] =='for_appointment')
                  <td style="text-align:center">For Appointment</td>
                  @else
                  <td style="text-align:center">For AddOn</td>
                  @endif
                  <td style="text-align:right">{{$appoinment_transaction['amount']}}</td>
                  @php
                  $total += $appoinment_transaction['amount']
                  @endphp
               </tr>
               @endforeach
            </table>
         </td>
      </tr>
      <tr>
         <td>
            <table width="100%" cellpadding="10">
               <tr>
                  <td>&nbsp;</td>
                  <td width="50%" valign="right"><b>Total :{{$variable}}{{$total}}</b></td>
               </tr>
            </table>
         </td>
      </tr>
      @else No Record Found
      @endif
     
   </table>
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
</style>
@endsection