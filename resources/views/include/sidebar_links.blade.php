@if (Auth::user()->role == 'A')

  <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>Dashboard</span></li>

  <li class="treeview {{$users}}">

    <i class="fa fa-user"></i> <span>Users</span>

    <span class="pull-right-container">

      <i class="fa fa-angle-left pull-right"></i>

    </span>

    <ul class="treeview-menu">

      <li class="{{$all_user}}"><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i>All Users</a></li>

      <li class="{{$create_user}}"><a href="{{route('users.create')}}"><i class="fa fa-circle-o"></i>Create User</a></li>

    </ul>

  </li>



  <li class="treeview {{$teams}}">

    <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>Franchise</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li class="{{$all_team}}"><a href="{{route('team.index')}}"><i class="fa fa-circle-o"></i>All Franchise</a></li>

      <li class="{{$create_team}}"><a href="{{route('team.create')}}"><i class="fa fa-circle-o"></i>Create Franchise</a></li>

      <!-- <li class="{{$team_task}}"><a href="{{route('team_task.index')}}"><i class="fa fa-circle-o"></i>Franchise Task</a></li> -->

    </ul>

  </li>



<li class="treeview {{$banners ?? ''}}">

    <a href="#"><i class="fa fa-image" aria-hidden="true"></i> <span>Banners</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$all_banners ?? ''}}"><a href="{{route('banners.index')}}"><i class="fa fa-circle-o"></i>All Banners</a></li>



       <li  class="{{$all_create_banners ??''}}"><a href="{{route('banners.create')}}"><i class="fa fa-circle-o"></i>Create Banners</a></li>

    </ul>

  </li>





 

 <li class="treeview">

    <a href="#"><i class="fa fa-envelope-square" aria-hidden="true"></i> <span>Coupon Management</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li class="{{$all_coupon ?? ''}}"><a href="{{route('coupons.index')}}"><i class="fa fa-circle-o"></i>All Coupons</a></li>

      <li class="{{$create_coupon ?? ''}}"><a href="{{route('coupons.create')}}"><i class="fa fa-circle-o"></i>Create Coupons</a></li>



    </ul>

  </li>

  <li class="treeview {{$emailManagement ?? ''}}">

  <a href="#"> <i class="fa fa-user"></i> <span>Email Management</span>

    <span class="pull-right-container">

      <i class="fa fa-angle-left pull-right"></i>

    </span>

    </a>

    <ul class="treeview-menu {{$emailtemplate ?? ''}} ">

    <li class="{{$emaillogs ?? ''}}">

    <a href="{{route('EmailLogs.index')}}">

      <i class="fa fa-comments" aria-hidden="true"></i>

      <span>Email-Logs</span>

    </a>

  </li>

</li>

    <li class="treeview {{$emailtemplate ?? ''}} ">

    <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Email-Templates</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>



    <ul class="treeview-menu">

      <li  class="{{$all_email_template ?? ''}}"><a href="{{route('EmailTemplate.index')}}"><i class="fa fa-circle-o"></i>All Email-Templates</a></li>



       <li  class="{{$all_create_email_template ?? ''}}"><a href="{{route('EmailTemplate.add')}}"><i class="fa fa-circle-o"></i>Create Email-Templates</a></li>

    </ul>

</li>

</ul>

</li>

<li class="treeview {{$notification ?? ''}}">

<a href="#"><i class="fa fa-envelope notifications" aria-hidden="true"></i> <span>Notifications Templates</span>



<span class="pull-right-container">

    <i class="fa fa-angle-left pull-right"></i>

  </span>

</a>

<ul class="treeview-menu">

  <li class="{{$all_notification ?? ''}}"><a href="{{route('PushNotification.index')}}"><i class="fa fa-circle-o"></i>All notifications templates</a></li>

