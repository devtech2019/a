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
                      <h2>Videos</h2>
                      <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>

                              <li class="breadcrumb-item active" aria-current="page">Videos</li>
                          </ol>
                      </nav>
                  </div>
              </div>
          </div>
        </div>
        <section class="gallery-sec">
          <div class="container">
              <div class="row" id="image-videos">
                  <input type="hidden" id="offset" value="0">
                  @foreach ($video_list as $video_image)
                    <div class="col-sm-6">
                      <div class="img-wrapper div_count">
                      <video width="auto" height="310" controls>
                        <source src="{{asset('public/images/videos')}}/{{$video_image->video_url}}" type="video/mp4">
                        </video>
                        <!-- <img src ="{{asset('public/images/videos')}}/{{$video_image->video_image}}"> -->
                      </div>
                    </div>
                  @endforeach
              </div>
              
              <div class="col-md-12 contact-form contact_form_video" id="load_more">
                 @if($totalRecord > 4) <button type="button" name="load_more_button" class="btn hvr-sweep-to-right" id="load_more_button">Load More</button>
                 @endif
              </div>

          </div>
        </section>
    </div>








 
<script>
    $(document).on('click', '#load_more_button', function () {
        //$('#load_more_button').html('<b>Loading...</b>');
        $.ajax({
          url: "{{ route('viewAll') }}",
          method: "POST",
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {
              _token        : $('input[name="_token"]').val(),
              total_records : "{{$totalRecord}}",
              offset        : $("#offset").val(),
          },
          success: function (data) {
              //$('#load_more_button').html('<b>Loading</b>');
              $('#image-videos').append(data.data);
              $('#offset').val(data.offset);
              var numItems = $('div.div_count').length;
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
@endsection

    