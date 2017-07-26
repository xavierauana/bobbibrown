@extends('layouts.app')

@section('content')
	<div class="container" id="event">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$event->title}}</div>
	        <div class="panel-body">
		       <event_detail :initial-event="{{$event}}" :user="{{auth()->user()}}"></event_detail>
			</div>
	    </div>
	</div>
@endsection


@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
@endsection
