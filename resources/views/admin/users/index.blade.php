@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => 'active', 'all_user' => 'active', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All User',
    'from' => 'Admin',
    'to' => 'All Users',
  ])
@endsection
<style>
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<link href="{{asset('css/buttons.dataTables.min.css')}}" rel="stylesheet" />
</style>
@section('content')  
<div class="csvimp">
<a id="export_user"><button class="btn btn-danger" id="export_excel">Export-Excel</button></a>
<a id="export_csv"><button class="btn btn-success" id="export_csv">Export-Csv</button></a>   
</div>

<!-- <a href="{{ URL::to('admin/users/downloadExcel/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>

	<a href="{{ URL::to('admin/users/downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
	<a href="{{ URL::to('admin/users/downloadExcel/csv') }}"><button class="btn btn-success">Download CSV</button></a> -->
    <div class="box-body ">
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-2">
                    <div class="form-group">
                    <label for="title">Name</label>
                    <div class="input-group displayblock">
                        <input type="text" name="name" class="form-control " id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter name">
                    </div>
                </div>
            </div>     
            <div class="col-md-2">
                    <div class="form-group">
                    <label for="description">Email</label>
                    <div class="input-group displayblock">
                        <input type="text" name="email" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter email">                             
                    </div>
                </div>
            </div>   
            <div class="col-md-2">
                    <div class="form-group">
                    <label for="description">Role</label>
                    <div class="input-group displayblock">
                        <select class="form-control show-tick search_by_status" id="role_search" name="role" >
                            <option value="">Search By Role</option>
                            <option value="C">Cleaner</option>
                            <option value="U">Customer</option>
                        </select> 
                    </div>
                </div>
            </div>   
            <div class="col-md-3">
                <div class="form-group">
                    <label for="dates">Date Range</label>
                   <div class="input-group displayblock">
                        <input type="text" name="datefilter" class="form-control" value="" id="column_filter_5"  onkeyup="searchDatatable(5)" placeholder="Enter Date" />
                    </div>
                </div>
            </div> 
            <!--  <div class="col-md-3">
                <div class="form-group">
                    <label for="dates">Unique ID</label>
                   <div class="input-group displayblock">
                        <input type="text" name="id" class="form-control" value="" id="column_filter_7"  onkeyup="searchDatatable(7)" placeholder="Enter Unique ID" />
                    </div>
                </div>
            </div>  -->
                
               
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
    <div class="scroll_table">
      <table id="dataShowTable" class="table table-hover users-table">
        <thead>
          <tr class="info">
            <th width="3%">S.No.</th>
            <th width="20%">Name</th>
            <th width="15%">Email</th>
            <th width="15%">User Type</th>
            <th width="15%">Mobile</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th width="3%">Unique Id</th>
            <th width="15%">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

  </div>
    </div>
 
      
<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .csvimp {
    display: block;
    padding: 7px;
    text-align: right;

}
    </style>
