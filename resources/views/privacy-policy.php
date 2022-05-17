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
                <h2>Privacy Policy</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
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
                            <h4>Privacy Policy</h4>
                        </div>
                        {!! $content_data !!}
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

    