</ul>


 <li class="treeview {{$cms ?? ''}}">

 <a href="#"> <i class="fa fa-user"></i> <span>Content Management</span>

    <span class="pull-right-container">

      <i class="fa fa-angle-left pull-right"></i>

    </span>

    </a>

    <ul class="treeview-menu {{$emailtemplate ?? ''}} ">

 <li class="treeview {{$settings}}">

    <a href="#"><i class="fa fa-gear"></i> <span>Home Sections</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li class="{{$services}}"><a href="{{route('services.index')}}"><i class="fa fa-circle-o"></i>Services</a></li>

      <li class="{{$testimonial}}"><a href="{{route('testimonial.index')}}"><i class="fa fa-circle-o"></i>Testimonial</a></li>

      <li class="{{$company_social}}"><a href="{{route('company_social.index')}}"><i class="fa fa-circle-o"></i>Company Social</a></li>
      <li class="{{$gallery}}"><a href="{{route('gallery.index')}}"><i class="fa fa-circle-o"></i>Gallery</a></li>

      <li class="treeview {{$blog ?? ''}}">
               <a href="#"><i class="fa fa-envelope notifications" aria-hidden="true"></i> <span>Videos</span>
               <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
               </span>
               </a>
               <ul class="treeview-menu">
               <li class="{{$blog ??'' }}"><a href="{{route('videos.show')}}"><i class="fa fa-circle-o"></i>All Videos</a></li>
               <li class="{{$blog ?? ''}}"><a href="{{route('videos.index')}}"><i class="fa fa-circle-o"></i>Create Videos</a></li>
                
               </ul>
            </li>
      <li><a href="{{route('contact.index')}}"><i class="fa fa-circle-o"></i>Contact</a></li>




     <!--  <li class="{{$facts}}"><a href="{{route('facts.index')}}"><i class="fa fa-circle-o"></i>Facts</a></li>

      li class="{{$blog}}"><a href="{{route('blog.index')}}"><i class="fa fa-circle-o"></i>Blog</a></li>

      <li class="{{$clients}}"><a href="{{route('clients.index')}}"><i class="fa fa-circle-o"></i>Clients</a></li> -->

      <li class="{{$opening_hours}}"><a href="{{route('opening_hours.index')}}"><i class="fa fa-circle-o"></i>Opening Hours</a></li> 

     

    </ul>

  </li>

  <li class="treeview {{$blocks ??''}}">

    <a href="#"><i class="fa fa-image" aria-hidden="true"></i> <span>Block Management</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

      </a>

      <ul class="treeview-menu {{$blocks ??''}}">

      <li  class="{{$blocks ??''}}"><a href="{{route('pages.index')}}"><i class="fa fa-circle-o"></i>All Blocks</a></li>



       <li  class="{{$blocks ??'' }}"><a href="{{route('pages.create')}}"><i class="fa fa-circle-o"></i>Create Blocks</a></li>

    </ul>

  </li>



  <li class="treeview {{$faq ?? ''}}">

    <a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> <span>FAQs</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li class="{{$all_faq ?? ''}}"><a href="{{route('faqs.index')}}"><i class="fa fa-question"></i>Faq Questions</a></li>

      <li class="{{$all_faq_cat ?? ''}}"><a href="{{route('faqs_categories.index')}}"><i class="fa fa-cubes"></i>Categories</a></li>

      <li class="{{$all_faq_cat_create ?? ''}}"><a href="{{route('faqs_categories.create')}}"><i class="fa fa-plus-circle"></i>Create Categories</a></li>



    </ul>

  </li>

</ul>

