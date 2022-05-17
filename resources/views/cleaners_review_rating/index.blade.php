@extends('layouts.admin') 
@section('sidebar_active') 
@include('include.sidebar_links', [ 'users' => '', 'all_user' => '', 'create_user' => '', 'teams' => 'active', 'all_team' => 'active', 
'create_team' => '', 'team_task' => '', 'plan' => '', 'all_plan' => '', 'plan_price' => '', 'vehicle' => '', 'vehicle_company' => '', 
'vehicle_modal' => '', 'vehicle_type' => '', 'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 
'status' => '', 'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 
'opening_hours' => '', 'company_social' => '', 'profile' => '', 'sub_appointment' => '', ]) 
@endsection 
@section('breadcum')
 @include('include.breadcum', [ 'title' => 'Cleaners Review And Rating', 'from' => 'Admin', 'to' => 'Cleaners Review And Rating', ]) 
 @endsection 
 @section('content')
<div class="box-body">
	<div class="box-body">
		<div class="box-body">
			<table id="dataShowTable" class="row-border hover table table-bordered cb-data-table table-r" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Appointment Date</th>
						<th>Appointment Time</th>
						<th>Review</th>
						<th>Rating</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<!-- jQuery Library -->
	<script type="text/javascript" src="{{asset('public/js/jquery.min1.js')}}"></script>
	<script>
	var dataTable = "";
	var Sreq = 1;
	var franchiseCleaners = [];
	var franchiseId = '';
	$(document).ready(function() {
		dataTable = $('#dataShowTable').DataTable({
			"bStateSave": true,
			"fnStateSave": function(oSettings, oData) {
				localStorage.setItem('DataTables', JSON.stringify(oData));
			},
			"fnStateLoad": function(oSettings) {
				return JSON.parse(localStorage.getItem('DataTables'));
			},
			"processing": true,
			"serverSide": true,
			"order": [
				[0, "desc"]
			],
			"sDom": "ltipr",
			"ajax": {
				async: true,
				"url": "{{$adminListUrl}}",
				"type": "POST",
				"data": {
					"sreq": Sreq,
					'_token': '{{ csrf_token() }}'
				},
				beforeSend: function() {
					Sreq = 1;
				},
				dataSrc: function(res) {
					if(res) {
						try {
							Sreq = res.sreq;
							franchiseCleaners = res.franchiseCleaners;
							franchiseId = res.franchiseId;
							return res.data;
						} catch(e) {
							return [];
						}
					} else {
						return [];
					}
				},
			},
			"columns": [{
				data: 'appointment_details',
				name: 'appointment_details',
				"orderable": false,
				"searchable": false,
				render: function(appointment_details) {
					if(appointment_details) {
						if(appointment_details != null) return '<span class="">' + appointment_details.appointment_date + '</i>'
					}
				}
			}, {
				data: 'appointment_details',
				name: 'appointment_details',
				"orderable": false,
				"searchable": false,
				render: function(appointment_details) {
					if(appointment_details) {
						if(appointment_details != null) return '<span class="">' + appointment_details.time_frame + '</i>'
					}
				}
			}, {
				data: 'reviews',
			}, {
				data: 'ratinng',
				name: 'ratinng',
				"orderable": false,
				"searchable": false,
				render: function(ratinng) {
					if(ratinng) {
						if(ratinng != null) return '<div class="reviews1">' + ratinng + '</div>'
					}
				}
			}, ]
		});
	});
	/** Javascript function to search datatable */
	function searchDatatable(columnNumber) {
		var query = $('#column_filter_' + columnNumber).val();
		if(Sreq == 0) {
			dataTable.column(columnNumber).search(query).draw();
		}
	} //end searchDatatable()
	</script>
	<script>
	function openModal(url) {
		$('#deletefaqcat').attr('href', url);
		$('#delete_modal').modal();
	}
	</script>
	<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script> @endsection