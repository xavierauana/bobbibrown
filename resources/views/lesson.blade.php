@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$lesson->title}}</div>
	        <div class="panel-body">
	            <div>{!! $lesson->body !!}</div>
	        </div>
			<div class="panel-footer clearfix">
				@if($lesson->hasTest())
					@if(auth()->user()->passTest($lesson->test))
						<h5 class="text-success" style="display: inline-block"><i class="fa fa-check"
						                                                          aria-hidden="true"></i> You have pass the Test</h5>
					@else
						<a class="btn btn-primary pull-right" href="{{route('show.lesson.test', $lesson->id)}}">Test</a>
					@endif
				@endif
				<button class="btn btn-sm btn-info pull-right" @click="back">Back</button>
			</div>
	    </div>
	</div>
@endsection
