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
    'title' => 'My Questions ',
    'from' => 'Admin',
    'to' => 'My Questions',
  ])
@endsection

@section('content')
   <div class="box-body">
             <div class="mb-3" role="group" aria-label="Page functionality">
                <a class="btn btn-primary" href="{{ route('faqs.create') }}">
                    <i class="fa fa-fw fa-plus"></i> Create Questions
                </a>
            </div>
    <div class="card <!--card-outline--> card-primary">
        <div class="card-body"> 
            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Question</th>                   
                    <th>Category</th>
                    <th>Totals</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ chunk_split($item->question,10)}}</td>
                        
                        <td>{{chunk_split($item->category['name'],10)}}</td>
                        <td>
                            <span title="Total Reads" data-toggle="tooltip" class="badge badge-info"><i class="fa fa-eye"></i> {{ $item->total_read }}</span>
                            <span title="Helpful Yes" data-toggle="tooltip" class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{ $item->helpful_yes }}</span>
                            <span title="Helpful No" data-toggle="tooltip" class="badge badge-danger"><i class="fa fa-thumbs-down"></i> {{ $item->helpful_no }}</span>
                        </td>
                        <td>{{ $item->updated_at }}</td>
                         <td>
              <!-- edit button -->
              <a href="{{route('faqs.edit', $item->id)}}" class="btn btn-info btn-sm">Edit</a>
                <a href="" type="button" class="btn btn-info btn-sm btn-danger" data-toggle="modal" data-target="#delete_modal{{$item->id}}">Delete</a>

                                    <!-- Social Modal -->
                                    <div id="delete_modal{{$item->id}}" class="delete-modal modal fade" role="dialog">
                                      <div class="modal-dialog modal-sm">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <div class="delete-icon"></div>
                                          </div>
                                          <div class="modal-body text-center">
                                            <h4 class="modal-heading">Are You Sure ?</h4>
                                            <p>Do you really want to delete these faq category?</p>
                                          </div>
                                          <div class="modal-footer">
                                            {!! Form::open(['method' => 'DELETE',  'action' => ['AdminFAQController@destroy', $item->id]]) !!}
                                              {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                              {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
            </td>
                        
                    
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
