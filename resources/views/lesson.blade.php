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
				@if(auth()->user()->passTest($lesson->test))
					<div class="panel-footer clearfix text-success">
						<h5><i class="fa fa-check" aria-hidden="true"></i> You have pass the Test</h5>
					</div>
				@else
					<div class="panel-footer clearfix">
						<a class="btn btn-primary pull-right" href="{{route('show.lesson.test', $lesson->id)}}">Test</a>
					</div>
				@endif
			@endif
	    </div>
	</div>
@endsection
