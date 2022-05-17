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
    'franchiselist' => 'active'
  ])
@endsection
@section('breadcum')
  @include('include.breadcum', [
    'title' => 'All franchise Request list',
    'from' => 'Admin',
    'to' => 'All franchise Request list',
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
                <th>Contact No</th>
                <th>pincode</th>
                <th>status</th>
                <th>Action</th>
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
                "url"   :   "{{route('franchiselist.index')}}",

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
                { data: 'contact_no' },
                { data: 'pincode' },
                { 
                    data: 'status_type', 
                    name: 'status_type',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(status_type){
                        if(status_type != null) return  '<span class="badge">'+status_type+'</span>'
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
                         var deleteUrl           =   adminListUrl+'/delete-franchise-list/'+id;
                        var statusUrl            =   adminListUrl+'/update-status/'+id;
                        var statusClass          =   (result.status == 1)?'btn-success':'btn-light';
                        var statusIcon           =   (result.status == 1)?'fa-unlock':'fa-lock';
                        var statusName        =       (result.status == 1)?'Reject':'Approve';
                          
                            var dropDownButton      =   ''+

                            '<div class="btn-toolbarr">'+

                              '<span class="btn  btn-sm mr-1 '+statusClass+'"  id="change" onclick=openblockModal("'+statusUrl+'","'+statusName+'") value="is_block" data-toggle="modal" title="" data-original-title="status '+name+'">'+
                                     '<i class="fa '+statusIcon+' '+statusName+' text-white"></i>'+
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
                                        '<a href="#" id="blockfaqcat" class="btn btn-sm btn-success mr-1"  data-toggle="modal" title="" data-original-title="status '+name+'">'
                                            +statusName+
                                        '</a>'+
                                      '</div>'+
                                    '</div>'+
                                  '</div>'+
                                '</div>'+

                                // '<span  class="btn btn-sm btn-danger mr-1" onclick=openModal("'+deleteUrl+'") data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                //     '<i class="fa fa-fw fa-trash text-white"></i>'+
                                // '</span>'+
                            
                                // '<div id="delete_modal" class="delete-modal modal fade" role="dialog">'+
                                //   '<div class="modal-dialog modal-sm">'+
                                //     '<div class="modal-content">'+
                                //       '<div class="modal-header">'+
                                //         '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                //         '<div class="delete-icon"></div>'+
                                //       '</div>'+
                                //       '<div class="modal-body text-center">'+
                                //         '<h4 class="modal-heading">Are You Sure ?</h4>'+
                                //         '<p>Do you really want to delete these franchise request?</p>'+
                                //       '</div>'+
                                //       '<div class="modal-footer">'+
                                //         '<span  class="btn btn-gray"  data-dismiss="modal" title="reset">'+'No</span>'+
                                //         '<a href="#" id="deleteemailtemp" class="btn btn-sm btn-danger mr-1 myModal"  data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                //             '<i class="fa fa-fw fa-trash text-white"></i>Yes'+
                                //         '</a>'+
                                //       '</div>'+
                                //     '</div>'+
                                //   '</div>'+
                                // '</div>'+
                            '</div>';
                        return dropDownButton;
                    }
                },
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