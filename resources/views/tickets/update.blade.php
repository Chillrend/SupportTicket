@extends('layouts.app')

@section('title', 'Open Ticket')

@section('content')
	<div class="row">
		<div class="col-md-10 offset-1">
	        <div class="card">
	            <div class="card-header">Update ticket #{{$ticket->ticket_id}}</div>

	            <div class="card-body">
                    @include('includes.flash')

	                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/admin/update/do/' . $ticket->ticket_id) }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $ticket->title }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">Category</label>

                            <div class="col-md-6">
                                <select id="category" type="category" class="form-control" name="category">
                                	<option value="">Select Category</option>
                                	@foreach ($categories as $cat)
										<option value="{{ $cat->id }}" @if($cat->id == $ticket->category_id) selected @endif >{{ $cat->name }}</option>
                                	@endforeach
                                </select>

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
                            <label for="priority" class="col-md-4 control-label">Priority</label>

                            <div class="col-md-6">
                                <select id="priority" type="" class="form-control" name="priority">
                                	<option value="">Select Priority</option>
                                	<option value="low" @if($ticket->priority == "low") selected @endif>Low</option>
                                	<option value="medium" @if($ticket->priority == "medium") selected @endif>Medium</option>
                                	<option value="high" @if($ticket->priority == "high") selected @endif>High</option>
                                </select>

                                @if ($errors->has('priority'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('priority') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                            <label for="picture" class="col-md-4 control-label">Insert a picture</label>

                            <div class="col-md-6">
                                <input type="file" id="picture" class="picture" name="picture" accept="image/*" />

                                @if ($errors->has('picture'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('picture') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                            <label for="message" class="col-md-4 control-label">Message</label>

                            <div class="col-md-6">
                                <textarea rows="10" id="message" class="form-control" name="message">{{$ticket->message}}</textarea>

                                @if ($errors->has('message'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('message') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-ticket"></i> Update Ticket
                                </button>
                            </div>
                        </div>
                    </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection