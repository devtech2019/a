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
    'title' => 'All Cleaners Daily Ride ',
    'from' => 'Admin',
    'to' => 'All Cleaners Daily Ride',
  ])
@endsection

@section('content')

    <div class="box-body ">
    <!-- <form id="searchForm" name="searchForm" type="post" >
        <div class="row">
            <div class="col-md-5">
                    <div class="form-group">
                    <label for="cleaner_name">Cleaner Name</label>
                    <div class="input-group displayblock">
                        <input type="text" name="cleaner_name" class="form-control " id="column_filter_0"  onkeyup="searchDatatable(0)" placeholder="Enter Cleaner Name">
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
            <!-- <th>S.No.</th> -->
      
        <th>Name</th>
        <th>Image</th>
        <th>KM</th>
        <th>Date</th>
        <th>Created At</th>
        <th>Updated At</th>
        
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
                { 
                    data: 'cleaner_name', 
                    name: 'cleaner_name',
                    "orderable"     : false,
                    "searchable"    : false,
                    render:function(cleaner_name){
                        if(cleaner_name != null) return  "<div id='dvNotes' class='wordwrap'>" + cleaner_name + "</div>";
                    }
                }, 
                { 
                    data    : 'image',
                    name    : 'image', 
                    render  : function(data){
                        if(data != null){

                            // Calling function
                            // set the path to check
                            var result = checkFileExist("{{config('app.WEBSITE_URL')}}/public/images/"+data);
                            if (result == true) {
                              
                                return  '<img src="{{config('app.url')}}/public/images/'+data+'"  width="100" height="100" class="km-image"/>'
                            } else {
                                return  '<img src="{{config('app.url')}}/public/images/car-speedometer.jpg"  width="100" height="100" class="km-image"/>'
                            }
                        }else{
                            return  '<img src="{{config('app.url')}}/public/images/car-speedometer.jpg"  width="100" height="100" class="km-image"/>'
                        }
                    }
                },
                { 
                    data: 'km', 
                    
                }, 
                { 
                    data: 'date', 
                    
                }, 
                { 
                    data: 'created_at', 
                    
                }, 
                { 
                    data: 'updated_at'
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

    function checkFileExist(urlToFile) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlToFile, false);
        xhr.send();
        
        if (xhr.status == "404") {
            return false;
        } else {
            return true;
        }
    }



</script>
 <script src="{{asset('public/js/jquery.min.js')}}"></script>
 <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/js/datatable_state_storage.js')}}"></script>
<style>
    .crud-content table img{
        border-radius:0%;
    }
</style>

@endsection
