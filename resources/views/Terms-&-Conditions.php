

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
                       <li class="nav-item active"><a class="nav-link" href="{{url('/')}}">Home</a></li>
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
<div class="wraper-inner inner-mar">
    <!--banner-section-->

    <div class="inner-title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Terms & Conditions</h2>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>

                            <li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="inner-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                 <div class="terms-condition-content">

                    <h2 class="common-title comm-inner-title">Terms & Conditions
                    </h2>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                            it to make a type specimen book. It has survived not only five centuries, but also the
                        </p>

                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                        <p>
                            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                            Hampden-Sydney College in Virginia,
                        </p>

                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                            it to make a type specimen book. It has survived not only five centuries, but also the
                        </p>

                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                        <p>
                            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                            Hampden-Sydney College in Virginia,
                        </p>

                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                            it to make a type specimen book. It has survived not only five centuries, but also the
                        </p>

                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                        <p>
                            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                            Hampden-Sydney College in Virginia,
                        </p>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                            it to make a type specimen book. It has survived not only five centuries, but also the
                        </p>

                        <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                        <p>
                            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at
                            Hampden-Sydney College in Virginia,
                        </p>
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
                            <li><a href="{{url('/contact')}}">Contact us</a></li>   
                        </ul>
                    </div>
                    <div class="col-md-3 footer-content">
                        <h3>Important links</h3>
                        <ul>
                           
                            <li><a href="Terms-&-Conditions.php">Terms &amp; Conditions</a></li>
                            <li><a href="{{url('/privacy_policy')}}">Privacy policy</a></li>
                            <li><a href="{{url('/faq')}}">FAQ</a></li>
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
</div>
