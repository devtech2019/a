<html>

   <head>

      <meta charset="utf-8">

      <title>

      @if (Request::is('contact-us'))

         BubbleBath :: Contact Us

      @else

         BubbleBath

      @endif

      </title>

      <!--responsive-meta-here-->

      <meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0,width=device-width, user-scalable=no">
      <meta name="csrf-token" content="{{ csrf_token() }}" />

      <meta name="apple-mobile-web-app-capable" content="yes">

      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

      <!--responsive-meta-end-->
      <link href="{{url('/')}}/public/front_css/bootstrap.min.css" rel="stylesheet" />

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/owl.carousel.min.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/toastr.min.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/fontawesome-all.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/fontawesome.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_fonts/remixicon.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/style.css" rel="stylesheet"/>

      <link rel="stylesheet" href="{{url('/')}}/public/front_css/responsive.css" rel="stylesheet"/>

      <!-- <link href="public/front_css/bootstrap.min.css" rel="stylesheet" />

      <link rel="stylesheet" href="public/front_css/owl.carousel.min.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_css/toastr.min.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_css/fontawesome-all.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_css/fontawesome.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_fonts/remixicon.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_css/style.css" rel="stylesheet"/>

      <link rel="stylesheet" href="public/front_css/responsive.css" rel="stylesheet"/> -->

      <link rel="preconnect" href="https://fonts.googleapis.com">

      <link rel="stylesheet" type="text/css" href="public/front_css/moovie.min.css">

      <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

       <link href="/css/app.css" rel="stylesheet">

   </head>

   <body>



      <header class="topHeader" id="fixed-header">

         <div class="container">

            <div class="logo">

            <a href="{{url('/')}}"><img src="{{url('/')}}/public/front_images/header-logo.png" class="img-responsive" alt="logo"></a>      

            </div>

            <nav class="navbar navbar-expand-lg navbar-light">

               <button class="btn" id="menu-button" type="button" data-toggle="" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

               <span class="navbar-toggler-icon">

               <img src="front_images/menu.png" />

               </span>

               </button>

               <div class="nave-bar" id="navbarSupportedContent">

                  <ul class="navbar-nav hide-menu" id="hide-menu">

                     <a href="javascript:void(0)" class="closebtn" id="close" onclick="closeNav()">×</a>

                     <li class="nav-item active"><a class="nav-link navstable" href="{{url('/')}}">Home</a></li>

                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/')}}#about-us">About Us </a></li>

                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/')}}#services">  Services</a></li>

                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/')}}#testimonials">Testimonials</a></li>

                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/contact-us')}}">  Contact us  </a></li>
                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/')}}#apply">Apply for franchise </a></li>

              

                     @if (Route::has('login'))

                     @auth

                     <li class="nav-item"><a class="nav-link navstable" href="{{url('/admin')}}"> Dashboard </a></li>

                     <li class="nav-item">

                        <a class="nav-link navstable" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                        Logout

                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                           {{ csrf_field() }}

                        </form>

                     </li>

                     @else

                     <!--  <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>

                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li> -->

                     @endauth

                     @endif

                  </ul>

               </div>

            </nav>

         </div>

      </header>

        @yield('inner_content')

      <footer>

         <div class="footer-menu">

            <div class="container">

               <div class="row">

                  <div class="col-md-4 footer-content">

                   
                     <a href="/" >

                     <img src="{{url('/')}}/public/front_images/footer-logo.png" >

                     </a>

                     <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                     <?php $socialData = CustomHelper::siteContactData(); ?>
                        <ul class="footer-social mt-2">

                        <li class="linkedin-bg">

                           <a  target="_blank" href="mailto:{{$socialData->mail ?? ''}}"><i class="fas fa-envelope"></i></a>

                        </li>

                        <li class="instagram-bg"> 
                        <a target="_blank" href="{{$socialData->instagram ?? ''}}"><i class="fab fa-instagram"></i></a>

                           

                        </li>

                        <li class="twitter-bg">

                        <a target="_blank" href="{{$socialData->twitter ?? ''}}"><i class="fab fa-twitter"></i></a>

                        </li>

                     </ul>

                  </div>

                  <div class="col-md-3 footer-content">

                     <h3>Company</h3>

                     <ul>

                        <li><a href="{{url('/')}}#about-us" >About us</a></li>

                        <li><a href="{{url('/contact-us')}}">Contact us</a></li>

                     </ul>

                  </div>

                  <div class="col-md-3 footer-content">

                     <h3>Important links</h3>

                     <ul>

                        <li><a href="{{url('pages/terms-and-conditions')}}">Terms &amp; Conditions</a></li>

                        <li><a href="{{url('pages/privacy-policy')}}">Privacy policy</a></li>

                        <li><a href="{{url('/faq')}}">FAQ</a></li>

                     </ul>

                  </div>

                  <div class="col-md-2 footer-content">

                     <h3>Connect With Us</h3>
                     <?php $socialData = CustomHelper::siteContactData(); ?>


                    <div class="app-store-link">
                    <a href="{{$socialData->ios_ipa ?? ''}}" class="app-store" download><img src="{{asset('/public/images/app-store.png')}}" alt="W3Schools"></a>
                     <a href="{{$socialData->android_apk ?? ''}}" class="app-play  mt-2" download><img src="{{asset('/public/images/app-play.png')}}" alt="W3Schools1"></a>
                    </div>
               

                  </div>

               </div>

            </div>

         </div>

         <div class="footer-bottom">

            <div class="container">

               <div class="row">

                  <div class="col-md-12 text-center">

                     <p>Copyright © Bubblebath Team. All rights reserved.</p>

                  </div>

               </div>

            </div>

         </div>

      </footer>

      <script src="/js/app.js"></script>

      <script src="public/front_js/toastr.min.js"></script>

        

      <script type="text/javascript" src="public/front_js/jquery-3.3.1.min.js"></script>

      <script type="text/javascript" src="public/bootstrap_validation/bootstrapValidator.min.js"></script>

      <script type="text/javascript" src="public/bootstrap_validation/formvalidation.js"></script>

      <script type="text/javascript" src="public/front_js/popper.min.js"></script>  

      <script type="text/javascript" src="public/front_js/bootstrap.min.js"></script> 

      <script type="text/javascript" src="public/front_js/owl.carousel.min.js"></script>

      <script type="text/javascript" src="public/front_js/moovie.js"></script>

      <script type="text/javascript" src="public/front_js/shaka-player.compiled.js"></script>



     

      <script type="text/javascript">

         var demo = new Moovie({

             selector: "#example",

             icons: {

                  path: "https://raw.githubusercontent.com/BMSVieira/moovie.js/main/icons/"

             }

         });

             

         // Get new generated player DOM element

         var videoElement = demo.video;

         const source = 'https://demo.unified-streaming.com/video/tears-of-steel/tears-of-steel-en.ism/.mpd';

         

          // Shaka

         if (shaka.Player.isBrowserSupported()) {

           shaka.polyfill.installAll();

           const shakaInstance = new shaka.Player(videoElement);

           shakaInstance.load(source);

         } else {

           console.warn('Browser is not supported!');

         }

      </script>

      <script type="text/javascript">

         $( document ).ready(function() {

         $('.sessionmodal').addClass("active");

         setTimeout(function() {

         $('.sessionmodal').removeClass("active");

         }, 4000);

         });

         // tabbed content

         // http://www.entheosweb.com/tutorials/css/tabs.asp

         $(".tab_content").hide();

         $(".tab_content:first").show();

         

         /* if in tab mode */

         $("ul.tabs li").click(function() {

           

         $(".tab_content").hide();

         var activeTab = $(this).attr("rel"); 

         $("#"+activeTab).fadeIn();        

           

         $("ul.tabs li").removeClass("active");

         $(this).addClass("active");

         

         $(".tab_drawer_heading").removeClass("d_active");

         $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");

         

         });

         /* if in drawer mode */

         $(".tab_drawer_heading").click(function() {

         

         $(".tab_content").hide();

         var d_activeTab = $(this).attr("rel"); 

         $("#"+d_activeTab).fadeIn();

         

         $(".tab_drawer_heading").removeClass("d_active");

         $(this).addClass("d_active");

         

         $("ul.tabs li").removeClass("active");

         $("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");

         });

         

         

         /* Extra class "tab_last" 

          to add border to right side

          of last tab */

         $('ul.tabs li').last().addClass("tab_last");

         

      </script>

      <script>

         $('#menu-button').click(function(e) {

             e.stopPropagation();

             $('#hide-menu').toggleClass('show-menu');

         });

         $('#hide-menu').click(function(e) {

             e.stopPropagation();

         });

         $('body,html,.closebtn').click(function(e) {

             $('#hide-menu').removeClass('show-menu');

         });

      </script>

      <script>

         window.onscroll = function() {

             myFunction()

         };

         var header = document.getElementById("fixed-header");

         var sticky = header.offsetTop;

         

         function myFunction() {

             if(window.pageYOffset > sticky) {

                 header.classList.add("sticky");

             } else {

                 header.classList.remove("sticky");

             }

         }

      </script>

      <script type="text/javascript">

         $(".video")

             .parent()

             .click(function () {

                 if ($(this).children(".video").get(0).paused) {

                     $(this).children(".video").get(0).play();

                     $(this).children(".playpause i").fadeOut();

                 } else {

                     $(this).children(".video").get(0).pause();

                     $(this).children(".playpause i").fadeIn();

                 }

             });

      </script>

      <script type="text/javascript">

         $('.owl-carousel.slider-owl').owlCarousel({

              loop:true,

               margin:0,

               nav:true,

               dot:true,

               //animateOut: 'fadeOut',

               //animateOut: 'slideOutleft',

              //animateIn: 'flipInX',

               responsive:{

                   0:{

                       items:1

                   },

                   600:{

                       items:1

                   },

                   1000:{

                       items:1

                   }

               }

           });

      </script>


      <script type="text/javascript">

         $('.owl-carousel.testimonail-slider').owlCarousel({

               autoplay: true,

               center: false,

               loop: false,

               nav: true,

               margin:30,

               responsive: {

                  0: {

                     items: 1

                 },

                 400: {

                     items: 1

                 },

                 768: {

                     items: 2

                 },

                 992: {

                     items: 3

                 }

             }

         });

      </script>


 

      <style>

        #app{

          display: flex;

          justify-content: right;

          float: right;

        }

      </style>
       <script type="">
         // Gallery image hover
