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
                     <table class="table" width="80%" cellpadding="8" cellspacing="0" >
                           <thead>
                              <tr bgcolor="#eeeeee">
                                 <th width="50%" scope="col" style="text-align:left">Type</th>
                                 <th scope="col" style="text-align:right">Value</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td width="50%" class="border_apply">Payment ID </td>
                                 <td width="50%" class="border_apply">
                                    {{$appointmentDetail['payment_id'] ??''}}
                                 </td>
                              </tr>
                              <tr >
                                 <td width="50%" class="border_apply">Vehicle Registration no</td>
                                 <td width="50%" class="border_apply">
                                    {{$appointmentDetail['appointment_details']['user_vehicle']['vehicle_registration_no'] ??''}}
                                 </td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Vehicle Colour</td>
                                 <td class="border_apply">{{$appointmentDetail['appointment_details']['user_vehicle']['color']}}</td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Vehicle Type</td>
                                 <td class="border_apply">{{$appointmentDetail['appointment_details']['washing_price']['vehicle_type']['type']??''}}</td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Washing Plan Name</td>
                                 <td class="border_apply">{{$appointmentDetail['appointment_details']['washing_price']['washing_plan']['name']??''}}</td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Base price</td>
                                 <td class="border_apply">{{"Rs."}} {{ceil($appointmentDetail['appointment_details']['base_amount'])??''}}</td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Washing Duration</td>
                                 <td class="border_apply">{{$appointmentDetail['appointment_details']['washing_price']['duration']??''}} MIN</td>
                              </tr>

                              <tr>
                                 <td class="border_apply">GST</td>
                                 <td class="border_apply">{{$appointmentDetail['appointment_details']['gst']??''}} %</td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Total Price</td>
                                 <td class="border_apply">{{"Rs."}} {{ceil($appointmentDetail['appointment_details']['amount'])??''}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>

                  @if(isset($appointmentDetail['appointment_details']['coupon_details']) && !empty($appointmentDetail['appointment_details']['coupon_details']) && count($appointmentDetail['appointment_details']['coupon_details']) >= 1)
                  <tr class="top">
                     <td colspan="4">
                     <table class="table" width="80%" cellpadding="8" cellspacing="0" >
                           <thead>
                              <tr bgcolor="#eeeeee">
                                 <th width="50%" scope="col" style="text-align:left">Type</th>
                                 <th scope="col" style="text-align:right">Value</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              <tr >
                                 <td width="50%" class="border_apply">Applied Coupon</td>
                                 <td width="50%" class="border_apply">
                                 {{$appointmentDetail['appointment_details']['coupon_details']['coupon_code'] ??''}}
                                 </td>
                              </tr>
                              <tr>
                                 <td class="border_apply">Coupon Value Type</td>
                                 <td class="border_apply"> {{$appointmentDetail['appointment_details']['coupon_details']['value'] ??''}}{{$appointmentDetail['appointment_details']['coupon_details']['value_type']??''}}</td>
                              </tr>       
                     </table>
                     </td>
                  </tr>
               @endif
                  <tr>
                     <td>
                        @if(isset($appointmentDetail['appointment_details']['coupon_id']) && !empty($appointmentDetail['appointment_details']['coupon_id']))
                           <p >Gross Amount: {{ceil($appointmentDetail['appointment_details']['gross_amount']) ??''}}</p>
                        @endif
                        <p>Amount :  {{ceil($appointmentDetail['appointment_details']['amount'])??''}}</p>
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
   .border_apply{
      border:1px solid black;
   }
</style>
