@extends('layouts.theme')
@section('inner_content')
    <div id="app1">
    @include('flash-message')  
    </div>
    <div class="wraper-inner inner-mar">       
        <div class="inner-title">
          <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <h2>Gallery</h2>
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>

                              <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
        </div>
        <section class="gallery-sec" id="gallery">
          <div class="container">
            <input type="hidden" id="offset" value="0">
            <div id="image-gallery2">
              <div class="row">
                  @foreach ($galleries as $gallery)
                  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 image">
                    <div class="img-wrapper">
                        <a href="{{asset('public/images/gallery')}}/{{$gallery->gallery_img}}" target="_blank"><img
                          src="{{asset('public/images/gallery')}}/{{$gallery->gallery_img}}" class="img-responsive"></a>
                        <!-- <div class="img-overlay">
                          <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        </div> -->
                    </div>
                  </div>
                  @endforeach
              </div>
              </section>
            </div>
            <div class="col-md-12 contact-form contact_form_video" id="load_more">
                <button type="button" name="load_more_button" class="btn hvr-sweep-to-right" id="load_more_button">Load More</button>
            </div>
          </div>
        
    </div>
<script>
   


    $(document).on('click', '#load_more_button', function () {
        //$('#load_more_button').html('<b>Loading...</b>');
        $.ajax({
          url: "{{ route('viewAllGallery') }}",
          method: "POST",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

          data: {
              _token        : $('input[name="_token"]').val(),
              total_records : "{{$totalRecord}}",
              offset        : $("#offset").val(),
          },
          success: function (data) {
              //$('#load_more_button').html('<b>Loading</b>');
              $('#image-gallery2').append(data.data);
              $('#offset').val(data.offset);
              if (data.totalRecord && (data.totalRecord-1) <= data.offset+3){
                $('#load_more_button').hide();
              }
          }
        });
    });


</script>
<style type="text/css">
    .navbar-light .navbar-nav .navstable{
        color:#000!important;
    }
    .navbar-nav li.nav-item.active a.navstable{
        color:#000!important;
    }
    #app1{
        display: flex;
        float: right;
    }
</style>
<script>
  $nextButton.click(function(event) {
  // Hide the current image
  $("#overlay img").hide();
  // Overlay image location
  var $currentImgSrc = $("#overlay img").attr("src");
  // Image with matching location of the overlay image
  var $currentImg = $('#image-gallery2 img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = $($currentImg.closest(".image").next().find("img"));
  // All of the images in the gallery
  var $images = $("#image-gallery2 img");
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
  var $currentImg = $('#image-gallery2 img[src="' + $currentImgSrc + '"]');
  // Finds the next image
  var $nextImg = $($currentImg.closest(".image").prev().find("img"));
  // Fade in the next image
  $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
  // Prevents overlay from being hidden
  event.stopPropagation();
});
  </script>
@endsection

    