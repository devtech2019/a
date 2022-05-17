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
                <h2>Faq's</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Faq's</li>
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
                <h4>Below are frequently asked questions, you may find the answer for yourself</h4>
             </div>
             <div class="faq-q-box">
                <div class="accordion" id="accordionExample">
                    @foreach ($categories as $key=>$item)
             
                   <div class="card">
                      <div class="card-header" id="heading{{$key}}">
                         <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            {{ strip_tags($item->question)}}
                            </button>
                         </h2>
                      </div>
                      <div id="collapse{{$key}}" class="collapse {{$loop->first?'show':''}}" aria-labelledby="heading{{$key}}" data-parent="#accordionExample">
                         <div class="card-body">
                            
                                  <span> 
                                     <p> {{ strip_tags($item->answer)}}</p>
                                  </span>
                         </div>
                      </div>
                   </div>
                   @endforeach
              
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

    