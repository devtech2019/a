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
    'title' => 'My Faq Categories',
    'from' => 'Admin',
    'to' => 'My Faq Categories',
  ])
@endsection

@section('content')
	
        <div class="box-body table-responsive">
           
            <table id="tbl-list" data-page-length="25" class="dt-table table table-sm table-bordered table-striped table-hover">
                <thead>
				<tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Created</th>
                    <th>Action</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($items as $item)
					<tr>
                        <td> <span class="faqname"> {{ chunk_split($item->name,10)}} </span></td>
                        <td><span class="faqslug">{{ chunk_split($item->slug,10) }}</span></td>
                        <td>{{ $item->created_at}}</td>
                         <td>
                     <a href="{{route('faqs_categories.edit', $item->id)}}" class="btn btn-info btn-sm">Edit</a>

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
                                            {!! Form::open(['method' => 'DELETE',  'action' => ['AdminCategoriesController@destroy', $item->id]]) !!}
                                              {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                              {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
            </td>  
            <td>
                
            </td> 
          
					</tr>
				@endforeach
				</tbody>
            </table>
        </div>
    </div>
@endsection
