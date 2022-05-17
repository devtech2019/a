@extends('layouts.admin')
@section('sidebar_active')
@include('include.sidebar_links', [
'users' => '', 'all_user' => '', 'create_user' => '',
'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
'plan' => '', 'all_plan' => '', 'plan_price' => '',
'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '',
'opening_hours' => '', 'company_social' => '',
'profile' => '', 'sub_appointment' => '',
'contactUslist' => 'active'
])
@endsection
@section('breadcum')
@include('include.breadcum', [
'title' => 'All Cancellation-Charges-Amount-list',
'from' => 'Admin',
'to' => 'All Cancellation-Charges-Amount-list',
])
@endsection
@section('content')
<div class="box-body">
    <!-- <form id="searchForm" name="searchForm" type="post" >
      <div class="row">
          <div class="col-md-5">
               <div class="form-group">
                  <label for="name">User Name</label>
                  <div class="input-group displayblock">
                      <input type="text" name="name" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter Cleaner Name">
                  </div>
              </div>
          </div>     
          <div class="col-md-5">
               <div class="form-group">
                  <label for="email">Cleaner Name</label>
                  <div class="input-group displayblock">
                      <input type="text" name="name" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter User Name">                             
                  </div>
              </div>
          </div>   
          <div class="col-md-2">
               <div class="form-group">
                  <label for="active_from"><?php echo '&nbsp;' ?></label>
                  <div class="input-group">
                      <button type="button" id="reset" class="btn btn-primary">Reset</button>
                  </div>
              </div>
          </div>   
      </div>               
      </form> -->
    <table id="dataShowTable" class="row-border hover table table-bordered cb-data-table table-r" cellspacing="0"
        width="100%">
        <thead>
            <tr>
                <th width="3%">S.No.</th>
                <th class="desktop">Cleaner Name</th>
                <th>User Name </th>
                <th>Real Amount</th>
                <th>Return Amount</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
    </table>
</div>
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var dataTable = "";
    var Sreq = 1;
    var i = 1;
    $(document).ready(function () {
        dataTable = $('#dataShowTable').DataTable({
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('DataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
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
                "url": "{{route('penalty.index')}}",

                "type": "POST",
                "data": {
                    "sreq": Sreq,
                    '_token': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    Sreq = 1;
                },
                dataSrc: function (res) {
                    if (res) {
                        try {
                            Sreq = res.sreq;
                            return res.data;
                        } catch (e) {
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
                    render: function (data, type, full, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": {},
                    "orderable": false,
                    "searchable": false,
                    "render": function (result) {
                        if (result && result.cancellation_cleaner_detail && result
                            .cancellation_cleaner_detail.name != null)
                        return "<div id='dvNotes' class='wordwrap'>" + result
                            .cancellation_cleaner_detail.name + "</div>";
                    }
                },
                {
                    "data": {},
                    "orderable": false,
                    "searchable": false,
                    "render": function (result) {
                        if (result && result.cancellation_user_detail && result
                            .cancellation_user_detail.name != null)
                        return "<div id='dvNotes' class='wordwrap'>" + result
                            .cancellation_user_detail.name + "</div>";
                    }
                },


                {
                    data: 'real_amount'
                },
                {
                    data: 'return_amount'
                },
                // {
                //     "data": {},
                //     "orderable": false,
                //     "searchable": false,
                //     "render": function (result) {


                //         var id = (result.id) ? result.id : "";
                //         var name = (result.name) ? result.name : "";
                //         var adminListUrl = "{{$adminListUrl}}";

                //         //  var deleteUrl        =   adminListUrl+'/delete-franchise-list/'+id;
                //         var statusUrl = adminListUrl + '/penalty_amount/';
                //         var transactionUrl = adminListUrl + '/refund_transaction';
                       
                //         var statusClass = (result.status == 0) ? 'btn-success' : 'btn-light';
                //         var statusIcon = (result.status == 0) ? 'fa-unlock' : 'fa-lock';
                //         var statusName = (result.status == 0) ? 'Send' : 'Reject';

                //         var dropDownButton = '' +

                //             '<div class="btn-toolbarr">' +
                //             '<span class="btn btn-info model_button btn-sm mr-1 ' +
                //             statusClass + '" data-id="' + id +
                //             '" id="change"   value="is_block" data-toggle="modal" title="" data-original-title="status ' +
                //             name + '">' +
                //             '<i class="">Manual Amount</i>' +
                //             '</span>' +
                //             '<a href="' + transactionUrl+'/with_penalty/' + id +
                //             '" class="btn btn-info btn-sm mr-1 penaltyamount" data-toggle="tooltip" title="" data-original-title="Edit ' +
                //             name + '">' +
                //             '<i class="">Normal Refund</i>' +
                //             '</a>' +
                //             '<a href="' + transactionUrl+'/without_penalty/' + id +
                //             '" class="btn btn-info btn-sm mr-1 penaltyamount" data-toggle="tooltip" title="" data-original-title="Edit ' +
                //             name + '">' +
                //             '<i class="">Instant Refund</i>' +
                //             '</a>' +
                //             '</div>';
                //         return dropDownButton;
                //     }
                // },

            ]
        });
    });

    /** Javascript function to search datatable */
    function searchDatatable(columnNumber) {
        var query = $('#column_filter_' + columnNumber).val();
        if (Sreq == 0) {
            dataTable.column(columnNumber).search(query).draw();
        }
    } //end searchDatatable()

    $(document).on("click", ".model_button", function () {
        $("#panulty_id").val($(this).data("id"))
        $('#block_modal').modal();

    })
    // $('.model_button').click(function(){

    // });
    // function openblockModal(e){
    //     // $('#blockfaqcat').attr('href',url);
    //     // $("#blockfaqcat").text(statusName);

    // } 

    // $(function () {
    //     $('.sendpenaltyAmount').on('click', function () {


    //         $.ajax({

    //             type: "POST",
    //             url: "{{route('penaltyAmount')}}",
    //             data: {
    //                 _token: "{{csrf_token()}}",
    //                 "id": $(":input[name='id']").val(),
    //                 "amount": $(":input[name='amount']").val()
    //             },
    //             success: function (response) {
    //                 if (response && response.status == "success") {
    //                     toastr.success(response.message);
    //                 } else {
    //                     toastr.error(response.message);
    //                 }
    //                 window.location.reload()
    //             }
    //         });
    //     });
    // });

   
</script>
<!-- <script>
  $(function () {
   
     var pattern = /^\d{5}$/;

$('#amount').blur(function() {
    if ($('#amount').val().match(pattern)) {
        alert('field ok');
    } else {
        alert('Please check amount.');
    }
});
});
 </script> -->
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
<!-- <div id="block_modal" class="block_modal modal fade " role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="delete-icon"></div>
            </div>
            <div class="modal-body text-center">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, <br>sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. </p>
                <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                    <label class="col-form-label" for="modal-input-id">Amount</label>
                    <input type="text" name="amount" class="form-control amount" id="amount" required>
                    <small class="text-danger">{{ $errors->first('amount') }}</small>
                    <input type="hidden" name="id" class="form-control" id="panulty_id">
                </div>
            </div>
            <div class="modal-footer">
                <div class="sendpenaltyAmount btn  btn-info btn-sm btn-success mr-1" data-id="">Send</div>
            </div>
        </div>
    </div>
</div> -->
@endsection