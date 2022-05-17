@extends('layouts.theme')
@section('inner_content')
<div class="wraper-inner space-head">
   <div id="app">
      @include('flash-message')
   </div>
   <!--slider_section-->
   <section class="sliderSection">
      <div id="owl-demo" class="owl-carousel slider-owl owl-theme">
         @foreach($banners as $banner)
         <div class="item">
            <figure> 
              <a href="{{$banner->action_url}}" target="_blank">
                <img src="{{asset('public/images/teams')}}/{{$banner->image}}" /> 
            	<div class="banner-caption-main">
                   <div class="banner-caption">
                      <h1>{{$banner->name}}</h1>
                      <p>{{$banner->description}}</p>
                      <a class="common-btn orange-btn hvr-sweep-to-right"
                         href="javascript:void(0)">{{$banner->button_name}}</a>
                   </div>
            	</div>
              </a>
           	</figure>
         </div>
         @endforeach
      </div>
   </section>
</div>
<section id="about-us" class="scroll_animate">
   <!--   //sectionA -->
   {!! $testimonials_heading[0]['body'] ?? '' !!}
</section>
<section class="service-package target scroll_animate" id="services">
   <div class="container">
   <div class="row">
      <div class="col-md-12 comm-head-title text-center">
         <h2 class="common-title">Service Package</h2>
         <p> {{$service_package_data }}
         </p>
      </div>
   </div>
   <div class="row tabs-sevices">
   <div class="col-md-12">
      <ul class="tabs">
         @foreach ($vehicle_types as $key => $vehicle_type)
         <li rel="tab{{$key}}" role="presentation" @if ($key==0) class="active" @endif> {{$vehicle_type->type}}
         </li>
         @endforeach
      </ul>
      <div class="tab_container">
         @foreach ($vehicle_types as $key=>$value)
         <div id="tab{{$key}}" class="tab_content">
            <div class="service-package-box " >
              

               <ul class="service-package-box-list">
                  @foreach ($value['washing_price_data'] as $washing_price)
                  <li>
                     <div class="service-package-list-head">
                        <span class="common-btn">{{$washing_price['washing_plan']['name'] ?? "-"}}</span>
                     </div>
                     <div class="service-package-list-middle">
                        <price>₹{{$washing_price['price']}}</price>
                        <span>{{$washing_price->duration}} MIN</span>
                     </div>
                     <div class="service-package-list-body">
                        <ul class="service-package-list-body-content">
                           @foreach ($washing_includes as $washing_include)
                           @if ($washing_include->washing_plan_id == $washing_price->washing_plan_id)
                           <li>{{$washing_include->washing_plan_include}}</li>
                           @endif
                           @endforeach
                        </ul>
                     </div>
                     <!-- <div class="service-package-list-footer">
                        <a class="common-btn trans-btn hvr-sweep-to-right">Select Package</a>
                        </div> -->
                  </li>
                  @endforeach
               </ul>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>
<section class="video-main-box">
   <div class="container">
      <div class="row">
            <div class="col-md-12 comm-head-title text-center">
                <p>{{$video_section_data}}
                </p>
            </div>
            <div class="col-md-12">
                <div class="outer">
                <div id="" class="">
                    <div class="video-box">
                    <video controls>
                           <source src="{{asset('public/images/videos')}}/{{$video_full_width[0]}}" type="video/mp4"
                              width="200" height="300" frameborder="0" id="example">
                        </video>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
                @foreach ($video_list as $key => $video_image)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 image">
                <div class="img-wrapper">
                    <video controls>
                        <source class="videos_image videos_image_{{$key+1}}" src="{{asset('public/images/videos')}}/{{$video_image->video_url}}" 
                            width="200" height="300"/>
                    </video>
                </div>
                </div>
                @endforeach
                <div class="col-md-12 contact-form">
                <a href="{{ route('viewAll') }}" class="common-btn orange-btn hvr-sweep-to-right" >View All Videos</a>
                </div>
            </div>
      </div>
   </div>
