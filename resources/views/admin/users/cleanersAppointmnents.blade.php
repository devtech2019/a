@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => 'active', 'appointment' => 'active', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
    'cleanersBookings' => '', 'all_bookings' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All Appoinments',
    'from' => 'Admin',
    'to' => 'All Appoinments',
  ])
@endsection

@section('content')   

    <div class="box-body ">
    <!-- <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
        <div class="col-md-5">
                    <div class="form-group">
                    <label for="description">Vehicle type</label>
                    <div class="input-group displayblock">
                        <input type="text" name="vehicle_type" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter vehicle type">                             
                    </div>
                </div>
            </div>   
            <div class="col-md-5">
                    <div class="form-group">
                    <label for="description">Washing plan</label>
                    <div class="input-group displayblock">
                        <input type="text" name="name" class="form-control" id="column_filter_4"  onkeyup="searchDatatable(4)" placeholder="Enter Washing Plan">                             
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
      <table id="dataShowTable" class="table table-hover users-table">

        <thead>
          <tr class="info">
            <th width="10%">User name</th>
            <th width="10%">Cleaner name</th>
            <th width="10%">Vehicle type</th>
            <th width="10%">Booking type</th>
            <th width="10%">Washing plan</th>
            <th width="10%">Status</th>
            <th width="10%">Appoinment date</th>
            <th width="10%">Time frame</th>
            
          </tr>
      
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
 
      
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
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
            "serverSide"    :   true,
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

                {data  : "user_name" },
                {data  : "cleaner_name" },
                {data  : "vehicle_type"},
                {data  : "booking_type"},
               
                {data  : "name"},
      
                {data  : "appoinment_status" },
               
                { 
                    data: 'appointment_date', 
                    name: 'appointment_date',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(appointment_date){
                        if(appointment_date != null) return  "<div id='dvNotes' class='wordwrap'>" + appointment_date + "</div>";
                    }
                }, 
                { 
                    data: 'time_frame', 
                    name: 'time_frame',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(time_frame){
                        if(time_frame != null) return  "<div id='dvNotes' class='wordwrap'>" + time_frame + "</div>";
                    }
                },
               
              
            ]
        });
    });


    // Javascript function to search datatable //
    function searchDatatable(columnNumber){
        var query= $('#column_filter_'+columnNumber).val();
        if(Sreq ==  0) {
            dataTable.column(columnNumber).search(query).draw();
        }
    }//end searchDatatable()
</script>
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
   
    function openblockModal(url,statusName){
        $('#blockfaqcat').attr('href',url);
        $("#blockfaqcat").text(statusName);
        $('#block_modal').modal();
    } 
   
</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>


@endsection  