<script>




    


    var dataTable   = "";
    var Sreq        = 1;
    var i           = 1;
    var SITE_PRE_WORD           = "{{Config::get('app.SITE_PRE_WORD')}}";
  
    $(document).ready(function() {
        let roleVal     =   $('#role_search').val();
        dataTable   =    $('#dataShowTable').DataTable({
            // "dom": 'lBrtip',
            // "buttons": [
            //     'csv', 'excel'
            // ],
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
                "url"   :   "{{route('users.index')}}",
                "type"  :   "POST",
                "data"  :   {
                    "sreq"          : Sreq,
                    '_token'        : '{{ csrf_token() }}',
                    "startDate"     : $('#start_date').val(),
                    "endDate"       : $('#end_date').val(),
                    "role_search"   : roleVal,
                },
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
                    data: 'name', 
                    name: 'name',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(name){
                        if(name != null) return  "<div id='dvNotes' class='wordwrap'>" + name + "</div>";
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
                    data: 'role_type', 
                    name: 'role_type',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(role_type){
                        if(role_type != null) return  '<span class="badge">'+role_type+'</span>'
                    }
                }, 
                {data  : 'mobile'},
                {data  : 'created'},
                {data  : 'updated'},
                { 
                    name: "id", 
                    data: "id", 
                    "searchable": false, 
                    "orderable": false,
                    render:function(id){
                        if(id != null) return  '<span class="badge">'+SITE_PRE_WORD+id+'</span>'
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
                        
                        var deleteUrl           =   adminListUrl+'/delete-users/'+id;
                        var blockUrl            =   adminListUrl+'/update-block/'+id;
                        var cleanersAppointmentUrl =   adminListUrl+'/all-cleaner-appoinments/'+id;
                        var CleanersReviewRatingUrl  =   "{{URL::to('/')}}"+"/cleaners_review_rating/";
                        var blockClass          =   (result.is_block == 0)?'btn-success':'btn-light';
                        var blockIcon           =   (result.is_block == 0)?'fa-unlock':'fa-lock';
                        let url                 =   "{{URL::to('/')}}"+"/franchise_cleaner/{{Auth::user()->id}}/"+result.id; 
                        var dropDownButton      =   ''+
                     
                            '<div class="btn-toolbarr">'+


                              '<span class="btn  btn-sm mr-1 '+blockClass+'"  id="change" onclick=openblockModal("'+blockUrl+'") value="is_block" data-toggle="modal" title="" data-original-title="is_block '+name+'">'+
                                     '<i class="fa '+blockIcon+' text-white"></i>'+
                                '</span>'+
                            
                                '<div id="block_modal" class="block_modal modal fade " role="dialog">'+
                                  '<div class="modal-dialog modal-sm">'+
                                    '<div class="modal-content">'+
                                      '<div class="modal-header">'+
                                        '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '<div class="delete-icon"></div>'+
                                      '</div>'+
                                      '<div class="modal-body text-center">'+
                                        '<h4 class="modal-heading">Are You Sure ?</h4>'+
                                        '<p>Do you really want to change status?</p>'+
                                      '</div>'+
                                      '<div class="modal-footer">'+
                                        '<span  class="btn btn-gray btn-sm btn-danger mr-1"  data-dismiss="modal" title="reset">'+'No</span>'+
                                        '<a href="#" id="blockfaqcat" class="btn btn-sm btn-success mr-1"  data-toggle="modal" title="" data-original-title="block '+name+'">'+
                                            'Yes'+
                                        '</a>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                            @if(Auth::user()->role == 'S')
                              '<a href="'+url+'" class="btn btn-warning btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="fa fa-car text-white"></i>'+
                              '</a>'+
                              '<a href="'+CleanersReviewRatingUrl+result.id+'" class="btn btn-success btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="">Review and Rating</i>'+
                              '</a>'+
                               
                             @endif

                             '<a href="'+cleanersAppointmentUrl+'" class="btn btn-warning btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="fa fa-calendar text-white"></i>'+
                              '</a>'+

                                '<a href="'+adminListUrl+'/edit/'+id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                    '<i class="fa fa-fw fa-edit text-white"></i>'+
                                 '</a>'+

                                '<span class="btn btn-sm btn-danger mr-1" onclick=openModal("'+deleteUrl+'") data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                    '<i class="fa fa-fw fa-trash text-white"></i>'+
                                '</span>'+

                                '<div id="delete_modal" class="delete-modal modal fade" role="dialog">'+
                                  '<div class="modal-dialog modal-sm">'+
                                    '<div class="modal-content">'+
                                      '<div class="modal-header">'+
                                        '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                        '<div class="delete-icon"></div>'+
                                      '</div>'+
                                      '<div class="modal-body text-center">'+
                                        '<h4 class="modal-heading">Are You Sure ?</h4>'+
                                        '<p>Do you really want to delete this user?</p>'+
                                      '</div>'+
                                      '<div class="modal-footer">'+
                                        '<span  class="btn btn-gray"  data-dismiss="modal" title="reset">'+'No</span>'+
                                        '<a href="#" id="deletefaqcat" class="btn btn-sm btn-danger mr-1 myModal"  data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                            '<i class="fa fa-fw text-white"></i>Yes'+
                                        '</a>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+
                            '</div>';
                        return dropDownButton;
                    }
                },      
            ]
        });

        // $("#dataShowTable tfoot th").each( function ( i ) {
        //     var select = $('<select><option value=""></option></select>')
        //         .appendTo( $(this).empty() )
        //         .on( 'change', function () {
        //             var val = $(this).val();
        //     alert(val)
        //             dataTable.column( i ).search( val ? '^'+$(this).val()+'$' : val, true, false ).draw();
        //         } );
     
        //     dataTable.column( i ).data().unique().sort().each( function ( d, j ) {
        //         select.append( '<option value="'+d+'">'+d+'</option>' )
        //     } );
        // });
    });


    // Javascript function to search datatable 
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
        dataTable.column(3).search(val).draw();
    });

    // $(".search_by_date").change(function(){
    //     //dataTable.draw();
    //     var val = $(this).val();
    //     dataTable.column(3).search(val).draw();
    // });

    $(function() {

      $('input[name="datefilter"]').daterangepicker({
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Clear'
          }
      });

      $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {

        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        dataTable.column(5).search(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY')).draw();

      });

      $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });

    });


</script>
<script>

$(function() {

$('#search1').daterangepicker({
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
});

$('#search1').on('apply.daterangepicker', function(ev, picker) {
   
    $(this).val(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
    $('#dataShowTable').dataTable().fnClearTable();
    $('#dataShowTable').dataTable().fnDestroy();
     
});

$('#search1').on('cancel.daterangepicker', function(ev, picker) {
   
  $('#date_search').val($(this).val());
  
});

});
    </script>

<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
    function openModal(url){
        $('#deletefaqcat').attr('href',url);
        $('#delete_modal').modal();
    } 
    function openblockModal(url){
        $('#blockfaqcat').attr('href',url);
        $('#block_modal').modal();
    } 
   
</script>
<!-- <script type="text/javascript" charset="utf-8">
        $(function () {
            initSummerNote('.summernote');

            setDateTimePickerRange('#active_from_product', '#active_to_product');
        })

    </script> -->
    <script>
         $('#export_excel').on('click', function () {

    event.preventDefault();
     var formData = $('#export_excel').serialize();

    var  name,email;
   name = $("#column_filter_1").val();
   email = $("#column_filter_2").val();
  
    let url ="{{config('app.WEBSITE_URL')}}/admin/users/export?name="+name+"&email="+email;
  
    window.location = url;
         });
         $('#export_csv').on('click', function () {

event.preventDefault();
 var formData = $('#export_csv').serialize();

var  name,email;
name = $("#column_filter_1").val();
email = $("#column_filter_2").val();

let url ="{{config('app.WEBSITE_URL')}}/admin/users/csv?name="+name+"&email="+email;
window.location = url;
     });
</script>
    <script src="{{asset('public/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/daterangepicker.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/daterangepicker.css')}}" />
    <script type="text/javascript" src="
    https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>  
    <script type="text/javascript" src="
    https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>  
    <script type="text/javascript" src="
    https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>  
    <script type="text/javascript" src="
    https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
    <script type="text/javascript" src="
    https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>  
    <script type="text/javascript" src="
    https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>   

@endsection  
