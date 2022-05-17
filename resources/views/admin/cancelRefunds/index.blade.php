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
    'cancel_refunds' => 'active'
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Refund List',
    'from' => 'Admin',
    'to' => 'All Refund List',
  ])
@endsection
@section('content')   
<div class="box-body">
    <!-- <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="name">Refund Id</label>
                    <div class="input-group displayblock">
                        <input type="text" name="refund_id" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter Refund Id">
                    </div>
                </div>
            </div>     
            <div class="col-md-5">
                 <div class="form-group">
                    <label for="email">Payment Id</label>
                    <div class="input-group displayblock">
                        <input type="text" name="payment_id" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter Payment Id">                             
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
    <table id="dataShowTable" class="row-border hover table table-bordered cb-data-table table-r" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="3%">S.No.</th>
                <th>Cleaner Name</th>
                <th>User Name</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Entity</th>
                <th>Payment Id</th>
                <th>Refund Id</th>
                <th>Status</th>
                <th>Created</th>
                <th>Updated</th>
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
                "url"   :   "{{route('cancelRefundsList.index')}}",

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
                { 

                    "data"          : {},
                    "orderable"     : false,
                    "searchable"    : false,
                    "render"        : function(result){
                        return result && result.cleaner_details && result.cleaner_details.name? result.cleaner_details.name :"N/A";
                    }
                }, 
                { 

                    "data"          : {},
                    "orderable"     : false,
                    "searchable"    : false,
                    "render"        : function(result){
                        return result && result.user_details && result.user_details.name ? result.user_details.name :"N/A";
                    }
                }, 
                
                { data  : 'amount' },
                { data  : 'currency' },
                { data  : 'entity' },
                { data  : 'payment_id' },
                { data  : 'refund_id' },
                { data  : 'status' },
                { data  : 'created_at'},
                { data  : 'updated_at'},
               
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