$( ".img-wrapper" ).hover(
  function() {
    $(this).find(".img-overlay").animate({opacity: 1}, 600);
  }, function() {
    $(this).find(".img-overlay").animate({opacity: 0}, 600);
  }
);

// Lightbox
var $overlay = $('<div id="overlay"></div>');
var $image = $("<img>");
var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');

// Add overlay
$overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
$("#gallery").append($overlay);

// Hide overlay on default
$overlay.hide();

// When an image is clicked
$(".img-overlay").click(function(event) {
  // Prevents default behavior
  event.preventDefault();
  // Adds href attribute to variable
  var imageLocation = $(this).prev().attr("href");
  // Add the image src to $image
  $image.attr("src", imageLocation);
  // Fade in the overlay
  $overlay.fadeIn("slow");
});

// When the overlay is clicked
$overlay.click(function() {
  // Fade out the overlay
  $(this).fadeOut("slow");
});

// When next button is clicked
$nextButton.click(function(event) {
  // Hide the current image
  $("#overlay img").hide();
  // Overlay image location
  var $currentImgSrc = $("#overlay img").attr("src");
  // Image with matching location of the overlay image
  var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = $($currentImg.closest(".image").next().find("img"));
  // All of the images in the gallery
  var $images = $("#image-gallery img");
  // If there is a next image
  if ($nextImg.length > 0) { 
    // Fade in the next image
    $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
  } else {
    // Otherwise fade in the first image
    $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
  }
  // Prevents overlay from being hidden
  event.stopPropagation();
});

