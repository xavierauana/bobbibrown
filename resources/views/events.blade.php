@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{__("Events")}}</div>
	        <div class="panel-body">
	            <user_events_table :initial-events="{{$events}}"></user_events_table>
	        </div>
	    </div>
	</div>
@endsection

