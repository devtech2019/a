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
    'faq' => 'active','all_faq'=>'active','all_faq_cat'=>'','all_faq_cat_create'=>'','cms'=> 'active',

  ])
@endsection

@section('breadcum')
  @include('include.breadcum', [
    'title' => 'My Faq',
    'from' => 'Admin',
    'to' => 'My Faq',
  ])
@endsection

@section('content')   
    
        <div class="box-body"> 

            <div class="box-body">
        <a href="{{route('faqs.create') }}" class="btn btn-default btn-add" data-toggle="modal" data-target="">Create Questions</a>
      </div>    
            <form id="searchForm" name="searchForm" type="post" >
                <div class="row">
                    <div class="col-md-5">
                         <div class="form-group">
                            <label for="question">Question</label>
                            <div class="input-group displayblock">
                                <input type="text" name="question" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter question">
                            </div>
                        </div>
                    </div>     
                  <!--   <div class="col-md-5">
                         <div class="form-group">
                            <label for="category_id">category</label>
                            <div class="input-group displayblock">
                                <input type="text" name="category_id" class="form-control" id="column_filter_1"  onkeyup="searchDatatable(1)" placeholder="Enter category">                             
                            </div>
                        </div>
                    </div>   --> 
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
                        <th>Question</th>                   
                    <th>Category</th>
                    <th>Created at</th>
                    <th>Action</th>
                      
                    </tr>
                </thead>
            </table>
        </div>
  
<script type="text/javascript" src="{{asset('public/js/jquery.min1.js')}}"></script>

<!-- jQuery Library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
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
                "url"   :   "{{route('faqs.index')}}",

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
                    data: 'question', 
                    name: 'question',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(question){
                        if(question != null) return  "<div id='dvNotes' class='wordwrap'>" + question + "</div>";
                    }
                }, 
                // {data  : 'question' },
                { 
                    data: 'category', 
                    name: 'category',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(category){
                         if(category != null) return  "<div id='dvNotes' class='wordwrap'>" +  category['name']+"</div>";    
                    }
                },
                
              
               
                //   {
                //     "data"          :   "slug",
                //     "name"          :   "slug",
                //     "orderable"     :  true,
                //     "searchable"    :   true,
                //     "render"        :   function(is_active){
                //         return is_active;
                //     }
                // }, 
               
                { data: 'created_humen' },

                {
                    "data"          : {},
                    "orderable"     : false,
                    "searchable"    : false,
                    "render"        : function(result){
                       
                        var id                  =   (result.id)     ? result.id         : "";
                        var name                =   (result.name)   ? result.name       : "";
                        var adminListUrl        =   "{{$adminListUrl}}";
                        var deleteUrl           =   adminListUrl+'/delete-faq/'+id;
                        var dropDownButton      =   ''+

                            '<div class="btn-toolbarr">'+

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
                                        '<p>Do you really want to delete these faqs?</p>'+
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

    /** Javascript function to search datatable */
    function searchDatatable(columnNumber){
        var query= $('#column_filter_'+columnNumber).val();
        if(Sreq ==  0) {
            dataTable.column(columnNumber).search(query).draw();
             window.location.reload();
        }
    }//end searchDatatable()

    function openModal(url){
        $('#deletefaqcat').attr('href',url);
        $('#delete_modal').modal();
    } 


</script>
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
@endsection  