</section>
<section id="gallery">
   <div class="container">
      <div id="image-gallery">
         <div class="row">
            <div class="col-md-12 comm-head-title text-center">
               <h2 class="common-title">Gallery</h2>
            </div>
         </div>
         <div class="row">
            @foreach ($galleries as $gallery)
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                  <a href="{{asset('public/images/gallery')}}/{{$gallery->gallery_img}}">
                     <img src="{{asset('public/images/gallery')}}/{{$gallery->gallery_img}}" class="img-responsive">
                  </a>
                  <div class="img-overlay">
                     <i class="fa fa-plus-circle" aria-hidden="true"></i>
                  </div>
               </div>
            </div>
            @endforeach
            
            <!-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/600"><img src="https://unsplash.it/600" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/700"><img src="https://unsplash.it/700" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/800"><img src="https://unsplash.it/800" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/900"><img src="https://unsplash.it/900" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/1000"><img src="https://unsplash.it/1000" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/1100"><img src="https://unsplash.it/1100" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div>
               <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 image">
               <div class="img-wrapper">
                 <a href="https://unsplash.it/1200"><img src="https://unsplash.it/1200" class="img-responsive"></a>
                 <div class="img-overlay">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                 </div>
               </div>
               </div> -->
         </div>
         <!-- End row -->
      </div>
      <!-- End image gallery -->
   </div>
   <div class="col-md-12 contact-form">
      <a href="{{ route('viewAllGallery') }}" class="common-btn orange-btn hvr-sweep-to-right" >View All Gallery</a>
   </div>
  
   <!-- End container -->
</section>
@if(isset($testimonials)&&!empty($testimonials) && count($testimonials) >0)
<section class="testimonials-main target" id="testimonials">
   <div class="container">
      <h2 class="common-title">TESTIMONIALS</h2>
      <div class="row">
         <div class="col-md-12">
            <div class="slider-box">
               <div class="owl-carousel testimonail-slider">
                  @foreach ($testimonials as $testimonial)
                  <div>
                     <div class="slider-box-content">
                        <div class="slider-box-content-head">
                           <figure><img src="{{asset('public/images/testimonial')}}/{{$testimonial->image}}" /></figure>
                           <div class="content-head-right">
                              <h4>{{$testimonial->name}}</h4>
                              <small>{{$testimonial->post}}</small>
                           </div>
                        </div>
                        <div class="slider-box-content-body">
                           <p>
                              @if(strlen($testimonial->detail) > 50)
                              {{substr($testimonial->detail,0,50)}}
                              <span class="read-more-show hide_content">More<i class="fa fa-angle-down"></i></span>
                              <span class="read-more-content">
                              {{substr($testimonial->detail,50,strlen($testimonial->detail))}}
                              <span class="read-more-hide hide_content">Less <i class="fa fa-angle-up"></i></span>
                              </span>
                              @else
                              {{$testimonial->detail}}
                              @endif
                           </p>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endif
<section class="contact-us" id="apply">
   <div class="container">
      <div class="row">
         <div class="col-md-12 comm-head-title text-center">
            <h2 class="common-title">Apply For Franchise</h2>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="form-box">
               <form method="POST" id="applyfranchise" class="Apply-Form" action="{{route('layouts.theme')}}">
                  {!! csrf_field() !!}
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                     <input type="name" class="form-control" name="name" id="name" placeholder="Please Enter Name"
                        required>
                  </div>
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                     <input type="email" class="form-control" name="email" id="email" placeholder=" Please Enter Email"
                        required>
                  </div>
                  <div class="form-group{{ $errors->has('contact_no') ? ' has-error' : '' }}" id="hidden1">
                     <input type="contact_no" class="form-control" name="contact_no" id="contact_no"
                        placeholder="Please Enter Contact No" required>
                  </div>
                  <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                     <input type="company_name" class="form-control" name="company_name" id="company_name"
                        placeholder=" Please Enter Company Name" required>
                  </div>
                  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                     <input type="address" class="form-control" name="address" id="address"
                        placeholder="Please Enter Address" required>
                  </div>
                  <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                     <input type="state" class="form-control" name="state" id="state" placeholder="Please Enter State"
                        required>
                  </div>
                  <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                     <input type="city" class="form-control" name="city" id="city" placeholder="Please Enter City"
                        required>
                  </div>
                  <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}" id="hidden1">
                     <input type="pincode" class="form-control" name="pincode" id="pincode"
                        placeholder="Please Enter Pincode" required>
                     <small class="text-danger">{{ $errors->first('pincode') }}</small>
                  </div>
                  <button type="submit" class="common-btn hvr-sweep-to-right">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- 
   <script type="text/javascript">
   $('a[href^="#"]').on('click',function (e) {
     // e.preventDefault();
   
     var section = this.hash,
     
     $section = $(section);
    
   
    $('html, body').stop().animate({
      'scrollTop': $section.offset().top-101
     }, 900, 'swing', function () {
      window.location.hash = section;
     });
   });
   
   
   
   
   
   
   </script> -->