// When previous button is clicked
$prevButton.click(function(event) {
  // Hide the current image
  $("#overlay img").hide();
  // Overlay image location
  var $currentImgSrc = $("#overlay img").attr("src");
  // Image with matching location of the overlay image
  var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = $($currentImg.closest(".image").prev().find("img"));
  // Fade in the next image
  $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
  // Prevents overlay from being hidden
  event.stopPropagation();
});

// When the exit button is clicked
$exitButton.click(function() {
  // Fade out the overlay
  $("#overlay").fadeOut("slow");
});






$(document).ready(function() {
  var bigimage = $("#big");
  var thumbs = $("#thumbs");
  //var totalslides = 10;
  var syncedSecondary = true;

  bigimage
    .owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    autoplay: true,
    dots: false,
    loop: true,
    responsiveRefreshRate: 200,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ]
  })
    .on("changed.owl.carousel", syncPosition);

  thumbs
    .on("initialized.owl.carousel", function() {
    thumbs
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: 3,
    dots: true,
    nav: true,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ],
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: 4,
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);

  function syncPosition(el) {
    //if loop is set to false, then you have to uncomment the next line
    //var current = el.item.index;

    //to disable loop, comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    //to this
    thumbs
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = thumbs.find(".owl-item.active").length - 1;
    var start = thumbs
    .find(".owl-item.active")
    .first()
    .index();
    var end = thumbs
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
      thumbs.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      thumbs.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      bigimage.data("owl.carousel").to(number, 100, true);
    }
  }

  thumbs.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    bigimage.data("owl.carousel").to(number, 300, true);
  });
});



      </script>

   </body>

</html>
