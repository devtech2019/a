
@extends('admin.admin')
@section('content')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Auto-Emails</h3>
               
            </div>
            
        
              <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Email To</th>
                        <th class="desktop">Email from</th>
                        <th>Subject</th>
                        <th>Created At</th>
                        <th style="min-width: 100px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->email_to }}</td>
                            <td>{!! $item->email_from!!}</td>
                            <td>{{ $item->subject}}</td>
                            
                            <td>{{ format_date($item->created_at) }}</td>
                            
                              <?php $urlName =    WEBSITE_ADMIN_NAV_URL.$selectedNavigation->url.'/email-logs/'.$item->id?>
                            <td>
                                <div class="btn-toolbarr">

                                    <!--  <a href="{{route('EmailLogs.edit',[$item->id])}}" class="btn btn-primary btn-xs mr-1" data-toggle="tooltip" title="" data-original-title="Edit {{$item->name}}">
                                        <i class="fa fa-fw fa-edit text-white"></i>
                                    </a> -->
                                       <a href="{{route('EmailLogs.delete',[$item->id])}}" class="btn btn-primary btn-xs mr-1" data-toggle="tooltip" title="" data-original-title="Delete {{$item->name}}">
                                        <i class="fa fa-fw fa-trash text-white"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
@section('scripts')
    @parent
    <script type="text/javascript" charset="utf-8">
      

    </script>
@endsection