</li>





  <li class="{{$franchiselist ?? ''}}">

    <a href="{{route('franchiselist.index')}}">

      <i class="fa fa-comments" aria-hidden="true"></i>

      <span>Franchise Request List</span>

    </a>

  </li>



  <li class="{{$contactUslist ?? ''}}">

    <a href="{{route('contactUsList.index')}}">   

      <i class="fa fa-phone-square" aria-hidden="true"></i>

      <span>Contact Us List</span>

    </a>

  </li>



  <li class="treeview {{$plan}}">

    <a href="#"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Washing Plan</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu {{$all_plan ??''}}">

      <li class="{{$all_plan}}"><a href="{{route('washing_plan.index')}}"><i class="fa fa-circle-o"></i>Washing Plan</a></li>

      <li class="{{$plan_price}}"><a href="{{route('washing_price.index')}}"><i class="fa fa-circle-o"></i>Washing Plan Price</a></li>

       <li class="{{$add_on_services ?? ''}}"><a href="{{route('add_on_services.index')}}"><i class="fa fa-circle-o"></i>Add On Services</a></li>

        <li class="{{$create_add_on_services ?? ''}}"><a href="{{route('add_on_services.create')}}"><i class="fa fa-circle-o"></i>Add On Services Create</a></li>

    </ul>

  </li>

  <li class="treeview {{$vehicle}}">

    <a href="#"><i class="fa fa-car"></i> <span>Vehicle</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li class="{{$vehicle_company}}"><a href="{{route('vehicle_company.index')}}"><i class="fa fa-circle-o"></i>Vehicle Company</a></li>

      <li class="{{$vehicle_modal}}"><a href="{{route('vehicle_modal.index')}}"><i class="fa fa-circle-o"></i>Vehicle Model</a></li>

      <li class="{{$vehicle_type}}"><a href="{{route('vehicle_type.index')}}"><i class="fa fa-circle-o"></i>Vehicle Type</a></li>



    </ul>

  </li>

  <li class="treeview {{$payment}}">

    <a href="#"><i class="fa fa-envelope" ></i> <span>Payment Transaction</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$payment_mode}}"><a href="{{route('users.cleanersBookings')}}"><i class="fa fa-circle-o"></i>Payment Transaction</a></li>

    </ul>

  </li> 



  <li class="treeview {{$panalty ??''}}">
  <a href="#"><i class="fa fa-envelope" ></i><span>Manage Penalty charges</span>
  <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
    <!-- <a href="{{route('penalty.edit')}}">

      <i class="fa fa-circle-o" ></i> -->

    
      <ul class="treeview-menu">

<li  class="{{$panalty ?? ''}}"><a href="{{route('penalty.edit')}}"><i class="fa fa-circle-o"></i>Manage Penalty charges</a></li>
<li  class="{{$panalty ?? ''}}"><a href="{{route('penalty.index')}}"><i class="fa fa-circle-o"></i>CancellationChargesAmount</a></li>

</ul>
  
    <!-- <ul class="treeview-menu">

<li  class="{{$panalty ?? ''}}"><a href="{{route('users.freanchies.all')}}"><i class="fa fa-circle-o"></i>CancellationChargesAmount</a></li>

</ul> -->

  </li>



    <ul class="treeview-menu">

      <li  class="{{$cms ?? ''}}"><a href="{{route('cms.index')}}"><i class="fa fa-circle-o"></i>All Pages</a></li>



      <li  class="{{$create_cms ?? ''}}"><a href="{{route('cms.create')}}"><i class="fa fa-circle-o"></i>Create Pages</a></li>

    </ul>

  </li>



  <li class="treeview {{$appointments}}">

    <a href="#"><i class="fa fa-envelope" ></i> <span>Appointments</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$appointment}}"><a href="{{route('users.freanchies.all')}}"><i class="fa fa-circle-o"></i>All Appointments</a></li>

    </ul>

  </li> 

  <li class="treeview {{$facts??''}}">

    <a href="#"><i class="fa fa-envelope" ></i> <span>Cleaners Daily Ride</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$facts ??''}}"><a href="{{route('cleaners_daily_ride.index')}}"><i class="fa fa-circle-o"></i>All Cleaners Daily Ride</a></li>
      <li class="{{$facts ??''}}"><a href="{{route('vehicle.index')}}"><i class="fa fa-circle-o"></i>Vehicle Coordinate Data</a></li>

    </ul>

  </li> 



  <!-- <li class="treeview {{$appointments}}">

<a href="#"><i class="fa fa-envelope" ></i> <span>CancellationChargesAmount</span>

  <span class="pull-right-container">

    <i class="fa fa-angle-left pull-right"></i>

  </span>

