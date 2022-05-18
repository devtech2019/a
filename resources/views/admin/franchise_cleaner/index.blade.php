@extends('layouts.admin')

@section('sidebar_active')
  @include('include.sidebar_links', [
    'users' => '', 'all_user' => '', 'create_user' => '',
    'teams' => 'active', 'all_team' => 'active', 'create_team' => '', 'team_task' => '',
    'plan' => '', 'all_plan' => '', 'plan_price' => '',
    'vehicle' => '', 'vehicle_company' => '', 'vehicle_modal' => '', 'vehicle_type' => '',
    'appointments' => '', 'appointment' => '', 'payment' => '', 'payment_mode' => '', 'currency' => '', 'status' => '',
    'settings' => '', 'services' => '', 'gallery' => '', 'facts' => '', 'testimonial' => '', 'blog' => '', 'clients' => '', 'opening_hours' => '', 'company_social' => '',
    'profile' => '', 'sub_appointment' => '',
  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'My Cleaners',
    'from' => 'Admin',
    'to' => 'My Cleaners',
  ])
@endsection

@section('content')
   <div class="box-body">
     
      <div class="box-body">
        <form id="searchForm" name="searchForm" type="post" >
            <div class="row">
                <div class="col-md-3">
                     <div class="form-group">
                        <label for="Name">Name</label>
                        <div class="input-group displayblock">
                            <input type="text" name="name" class="form-control" id="column_filter_0"  onkeyup="searchDatatable(0)" placeholder="Enter name">
                        </div>
                    </div>
                </div>     
                <div class="col-md-3">
                     <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group displayblock">
                            <input type="text" name="email" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter email">                             
                        </div>
                    </div>
                </div> 
                <div class="col-md-3">
                     <div class="form-group">
                        <label for="email">Zip Code</label>
                        <div class="input-group displayblock">
                            <input type="text" name="postal_code" class="form-control" id="column_filter_2"  onkeyup="searchDatatable(2)" placeholder="Enter Zip Code">                             
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
      </div>
      <div class="box-body">
      <table id="dataShowTable" class="row-border hover table table-bordered cb-data-table table-r" cellspacing="0" width="100%">
          <thead>
            <tr>
         <!--      
          <th>Image</th> -->
          <th>Name</th>
          <th>Email</th>
          <th>Zip Code</th>
          <th>Date Of Birth</th>
          <th>Mobile</th>

          <th style="text-align: center;">Action</th>
            </tr>
          </thead>
      </table>
      </div>
  </div>
  <!-- jQuery Library -->
  <script type="text/javascript" src="{{asset('public/js/jquery.min1.js')}}"></script>
  <script>
      var dataTable = "";
      var Sreq      = 1;
      var franchiseCleaners    =   [];
      var franchiseId          =   '';

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
                            franchiseCleaners     =   res.franchiseCleaners;
                            franchiseId           =   res.franchiseId;
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
                    data: {}, 
                    name: 'name',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(result){
                        if(result.user_cleaners && result.user_cleaners.name != null) return  "<div id='dvNotes' class='wordwrap'>" + result.user_cleaners.name + "</div>";
                    }
                }, 
                { 
                    data: {}, 
                    name: 'email',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(result){
                        if(result.user_cleaners && result.user_cleaners.email != null) return  "<div id='dvNotes' class='wordwrap'>" + result.user_cleaners.email + "</div>";
                    }
                },  
                { 
                    data: {}, 
                    name: 'postal_code',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(result){
                        if(result.user_cleaners && result.user_cleaners.postal_code != null){
                          return  "<div id='dvNotes' class='wordwrap'>" + result.user_cleaners.postal_code + "</div>";
                        }else{
                          return  "<div id='dvNotes' class='wordwrap'> N/A </div>";
                        }
                    }
                }, 
               
                { 
                    data: {}, 
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(result){
                        if(result.user_cleaners && result.user_cleaners.dob != null) return  "<div id='dvNotes' class='wordwrap'>" + result.user_cleaners.dob + "</div>";
                    }
                }, 
                { 
                    data: {}, 
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(result){
                        if(result.user_cleaners && result.user_cleaners.mobile != null) return  "<div id='dvNotes' class='wordwrap'>" + result.user_cleaners.mobile + "</div>";
                    }
                }, 


                {
                      "data"          : {},
                      "orderable"     : false,
                      "searchable"    : false,
                      render        : function(result){

                    
                          var name                =   (result.user_cleaners.name)   ? result.user_cleaners.name       : "";
                          var adminUserListUrl    =   "{{route('users.index')}}";
                          var adminListUrl        =   "{{$adminListUrl}}";
                          var baseUrl             =   "{{$baseUrl}}";
                          var CleanersAvailabilityUrl =   "{{$CleanersAvailabilityUrl}}";
                          var deleteUrl           =   adminUserListUrl+'/delete-users/'+result.user_cleaners.id;
                          var adminListUrl        =   "{{$adminListUrl}}";
                          var CleanersDailyUrl        =   "{{$CleanersDailyUrl }}";
                          var CleanersReviewRatingUrl  =   "{{$CleanersReviewRatingUrl}}";
                          var dropDownButton      =   ''+

                          '<div class="btn-toolbarr">'+

                              '<a href="'+adminUserListUrl+'/edit/'+result.user_cleaners.id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="">Edit</i>'+
                              '</a>'+


                              '<a href="'+adminListUrl+'/'+result.user_cleaners.id+'" class="btn btn-warning btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="fa fa-car text-white"></i>'+
                              '</a>'+
                               

                              '<span class="btn btn-sm btn-danger mr-1" onclick=openModal("'+deleteUrl+'") data-toggle="modal" title="" data-original-title="delete '+name+'">'+
                                  '<i class="fa fa-fw fa-trash text-white"></i>'+
                              '</span>'+


                              '<a href="'+baseUrl+'/'+result.user_cleaners.id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                '<i class="">Zip Code</i>'+
                              '</a>'+

                              '<a href="'+CleanersAvailabilityUrl+'/'+result.user_cleaners.id+'" class="btn btn-warning btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                '<i class="">Cleaners Availability</i>'+
                              '</a>'+
                          
                          
                              '<div id="delete_modal" class="delete-modal modal fade" role="dialog">'+
                                '<div class="modal-dialog modal-sm">'+
                                  '<div class="modal-content">'+
                                    '<div class="modal-header">'+
                                      '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                                      '<div class="delete-icon"></div>'+
                                    '</div>'+
                                    '<div class="modal-body text-center">'+
                                      '<h4 class="modal-heading">Are You Sure ?</h4>'+
                                      '<p>Do you really want to delete this cleaner?</p>'+
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
                              '<a href="'+CleanersDailyUrl+result.user_cleaners.id+'" class="btn btn-info btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="">Cleaners Daily Ride</i>'+
                              '</a>'+
                              '<a href="'+CleanersReviewRatingUrl+result.user_cleaners.id+'" class="btn btn-success btn-sm mr-1" data-toggle="tooltip" title="" data-original-title="Edit '+name+'">'+
                                  '<i class="">Review and Rating</i>'+
                              '</a>'+

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
    </script>
    <script>
      function openModal(url){
        $('#deletefaqcat').attr('href',url);
        $('#delete_modal').modal();
      } 
    </script>  
    <script src="{{asset('public/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
@endsection