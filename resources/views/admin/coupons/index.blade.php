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
    'coupon' => 'active','all_coupon'=>'active','create_coupon'=>''
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'My Coupons ',
    'from' => 'Admin',
    'to' => 'My Coupons',
  ])
@endsection

@section('content')

    <div class="box-body ">
    <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                    <div class="form-group">
                    <label for="coupon_code">Coupon Code</label>
                    <div class="input-group displayblock">
                        <input type="text" name="coupon_code" class="form-control " id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter Coupon Code">
                    </div>
                </div>
            </div>     
            <div class="col-md-5">
                    <div class="form-group">
                    <label for="title">Title</label>
                    <div class="input-group displayblock">
                        <input type="text" name="title" class="form-control " id="column_filter_4"  onkeyup="searchDatatable(4)" placeholder="Enter title">                             
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
            <th>S.No.</th>
      
        <th>Applicable for</th>
        <th>Coupon Code</th>
        <th>Coupon Limit</th>
        <th>Title</th>
        <th>Description</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th style=" position: relative;margin-right: 50px">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
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
                "url"   :   "{{route('coupons.index')}}",

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
                    data: 'applicable_for', 
                    name: 'applicable_for',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(applicable_for){
                        if(applicable_for != null) return  '<span class="badge">'+applicable_for+'</span>'
                    }
                }, 
                {data  : 'coupon_code'},
                {data  : 'coupon_limit'},
                { 
                    data: 'title', 
                    name: 'title',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(title){
                        if(title != null) return  "<div id='dvNotes' class='wordwrap'>" + title + "</div>";
                    }
                },
                { 
                    data: 'description', 
                    name: 'description',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(description){
                        if(description != null) return  "<div id='dvNotes' class='wordwrap'>" + description + "</div>";
                    }
                }, 
                {data  : 'start_date'},
                {data  : 'end_date'},
                { 
                    data: 'status', 
                    name: 'status',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(status){
                       
                        if(status != 'I') return  "Active";
                        else  return  "InActive";

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
                        var deleteUrl           =   adminListUrl+'/delete-coupons/'+id;
                        var blockUrl            =   adminListUrl+'/update-coupon-status/'+id;
                        var blockClass          =   (result.status == 'A')?'btn-success':'btn-light';
                        var blockIcon           =   (result.status == 'A')?'fa-unlock':'fa-lock';
                        var dropDownButton      =   ''+

                            '<div class="btn-toolbarr">'+


                            '<span class="btn  btn-sm mr-1 '+blockClass+'"  id="change" onclick=openblockModal("'+blockUrl+'") value="status" data-toggle="modal" title="" data-original-title="is_block '+name+'">'+
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
                                            '<i class="fa fa-fw fa-trash text-white"></i>Yes'+
                                        '</a>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+

                                '<a href="'+adminListUrl+'/edit/'+id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                     '<i class="">Edit</i>'+
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
                                        '<p>Do you really want to delete these coupon?</p>'+
                                      '</div>'+
                                      '<div class="modal-footer">'+
                                        '<span  class="btn btn-gray"  data-dismiss="modal" title="reset">'+'No</span>'+
                                        '<a href="#" id="deletefaqcat" class="btn btn-sm btn-danger mr-1 myModal"  data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                            '<i class="fa fa-fw fa-trash text-white"></i>Yes'+
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
    function openblockModal(url){
        $('#blockfaqcat').attr('href',url);
        $('#block_modal').modal();
    } 
    $(document).ready(function () {
document.getElementById('.myModal').onclick = function(){
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
        },
     function (isConfirm) {
        if (isConfirm) {
            swal("Deleted!", "Your imaginary file has been deleted!", "success");
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    };

});
</script>
 <script src="{{asset('public/js/jquery.min.js')}}"></script>
 <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
@endsection