</a>

<ul class="treeview-menu">

  <li  class="{{$appointment}}"><a href="{{route('users.freanchies.all')}}"><i class="fa fa-circle-o"></i>All CancellationChargesAmount</a></li>

</ul>

</li>  -->




  <!-- <li class="treeview {{$appointments}}">

    <a href="#"><i class="fa fa-calendar"></i> <span>Appointment</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a><li class="treeview {{$emailtemplate ?? ''}}">

    <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Email-Templates</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$all_email_template ?? ''}}"><a href="{{route('EmailTemplate.index')}}"><i class="fa fa-circle-o"></i>All Email-Templates</a></li>



       <li  class="{{$all_create_email_template ?? ''}}"><a href="{{route('EmailTemplate.add')}}"><i class="fa fa-circle-o"></i>Create Email-Templates</a></li>

    </ul>

  </li>

    <ul class="treeview-menu">

      <li class="{{$appointment}}"><a href="{{route('appointment.index')}}"><i class="fa fa-circle-o"></i>Appointment</a></li>

      <li class="{{$payment}}"><a href="{{route('payment.index')}}"><i class="fa fa-circle-o"></i>Payment</a></li>

      <li class="{{$payment_mode}}"><a href="{{route('payment_mode.index')}}"><i class="fa fa-circle-o"></i>Payment Mode</a></li>

      <li class="{{$status}}"><a href="{{route('status.index')}}"><i class="fa fa-circle-o"></i>Status</a></li>

    </ul>

  </li>  -->

 



@endif

@if (Auth::user()->role == 'S')

  <li class="{{$profile}}"><a href="{{url('/admin')}}"><i class="fa fa-id-badge" aria-hidden="true"></i> <span>Dashboard</span></li>



  <li class="treeview {{$users}}">

    <i class="fa fa-user"></i> <span>Cleaners</span>

    <span class="pull-right-container">

      <i class="fa fa-angle-left pull-right"></i>

    </span>

    <ul class="treeview-menu">

      <li class="{{$all_user}}"><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i>All Cleaners</a></li>

      <li class="{{$create_user}}"><a href="{{route('users.create')}}"><i class="fa fa-circle-o"></i>Create Cleaners</a></li>

    </ul>

  </li>

 

  <li class="treeview {{$appointments}}">

    <a href="#"><i class="fa fa-envelope" ></i> <span>Appointments</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$appointment}}"><a href="{{route('users.freanchies.all')}}"><i class="fa fa-circle-o"></i>All Appointments</a></li>

    </ul>

  </li> 

  <li class="treeview {{$payment}}">

    <a href="#"><i class="fa fa-envelope" ></i> <span>Payment Transaction</span>

      <span class="pull-right-container">

        <i class="fa fa-angle-left pull-right"></i>

      </span>

    </a>

    <ul class="treeview-menu">

      <li  class="{{$payment_mode}}"><a href="{{route('users.cleanersBookings')}}"><i class="fa fa-circle-o"></i>Payment Transaction</a></li>

    </ul>

  </li> 
  <li class="treeview {{$panalty ??''}}">
   <a href="#"><i class="fa fa-envelope" ></i> <span>Cancellation Penalty</span>
   <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
   </span>
   </a>
   <ul class="treeview-menu">
      <li class="{{$panalty ?? ''}}"><a href="{{route('penalty.index')}}"><i class="fa fa-circle-o"></i>CancellationChargesAmount</a></li>
   </ul>
</li>
<li class="treeview {{$status}}">
   <a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>Accounting Services</span>
   <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
   </span>
   </a>
   <ul class="treeview-menu">
      <li class="{{$status}}"><a href="{{route('accounting_services.index')}}"><i class="fa fa-circle-o"></i>All Accounts</a></li>
      <li class="{{$status}}"><a href="{{route('accounting_services.create')}}"><i class="fa fa-circle-o"></i>Create Accounts</a></li>
   
   </ul>
</li>



@endif



