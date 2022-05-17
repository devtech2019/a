<script src="{{asset('/public/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('/public/js/notify.js')}}"></script>

@if ($message = Session::get('success'))
<script type="text/javascript">
	$.notify("{{ $message }}", "success");
</script>
@endif

@if ($message = Session::get('error'))
<script type="text/javascript">
	$.notify("{{ $message }}", "error");
</script>
@endif

@if ($message = Session::get('warning'))
<script type="text/javascript">
	$.notify("{{ $message }}", "warn");
</script>
@endif

@if ($message = Session::get('info'))
<script type="text/javascript">
	$.notify("{{ $message }}", "info");
</script>
@endif

@if ($errors->any())
<script type="text/javascript">
	$.notify("Please check the form below for errors", "success");
</script>
@endif