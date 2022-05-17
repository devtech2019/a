@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'emaillogs' => 'active','emailManagement' => 'active',
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Email Logs',
    'from' => 'Admin',
    'to' => 'All Email Logs',
  ])
@endsection
@section('content')   
<div class="box-body">
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="email_to">Email to</label>
                    <div class="input-group displayblock">
                        <input type="text" name="email_to" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter Email to">
                    </div>
                </div>
            </div>     
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="email_from">Email from</label>
                    <div class="input-group displayblock">
                        <input type="text" name="email_from" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter Email from">                             
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
    </form>
    <table id="dataShowTable" class="row-border hover table table-bordered cb-data-table table-r" cellspacing="0" width="100%">
        <thead>
            <tr>
                   <th width="3%">S.No.</th>
                <th>Email To</th>
                <th class="desktop">Email from</th>
                <th>Subject</th>
                <th>Mail Sent</th>
            </tr>
        </thead>
    </table>
</div>
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var dataTable = "";
    var Sreq      = 1;
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
            "serverSide"    :   true,
            "order"         :   [[ 0, "desc" ]],
            "sDom"          :   "ltipr",
            "ajax": {
                async   :   true,
                "url"   :   "{{route('EmailLogs.index')}}",

                "type"  :   "POST",
                "data"  :   {"sreq":Sreq,'_token':'{{ csrf_token() }}'},
                beforeSend: function () {
                    Sreq    =   1;
                },
                dataSrc :   function(res){
                    if(res){
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
              { 
                    name: "id", 
                    data: "id", 
                    "searchable": false, 
                    "orderable": false,
                    render:function(data, type, full, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                { data: 'email_to' },
                { data: 'email_from' },
                { data: 'subject' },
                { data: 'mail_sent' },
            ]
        });
    });

    /** Javascript function to search datatable */
    function searchDatatable(columnNumber){
        var query= $('#column_filter_'+columnNumber).val();
        if(Sreq ==  0) {
            dataTable.column(columnNumber).search(query).draw();
        }
    }//end searchDatatable()
</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>@endsection  