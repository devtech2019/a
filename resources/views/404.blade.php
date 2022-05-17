
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
                <h2>404 Page</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">404 Page</li>
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
             <div class="error-dtl">

              <h1 class="error-heading">4<span>0</span>4</h1>

              <p>Please go back to home and try to find out once again. <a href="{{url('/')}}" class="common-btn">Go to Home</a></p>

           

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

    