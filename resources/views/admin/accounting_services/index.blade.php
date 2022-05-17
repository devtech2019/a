@extends('layouts.admin') @section('sidebar_active') @include('include.sidebar_links', [ 'users' => '', 'all_user' => '', 'create_user' => '', 'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '', 'plan' => '', 'all_plan' => '', 'plan_price' => '', 'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '', 'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => 'active', 'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '', 'profile' => '', 'sub_appointment' => '', ]) @endsection @section('breadcum') @include('include.breadcum', [ 'title' => 'All Accounts', 'from' => 'Admin', 'to' => 'All Accounts', ]) @endsection @section('content')
<div class="box-body ">
	<div class="scroll_table">
		<table id="dataShowTable" class="table table-hover users-table">
			<thead>
				<tr class="info">
					<th width="3%">S.No.</th>
					<th width="20%">Amount</th>
					<th width="15%">Date</th>
					<th width="15%">Action</th>
				</tr>
			</thead>
			<tbody> </tbody>
		</table>
	</div>
</div>
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
var dataTable = "";
var Sreq = 1;
var i = 1;
$(document).ready(function() {
	dataTable = $('#dataShowTable').DataTable({
		//     "dom": 'lBrtip',
		// "buttons": [
		//     'csv', 'excel'
		// ],
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
			"url": "{{route('accounting_services.index')}}",
			"type": "POST",
			"data": {
				"sreq": Sreq,
				'_token': '{{ csrf_token() }}',
				"startDate": $('#start_date').val(),
				"endDate": $('#end_date').val(),
			},
			beforeSend: function() {
				Sreq = 1;
			},
			dataSrc: function(res) {
				if(res) {
					try {
						Sreq = res.sreq;
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
			name: "id",
			data: "id",
			"searchable": false,
			"orderable": false,
			render: function(data, type, full, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		}, {
			data: 'amount',
		}, {
			data: 'date',
		}, {
			"data": {},
			"orderable": false,
			"searchable": false,
			"render": function(result) {
				var id = (result.id) ? result.id : "";
				var name = (result.name) ? result.name : "";
				var adminListUrl = "{{$adminListUrl}}";
				var deleteUrl = adminListUrl + '/delete-accounting-services/' + id;
				var dropDownButton = '' + '<div class="btn-toolbarr">' + '<a href="' + adminListUrl + '/edit/' + id + '" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit ' + name + '">' + '<i class="fa fa-fw fa-edit text-white"></i>' + '</a>' + '<span class="btn btn-sm btn-danger mr-1" onclick=openModal("' + deleteUrl + '") data-toggle="modal" title="" data-original-title="delete ' + name + '">' + '<i class="fa fa-fw fa-trash text-white"></i>' + '</span>' + '<div id="delete_modal" class="delete-modal modal fade" role="dialog">' + '<div class="modal-dialog modal-sm">' + '<div class="modal-content">' + '<div class="modal-header">' + '<button type="button" class="close" data-dismiss="modal">&times;</button>' + '<div class="delete-icon"></div>' + '</div>' + '<div class="modal-body text-center">' + '<h4 class="modal-heading">Are You Sure ?</h4>' + '<p>Do you really want to delete these accounts?</p>' + '</div>' + '<div class="modal-footer">' + '<span  class="btn btn-gray"  data-dismiss="modal" title="reset">' + 'No</span>' + '<a href="#" id="deletefaqcat" class="btn btn-sm btn-danger mr-1 myModal"  data-toggle="modal" title="" data-original-title="delete ' + name + '">' + '<i class="fa fa-fw text-white"></i>Yes' + '</a>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
				return dropDownButton;
			}
		}, ]
	});
});
// Javascript function to search datatable 
function searchDatatable(columnNumber) {
	var query = $('#column_filter_' + columnNumber).val();
	if(Sreq == 0) {
		dataTable.column(columnNumber).search(query).draw();
	}
} //end searchDatatable()
</script>
<style>
.csvimp {
	display: block;
	padding: 7px;
	text-align: right;
}
</style>
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
function openModal(url) {
	$('#deletefaqcat').attr('href', url);
	$('#delete_modal').modal();
}

</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
 @endsection