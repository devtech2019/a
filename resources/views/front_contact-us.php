<html>
   <head>
      <meta charset="utf-8">
        <title>
      @if ($contacts)
        @foreach ($contacts as $contact)
          @for ($i=1; $i <= 1; $i++)
            {{$contact->c_name}}
          @endfor
        @endforeach
      @else
       BubbleBath
       
      @endif
    </title>
      <!--responsive-meta-here-->
     <meta name="viewport" content="minimum-scale=1.0, maximum-scale=1.0,width=device-width, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <!--responsive-meta-end-->
    <link href="public/front_css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="public/front_css/owl.carousel.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="public/front_css/fontawesome-all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="public/front_css/fontawesome.css" rel="stylesheet"/>
    <link rel="stylesheet" href="public/front_fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="public/front_css/style.css" rel="stylesheet"/>
    <link rel="stylesheet" href="public/front_css/responsive.css" rel="stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" type="text/css" href="public/front_css/moovie.min.css">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   </head>
   <body>

    <header class="topHeader inner-header" id="fixed-header">
        <div class="container">
            <div class="logo">
                 <a href="{{url('/')}}"><img src="{{asset('front_images/logo.svg')}}" class="img-responsive" alt="logo"></a>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="btn" id="menu-button" type="button" data-toggle="" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <img src="front_images/menu.png"/>
                    </span>
                </button>
                <div class="nave-bar" id="navbarSupportedContent">

                    <ul class="navbar-nav hide-menu" id="hide-menu">
                           <a href="javascript:void(0)" class="closebtn" id="close" onclick="closeNav()">×</a>
                       <li class="nav-item active"><a class="nav-link" href="index.blade.php">Home</a></li>
                      <li class="nav-item"><a class="nav-link" href="#">About Us </a></li>
                      <li class="nav-item"><a class="nav-link" href="#">  Services</a></li>
                      <li class="nav-item"><a class="nav-link" href="Terms-&-Conditions.php">Testimonials</a></li>
                      <li class="nav-item"><a class="nav-link" href="{{url('/contact')}}">  Contact us  </a></li>
                    </ul>

                </div>
            </nav>
        </div>
    </header>
<div class="wraper-inner inner-mar">
    <!--banner-section-->

    <div class="inner-title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Terms & Conditions</h2>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

  <div class="inner-body">
        <div class="map-box">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.7603742291385!2d90.36625026536275!3d23.755923044481314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf51340c1c4b%3A0xc6e3200844f0857d!2sLalmatia%2C%20Dhaka%2C%20Bangladesh!5e0!3m2!1sen!2sin!4v1624946031997!5m2!1sen!2sin"
                width="100%"
                height="540"
                style="border: 0;"
                allowfullscreen=""
                loading="lazy"
            ></iframe>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-us-main">
                        <div class="contact-us-head">
                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="text">
                                    <p>Lalmatia, Dhaka-1216</p>
                                </div>
                            </div>
                            <!-- End item -->
                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="text">
                                    <p><a href="mailto:mail@gmail.com">mail@gmail.com</a></p>
                                </div>
                            </div>
                            <!-- End item -->

                            <div class="item">
                                <div class="icon">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div class="text">
                                    <p><a href="tel:88012345678">+880 12345678</a></p>
                                </div>
                            </div>
                            <!-- End item -->
                        </div>

                        <div class="contact-form">
                            <h2>Get In Touch With Us</h2>
                            <p>Leave A Message</p>

                            <form class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" placeholder="Name" class="form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" placeholder="Email" class="form-control" />
                                </div>

                                <div class="form-group col-md-12">
                                    <input type="text" placeholder="Subject" class="form-control" />
                                </div>

                                <div class="form-group col-md-12">
                                    <textarea class="form-control" placeholder="Your Message"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn hvr-sweep-to-right">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <footer>
      
        <div class="footer-menu">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 footer-content">
                        <a href="index.php">
                            <img src="front_images/footer-logo.svg">
                        </a>

                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                    </div>
                    <div class="col-md-3 footer-content">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="contact-us.php">Contact us</a></li>
                            
                        </ul>
                    </div>
                    <div class="col-md-3 footer-content">
                        <h3>Important links</h3>
                        <ul>
                           
                            <li><a href="Terms-&-Conditions.php">Terms &amp; Conditions</a></li>
                            <li><a href="privacy-policy.php">Privacy policy</a></li>
                            <li><a href="FAQ.PHP">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 footer-content">
                        <h3>Connect With Us</h3>
                        <ul class="footer-social">
                           
                            <li class="linkedin-bg">
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </li>
                            <li class="instagram-bg">
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </li>

                          
                            <li class="twitter-bg">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>Copyright © lorem Company. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

  <script type="text/javascript" src="public/front_js/jquery-3.3.1.min.js"></script>
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
$('.owl-carousel.just-beginning').owlCarousel({
  autoplay: true,
  center: true,
  loop: true,
  nav: false,
  margin:10,

      responsive: {
         0: {
            items: 1
        },
        400: {
            items: 1
        },
        768: {
            items: 3
        },
        1200: {
            items: 5
        }
    }
});

</script>

<script type="text/javascript">



$('.owl-carousel.testimonail-slider').owlCarousel({




   
  autoplay: true,
 center: false,
  loop: true,
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
</body>
</html>
</div>
