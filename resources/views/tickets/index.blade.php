@extends('layouts.app')

@section('title', 'All Tickets')

@section('content')
	<div class="row">
		<div class="col-md-10 offset-1">
	        <div class="card">
	        	<div class="card-header">
	        		<i class="fa fa-ticket"> Tickets</i>
	        	</div>

	        	<div class="card-body">
	        		@if ($tickets->isEmpty())
						<p>There are currently no tickets.</p>
	        		@else
		        		<table class="table">
		        			<thead>
		        				<tr>
		        					<th>Category</th>
		        					<th>Title</th>
		        					<th>Status</th>
		        					<th>Last Updated</th>
		        					<th style="text-align:center" colspan="2">Actions</th>
		        				</tr>
		        			</thead>
		        			<tbody>
		        			@foreach ($tickets as $ticket)
								<tr>
		        					<td>
		        					@foreach ($categories as $category)
		        						@if ($category->id === $ticket->category_id)
											{{ $category->name }}
		        						@endif
		        					@endforeach
		        					</td>
		        					<td>
		        						<a href="{{ url('tickets/'. $ticket->ticket_id) }}">
		        							#{{ $ticket->ticket_id }} - {{ $ticket->title }}
		        						</a>
		        					</td>
		        					<td>
		        					@if ($ticket->status === 'Open')
		        						<span class="label label-success">{{ $ticket->status }}</span>
		        					@else
		        						<span class="label label-danger">{{ $ticket->status }}</span>
		        					@endif
		        					</td>
		        					<td>{{ $ticket->updated_at }}</td>
		        					<td>
										<div class="btn-group" role="group" aria-label="Basic example">
											<a href="{{ url('tickets/' . $ticket->ticket_id) }}" class="btn btn-success" title="Comments"><i class="fas fa-comments"></i></a>
											<a href="{{ url('admin/close_ticket/' . $ticket->ticket_id) }}" class="btn btn-danger" title="Close Ticket"><i class="fas fa-times"></i></a>
											<a href="{{ url('admin/update/' . $ticket->ticket_id) }}" class="btn btn-info" title="Update Ticket"><i class="fas fa-pencil-alt"></i></a>
											<a href="{{ url('admin/delete/' . $ticket->ticket_id) }}" class="btn btn-danger" title="Delete Ticket" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i></a>
										</div>
		        					</td>
		        				</tr>
		        			@endforeach
		        			</tbody>
		        		</table>

		        		{{ $tickets->render() }}
		        	@endif
	        	</div>
	        </div>
	    </div>
	</div>
@endsection