@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => '', 'all_team' => '', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => 'active', 'vehicle_company' => 'active', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'Vehicle Companies',
    'from' => 'Admin',
    'to' => 'Vehicle company',
  ])
@endsection

@section('content')
    <div class="box-body">
          <div class="box-body">
        <a href="{{ route('vehicle_company.create') }}" class="btn btn-default btn-add" data-toggle="modal" data-target="">Create Vehicle Company</a>
      </div>
            
            <form id="searchForm" name="searchForm" type="post" >
                <div class="row">
                    <div class="col-md-5">
                         <div class="form-group">
                            <label for="vehicle_company">Title</label>
                            <div class="input-group displayblock">
                                <input type="text" name="vehicle_company" class="form-control" id="column_filter_0"  onkeyup="searchDatatable(0)" placeholder="Enter title">
                            </div>
                        </div>
                    </div>     
                  <!--   <div class="col-md-5">
                         <div class="form-group">
                            <label for="subject">Subject</label>
                            <div class="input-group displayblock">
                                <input type="text" name="subject" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter subject">                             
                            </div>
                        </div>
                    </div>    -->
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
                      
          <th>Vehicle Company</th>
          <th>Created at</th>
          <th>updated at</th>
          <th>Actions</th>
                      
                    </tr>
                </thead>
            </table>
        </div>
  

<!-- jQuery Library -->
<script type="text/javascript" src="{{asset('public/js/jquery.min1.js')}}"></script>
<script>
    var dataTable = "";
    var Sreq      = 1;
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
                "url"   :   "{{route('vehicle_company.index')}}",

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
                    data: 'vehicle_company', 
                    name: 'vehicle_company',
                    "orderable"     : true,
                    "searchable"    : true,
                    render:function(name){
                        if(name != null) return  "<div id='dvNotes' class='wordwrap'>" + name + "</div>";
                    }
                }, 
               
                { data: 'created_humen' },
                { data: 'updated_humen' },

                {
                    "data"          : {},
                    "orderable"     : false,
                    "searchable"    : false,
                    "render"        : function(result){
                       
                        var id                  =   (result.id)     ? result.id         : "";
                        var name                =   (result.name)   ? result.name       : "";
                        var adminListUrl        =   "{{$adminListUrl}}";
                         var deleteUrl           =   adminListUrl+'/delete-vehicle_company/'+id;
                     
                            if ({data:"role_type"} == 'Cleaner') {
                                '<div class="btn-toolbarr">'+
                                     '<a href="'+adminListUrl+'/view/'+id+'" class="btn btn-primary btn-xs mr-1" data-toggle="tooltip" title="" data-original-title="view '+name+'">'+
                                    '<i class="fa fa-fw fa-eye text-white"></i>'+
                                '</a>'+
                                '</div>';
                            }

                            var dropDownButton      =   ''+

                            '<div class="btn-toolbarr">'+

                                '<a href="'+adminListUrl+'/edit/'+id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                     '<i class="">Edit</i>'+
                                '</a>'+
                                '<span  class="btn btn-sm btn-danger mr-1" onclick=openModal("'+deleteUrl+'") data-toggle="modal" title="" data-original-title="delete '+name+'">'+
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
                                        '<p>Do you really want to delete these vehicle-company?</p>'+
                                      '</div>'+
                                      '<div class="modal-footer">'+
                                        '<span  class="btn btn-gray"  data-dismiss="modal" title="reset">'+'No</span>'+
                                        '<a href="#" id="deleteemailtemp" class="btn btn-sm btn-danger mr-1 myModal"  data-toggle="modal" title="" data-original-title="delete '+name+'">'+
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

    /** Javascript function to search datatable */
    function searchDatatable(columnNumber){
        var query= $('#column_filter_'+columnNumber).val();
        if(Sreq ==  0) {
            dataTable.column(columnNumber).search(query).draw();
             window.location.reload();
        }
    }//end searchDatatable()s    
    function openModal(url){
        $('#deleteemailtemp').attr('href',url);
        $('#delete_modal').modal();
    } 

</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
@endsection
