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