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
    'contactUslist' => 'active'
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Contact-Us-list',
    'from' => 'Admin',
    'to' => 'All Contact-Us-list',
  ])
@endsection
@section('content')   
<div class="box-body">
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-group displayblock">
                        <input type="text" name="name" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter Name">
                    </div>
                </div>
            </div>     
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group displayblock">
                        <input type="text" name="email" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter Email">                             
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
                <th> Name </th>
                <th class="desktop">Email</th>
                <th>Subject</th>
                <th>Message</th>
               
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
                "url"   :   "{{route('contactUsList.index')}}",

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

                { data: 'name' },
                { data: 'email' },
                { 
                    data: 'subject', 
                    name: 'subject',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(subject){
                        if(subject != null) return  "<div id='dvNotes' class='wordwrap'>" + subject + "</div>";
                    }
                }, 
                { 
                    data: 'message', 
                    name: 'message',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(message){
                        if(message != null) return  "<div id='dvNotes' class='wordwrap'>" + message + "</div>";
                    }
                }, 
                // { data: 'subject' },
                // { data: 'message' },
               
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
      function openModal(url){
        $('#deleteemailtemp').attr('href',url);
        $('#delete_modal').modal();
    } 
      function openblockModal(url,statusName){
        $('#blockfaqcat').attr('href',url);
        $("#blockfaqcat").text(statusName);
        $('#block_modal').modal();
    } 
</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>@endsection  