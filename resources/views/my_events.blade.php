@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		
		<div class="panel panel-default">
			
	        <div class="panel-heading">My Class</div>
	        <div class="panel-body">
		       <my_events :initial-events="{{$events}}"></my_events>
	        </div>
			<div class="panel-footer">
				<a href="/" class="btn btn-sm btn-info">Back</a>
			</div>
	    </div>
		
</div>
@endsection
