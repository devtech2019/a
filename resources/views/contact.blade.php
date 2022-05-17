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
                <h2>Contact Us</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  </div>
  <div class="inner-body">
      <div class="map-box">
        @foreach($contacts as $contact)
          <iframe
              src="{{$contact->address}}"
              width="100%"
              height="540"
              style="border: 0;"
              allowfullscreen=""
              loading="lazy"
          ></iframe>
        @endforeach
      </div>
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="contact-us-main">
                     @foreach($contacts as $contact)
                      <div class="contact-us-head">
                        
                          <div class="item">
                              <div class="icon">
                                  <i class="fas fa-map-marker-alt"></i>
                              </div>
                              <div class="text">
                                  <p>{{$contact->c_name}}</p>
                              </div>
                          </div>
                          <!-- End item -->
                        

                          <div class="item">
                              <div class="icon">
                                  <i class="fas fa-globe"></i>
                              </div>
                              <div class="text">
                                  <p><a href="mailto:mail@gmail.com">{{$contact->email}}</a></p>
                              </div>
                          </div>
                          <!-- End item -->

                          <div class="item">
                              <div class="icon">
                                  <i class="fas fa-phone-volume"></i>
                              </div>
                              <div class="text">
                                  <p><a href="tel:88012345678"> {{$contact->mobile}}</a></p>
                              </div>
                          </div>
                          <!-- End item -->
                      </div>
                    @endforeach
                      <div class="contact-form">
                          <h2>Get In Touch With Us</h2>
                          <p>Leave A Message</p>

                          <form method="POST"  class="row" id="contact_us" action="{{route('contact-us')}}">
                            {!! csrf_field() !!}
                              <div class="form-group col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                                   <input type="name" class="form-control" name="name" id="name" placeholder="Please Enter Name" > 
                              </div>
                              <div class="form-group col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                                  <input type="email" placeholder=" Please Enter Email" name="email" id="email" class="form-control" />
                              </div>

                              <div class="form-group col-md-12 {{ $errors->has('subject') ? ' has-error' : '' }}">
                                  <input type="subject" placeholder=" Please Enter Subject" name="subject" id="subject" class="form-control" />
                              </div>

                              <div class="form-group col-md-12 subject {{ $errors->has('message') ? ' has-error' : '' }}">
                                  <textarea  name="message" class="form-control" id="message" placeholder="Your Message"></textarea>
                              </div>
                              <div class="form-group col-md-12">
                                  <button type="submit" class="btn hvr-sweep-to-right">Send Message</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
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

    