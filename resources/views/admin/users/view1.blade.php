@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => 'active', 'appointment' => 'active', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'all_appointment' => '',
    'cleanersBookings' => '', 'all_bookings' => '',
    
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Payment Transaction',
    'from' => 'Admin',
    'to' => 'All Payment Transaction',
  ])
@endsection

@section('content')   

    <div class="box-body ">
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-3">
                    <div class="form-group">
                    <label for="payment_id">Payment</label>
                    <div class="input-group displayblock">
                        <input type="text" name="payment_id" class="form-control " id="column_filter_0"  onkeyup="searchDatatable(0)" placeholder="Search by Payment Id ">
                    </div>
                </div>
            </div>     
            <div class="col-md-3">
                    <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group displayblock">
                        <input type="email" name="email" class="form-control " id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Search by email">                             
                    </div>
                </div>
            </div>   
            <div class="col-md-5">
                <div class="form-group">
                    <label for="dates">Date Range</label>
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" autocomplete="off">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                        <input type="hidden" name="start_date" id="start_date" class="form-control" value="" autocomplete="off" >                             
                        <input type="hidden" name="end_date"   id="end_date"   class="form-control" value="" autocomplete="off">                             
                    </div>
                </div>
            </div> 
            <div class="col-md-1">
                    <div class="form-group">
                    <label for="active_from"><?php echo '&nbsp;' ?></label>
                    <div class="input-group">
                        <button type="button" id="reset" class="btn btn-primary">Reset</button>
                    </div>
                </div>
            </div>   
        </div>               
    </form>
      <table id="dataShowTable" class="table table-hover users-table">
        <thead>
          <tr class="info">
           
            <th width="20%">Payment Id</th>
            <th width="15%">Base Amount</th>
            <th width="15%">Amount</th>
            <th width="15%">Email</th>
            <th width="15%">Contact</th>
            <th width="15%">Status</th>
            <th width="15%">Type</th>
            <th>Created At</th>
            <th>Updated At</th>
            <!-- <th width="15%">Time frame</th>
            <th width="15%">Action</th> -->
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>    
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();
        function cb(start, end) {
            $('#start_date').val(start);
            $('#end_date').val(end);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //$('#reportrange span').html();
        }
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });
    var dataTable   = "";
    var Sreq        = 1;
    var i           = 1;
  
    $(document).ready(function() {
 

        dataTable   =    $('#dataShowTable').DataTable({
           
            "bStateSave"     :true,

            "fnStateSave"   : function (oSettings, oData) {
                localStorage.setItem( 'DataTables', JSON.stringify(oData) );
            },
           
            "fnStateLoad"   : function (oSettings) {
                return JSON.parse( localStorage.getItem('DataTables') );
            },

            "processing"    :   true,
            "serverSide"    :   true,  //$qrs             =  Appointment::with(['cleaner_transaction','washing_plan'])->where('id',$appointmentId)->get();
            "order"         :   [[ 0, "desc" ]],
            "sDom"          :   "ltipr",
            "ajax": {
                async   :   true,
                "url"   :   "{{$adminListUrl}}",

                "type"  :   "POST",
                "data"  :   {"sreq":Sreq,'_token':'{{ csrf_token() }}'},
                beforeSend: function () {
                    Sreq    =   1;
                },
                dataSrc :   function(res){
                    if(res){name
                       try{
                            Sreq    =   res.sreq;

                            return res.data;
                        } catch(e) {
                            return [];
                        } 
                    }else{
                        return [];
                    }
                },
            },
             "columns": [    
                // { 
                //     name: "id", 
                //     data: "id", 
                //     "searchable": false, 
                //     "orderable": false,
                //     render:function(data, type, full, meta){
                //         return meta.row + meta.settings._iDisplayStart + 1;
                //     }
                // },

                // {data  : "plan_name" },
                { 
                    data: 'payment_id', 
                    name: 'payment_id',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(payment_id){
                        if(payment_id != null) return  "<div id='dvNotes' class='wordwrap'>" + payment_id + "</div>";
                    }
                }, 
                { 
                    data: 'base_amount', 
                    name: 'base_amount',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(base_amount){
                        if(base_amount != null) return  "<div id='dvNotes' class='wordwrap'>" + base_amount + "</div>";
                    }
                }, 
                { 
                    data: 'amount', 
                    name: 'amount',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(amount){
                        if(amount != null) return  "<div id='dvNotes' class='wordwrap'>" + amount + "</div>";
                    }
                },
                { 
                    data: 'email', 
                    name: 'email',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(email){
                        if(email != null) return  "<div id='dvNotes' class='wordwrap'>" + email + "</div>";
                    }
                }, 
                { 
                    data: 'contact', 
                    name: 'contact',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(contact){
                        if(contact != null) return  "<div id='dvNotes' class='wordwrap'>" + contact + "</div>";
                    }
                }, 
                { 
                    data: 'status', 
                    name: 'status',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(status){
                        if(status != null) return  "<div id='dvNotes' class='wordwrap'>" + status + "</div>";
                    }
                }, 
                {data  : "type" },
                {data  : 'created_at'},
                {data  : 'updated_at'},
      
                // { 
                //     data: 'type', 
                //     name: 'type',
                //     "orderable"     : false,
                //     "searchable"    : false,
                //     render:function(type){
                //         if(type != null) return  "<div id='dvNotes' class='wordwrap'>" + type + "</div>";
                //     }
                // }, 
              
            ]
        });
    });


    / Javascript function to search datatable /
    function searchDatatable(columnNumber){
        var query= $('#column_filter_'+columnNumber).val();
        if(Sreq ==  0) {
            dataTable.column(columnNumber).search(query).draw();
        }
    }//end searchDatatable()
</script>

<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
    function openModal(url){
        $('#deletefaqcat').attr('href',url);
        $('#delete_modal').modal();
    } 
    function openblockModal(url,statusName){
        $('#blockfaqcat').attr('href',url);
        $("#blockfaqcat").text(statusName);
        $('#block_modal').modal();
    } 
   
</script>
<script>


</script>

 <script src="{{asset('public/js/jquery.min.js')}}"></script>
 <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
 <script type="text/javascript" src="{{asset('public/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/daterangepicker.css')}}" />
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
<style>
#block_modal{
width: 100%!important;
}
.user_content{
    max-width: 100%;
}
</style>

@endsection  