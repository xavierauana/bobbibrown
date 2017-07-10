@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$lesson->title}}</div>
	        <div class="panel-body">
	            <div>{!! $lesson->body !!}</div>
	        </div>
			@if($lesson->hasTest())
				<div class="panel-footer clearfix">
					<a class="btn btn-primary pull-right" href="{{route('show.lesson.test', $lesson->id)}}">Test</a>
				</div>
			@endif
	    </div>
	</div>
@endsection
