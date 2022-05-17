
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                       <div class="faq_content_wrapper">
                  <h4>Below are frequently asked questions, you may find the answer for yourself</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id erat sagittis, faucibus metus malesuada, eleifend turpis. Mauris semper augue id nisl aliquet, a porta lectus mattis. Nulla at tortor augue. In eget enim diam. Donec gravida tortor sem, ac fermentum nibh rutrum sit amet. Nulla convallis mauris vitae congue consequat. Donec interdum nunc purus, vitae vulputate arcu fringilla quis. Vivamus iaculis euismod dui.</p></div>
              

                  <div class="faq-q-box">
                      <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
       <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
       <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h2>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
       <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p>
      </div>
    </div>
  </div>
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
