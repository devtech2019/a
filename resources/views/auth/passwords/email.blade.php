@extends('layouts.app')

@section('content')
<div class="container">
   <div id="app">
              @include('flash-message')  
            </div>
  <div class="login-page">
    <div class="logo">
       <div class="login-logo">
            <a href="/"><strong>{!! config('app.name') !!}</strong></a>
        </div>
    
          @for ($i=0; $i < 1; $i++)
            <a href="{{url('/')}}"><img src="{{asset('public/images')}}/logob.png" class="img-responsive" alt="logo" style ="display: flex; text-align: center;margin-left: 35px; border-radius: 15px 15px;"></a>
          @endfor
     
    </div>
    <h4 class="user-register-heading text-center">Reset Password</h4>
    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif
    <form class="form" method="POST" action="{{ route('password.email') }}">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="control-label">Email Address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group btn-square">
        <button type="submit" class="btn btn-default">
            Reset Password
        </button>
        <a href="{{ url('/login') }}" style=" display:flex;justify-content: center;">Back to login ?</a>
      </div>
    </form>
  </div>
</div>
<style type="text/css">
  #app{
    display: flex;
    float: right;
    
  }
</style>
@endsection
