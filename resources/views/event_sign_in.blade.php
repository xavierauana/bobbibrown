@extends('layouts.app')

@section('content')
	<div class="container" id="event">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">Sign In</div>
	        <div class="panel-body">
		       <event_sign_in :event="{{$event}}" token="{{$token}}"></event_sign_in>
			</div>
	    </div>
	</div>
@endsection