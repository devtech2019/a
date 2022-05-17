<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>BubbleBath</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset('public/css/datepicker.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}">
  <!-- bootstrap -->
  <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/fontawesome-iconpicker.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/css/AdminLTE.css')}}">
  <!-- icon-font css -->
  <link rel="stylesheet" href="{{asset('public/css/icon-font.css')}}"/>
  <link rel="stylesheet" href="{{asset('public/css/skin-blue.css')}}">
  <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
</head>
<body class="login-register-page">
  <!-- login main block -->
  <!-- <div class="login-main-block">
    @yield('content')
  </div> -->
     
  @yield('content')
    
<!-- end login main block -->
<!-- Scripts -->
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('public/js/select2.full.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('public/js/bootstrap-datepicker.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/js/adminlte.js')}}"></script>
<script src="{{asset('public/js/fontawesome-iconpicker.min.js')}}"></script>
<script src="{{asset('public/js/theme.js')}}"></script>





</body>
</html>
