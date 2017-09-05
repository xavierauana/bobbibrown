@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		
		<div class="panel panel-default">
			
	        <div class="panel-heading">{{__("My Progress")}}</div>
	        <div class="panel-body">
		       <my_progress  :initial-collections="{{$collections}}" :lessons-status="{{$lessonsStatus}}"></my_progress>
	        </div>
			<div class="panel-footer">
				<a href="/" class="btn btn-sm btn-info">Back</a>
			</div>
	    </div>
		
</div>
@endsection