<script src="{{asset('public/js/jquery-1.10.2.js')}}"></script>
<script src="{{asset('public/js/smoothscroll.js')}}"></script>
<script type="text/javascript">
   // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
   
   $('.read-more-content').addClass('hide_content')
   $('.read-more-show, .read-more-hide').removeClass('hide_content')
   
   // Set up the toggle effect:
   $('.read-more-show').on('click', function (e) {
      $(this).next('.read-more-content').removeClass('hide_content');
      $(this).addClass('hide_content');
      e.preventDefault();
   });
   
   // Changes contributed by @diego-rzg
   $('.read-more-hide').on('click', function (e) {
      var p = $(this).parent('.read-more-content');
      p.addClass('hide_content');
      p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
      e.preventDefault();
   });
</script>
<style type="text/css">
   .read-more-show {
   cursor: pointer;
   color: #ed8323;
   }
   .read-more-hide {
   cursor: pointer;
   color: #ed8323;
   }
   .hide_content {
   display: none;
   }
</style>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
   $(document).ready(function () {
      // Add scrollspy to <body>
      $('body').scrollspy({
         target: ".navbar",
         offset: 200
      });
   
   
      // Add smooth scrolling on all links inside the navbar
      $(".nav-link").on('click', function (event) {
   
         // Make sure this.hash has a value before overriding default behavior
         if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();
   
            // Store hash
            var hash = this.hash;
   
            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
               scrollTop: $(hash).offset().top
            }, 800, function () {
   
               // Add hash (#) to URL when done scrolling (default click behavior)
               window.location.hash = hash;
            });
         } // End if
      });
   
   
   
   
      // To Section
      // const navLinks = document.querySelectorAll(
      //   'nav a'
      // );
   
      // Array.from(navLinks).forEach(navLink => {
      //   const href = navLink.getAttribute('href');
      //   const section = document.querySelector(href);
      //   const offset = 50 + 20; // nav and offset
   
      //   navLink.onclick = e => {
      //     // get body position
      //     const bodyRect = document.body.getBoundingClientRect().top; 
      //     // get section position relative
      //     const sectionRect = section.getBoundingClientRect().top; 
      //     // subtract the section from body
      //     const sectionPosition = sectionRect - bodyRect; 
      //     // subtract offset
      //     const offsetPosition = sectionPosition - offset; 
   
      //     e.preventDefault();
      //     window.scrollTo({
      //       top: offsetPosition,
      //       behavior: 'smooth'
      //     });
      //   }
      // })
   
      // document.querySelector('#top').onclick = e => {
      //   e.preventDefault();
      //   window.scrollTo({top: 0, behavior: 'smooth'});
      // }
   
   // var id         = $('.videos_image_1').attr('data-id');
   // var videoEl    = document.getElementsByTagName('video')[0];
   // var sourceEl   = videoEl.getElementsByTagName('source')[0];
   // sourceEl.src   = id;
   // videoEl.load();

   
   
   // });

  
   // $(document).on("click", ".videos_image", function (e) {
   //    var id         = $(this).attr('data-id');
   //    var videoEl    = document.getElementsByTagName('video')[0];
   //    var sourceEl   = videoEl.getElementsByTagName('source')[0];
   //    sourceEl.src   = id;
   //    videoEl.load();
   //    document.getElementsByTagName('video')[0].play();

   // });
</script>
<style>
   .testimonials-main .content-head-right h4 {
   min-height: 50px !important;
   }
</style>