@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="login-page">
      <div class="logo">
        @if ($contacts)
          @foreach ($contacts as $contact)
            @for ($i=0; $i < 1; $i++)
              <a href="{{url('/')}}"><img src="{{asset('public/images')}}/footer-logo.png" class="img-responsive log" alt="logo"></a>
            @endfor
          @endforeach
        @endif
      </div>
      <h4 class="user-register-heading text-center">Login</h4>
      <form class="form login-form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
          @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
          <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password">
          @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>
        <div class="form-group">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            </label>
             Remember Me
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-default">
              Login
          </button>
        </div>
        <div class="form-group text-center">
          <a href="{{url('/password/reset')}}">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>
@endsection

