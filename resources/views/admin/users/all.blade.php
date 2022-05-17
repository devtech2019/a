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
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                    <div class="form-group">
                    <label for="description">Status</label>
                    <div class="input-group displayblock">
                        <select class="form-control show-tick search_by_status" id="search_by_status" name="search_by_status" >
                            <option value="">Search By Status</option>
                            <option value="2">Pending</option>
                            <option value="1">Started</option>
                            <option value="3">Completed</option>
                            <option value="4">Cancelled</option>
                            <option value="5">Up Coming</option>
                        </select> 
                    </div>
                </div>
            </div>   
            <div class="col-md-5">
                <div class="form-group">
                    <label for="dates">Date Range</label>
                   <div class="input-group displayblock">
                        <input type="text" name="datefilter" class="form-control" value="" id="search_by_date"   placeholder="Search By Date" />
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
      <table id="dataShowTable" class="table table-hover users-table">

        <thead>
          <tr class="info">
            <th width="10%">Customer Name</th>
            <th width="10%">Cleaner Name</th>
            <th width="10%">Vehicle Type</th>
            <th width="10%">Booking Type</th>
            <th width="10%">Washing Plan</th>
            <th width="10%">Status</th>
            <th width="10%">Appoinment Date</th>
            <th width="10%">Time Frame</th>
            <th width="10%">GST</th>
            <th width="10%">Cleaner Earnings</th>
            <th width="20%">Action</th>
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
      
                // {data  : "appoinment_status" },
                

                { 
                    data: 'appoinment_status', 
                    name: 'appoinment_status',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(appoinment_status){
                        console.log(appoinment_status);
                        if(appoinment_status != null) return  '<span class="badge">'+appoinment_status+'</span>'
                    }
                }, 
                
//                 createdRow: function ( row, data, index ) {
    
//     if ( data['appoinment_status'] == 'pending' ) {
//         $('td', row).eq(5).addClass('info');
//     } else {
//         $('td', row).eq(5).addClass('danger');
//     }
   
// }
               
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
                { 
                    data: 'gst', 
                    name: 'gst',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(gst){
                        if(gst != null) return  "<div id='dvNotes' class='wordwrap'>" + gst + "%</div>";
                    }
                },
                { 
                    data: 'cleaner_respective_earnings', 
                    name: 'cleaner_respective_earnings',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(cleaner_respective_earnings){
                        if(cleaner_respective_earnings != null) return  "<div id='dvNotes' class='wordwrap'>" + cleaner_respective_earnings + "</div>";
                    }
                },
                {
                    "data"          : {},
                    "orderable"     : false,
                    "searchable"    : false,
                    "render"        : function(result){
                     
                        var id                  =   (result.id)     ? result.id         : "";
                        var name                =   (result.name)   ? result.name       : "";
                        var adminListUrl        =   "{{$adminListUrl}}";
                       
                        var blockUrl            =   adminListUrl+'/status/'+id;
                        var appointmentDetailUrl    =   adminListUrl+'/view/'+id;
                        
                        var statusName          =   (result.appoinment_status == 'pending')?'Cancel':'';
                      
                        var appoinmentStatus    =   (result.appoinment_status == 'pending')?'show':'hide' ;
                        

                        var dropDownButton      =   ''+

                            '<div class="btn-toolbarr btn-toolbarrmain">'+

                                '<a href="'+adminListUrl+'/'+result.id+'" class="btn common-btn-cs btn-warning btn-sm mr-1 btn-cleaners" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                    ' Payment View' +
                                '</a>'+
                                // '<a href="'+adminListUrl+'/refund/'+result.id+'" class="btn common-btn-cs btn-warning btn-sm mr-1 btn-cleaners" data-toggle="tooltip" title="" data-original-title="Refund to user '+name+'">'+
                                //     ' Refund to User' +
                                // '</a>'+
                                '<a href="'+appointmentDetailUrl+'" class="btn common-btn-cs btn-warning btn-sm mr-1" data-toggle="tooltip btn-cleaners" title="" data-original-title="Edit '+name+'">'+
                                    ' Appointment Detail'+
                                '</a>'+
                                
                                @if (Auth::user()->role == 'A')
                                ((result.appoinment_status == 'pending')?'<a class="btn common-btn-cs btn-sm mr-1 btn-danger btn-cleaners'+appoinmentStatus+'"  id="change" onclick=openblockModal("'+blockUrl+'","Cancel") value="appoinment_status" data-toggle="modal" title="" data-original-title="status '+name+'">'+
                                'Cancel'+
                                '</a>'+
                                '<a href="'+adminListUrl+'/reschedule/'+result.id+'/'+result.cleaner_id+'/'+result.user_id+'" class="btn common-btn-cs btn-info btn-sm mr-1 btn-cleaners" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                    '<i class=""> Rechedule</i>'+
                                '</a>'+
                                '<div id="block_modal" class="block_modal modal fade " role="dialog">'+
                                    '<div class="modal-dialog modal-sm">'+
                                        '<div class="modal-content user_content">'+
                                        '<div class="modal-header">'+
                                            '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                            '<div class="delete-icon"></div>'+
                                        '</div>'+
                                        '<div class="modal-body text-center">'+
                                            '<h4 class="modal-heading">Are You Sure ?</h4>'+
                                            '<p> Do you really want to cancel appointment? </p>'+
                                        '</div>'+
                                        '<div class="modal-footer">'+
                                            '<span  class=" btn btn-gray btn-sm btn-danger mr-1"  data-dismiss="modal" title="reset">'+'No</span>'+
                                            '<a href="#" id="blockfaqcat" class="  btn btn-sm btn-success mr-1"  data-toggle="modal" title="" data-original-title="status '+name+'">'+
                                            'cancel'+
                                            '</a>'+
                                        '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>':"")+ 

                                
                                @endif  
                            '</div>';
                        return dropDownButton;
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


    /**
    * Search by status
    *
    * @param  null
    *
    * @return void
    */
    $(".search_by_status").change(function(){
        //dataTable.draw();
        var val = $(this).val();
        dataTable.column(5).search(val).draw();
    });

    $(function() {
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
              cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            dataTable.column(6).search(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY')).draw();
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });

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




<script type="text/javascript" src="{{asset('public/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/css/daterangepicker.css')}}" />


<style>
    .btn-cleaners {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}
  .btn-toolbarr a {
    display: flex;
    max-width: 165px;
    min-width: 165px;
    text-align: center;
    align-items:center;
    justify-content:center;
}
.btn-toolbarrmain{
    display: block!important;
}
a#blockfaqcat {
    margin-right: 0;
    max-width: initial;
    min-width: auto;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
}

</style>
@endsection  