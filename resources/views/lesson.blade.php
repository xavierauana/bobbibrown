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
						<h5 class="text-success"
						    style="display: inline-block"><i class="fa fa-check"
						                                     aria-hidden="true"></i>{{_("You have pass the Test")}} </h5>
					@else
						<a class="btn btn-primary pull-right"
						   href="{{route('show.lesson.test', $lesson->id)}}">{{__("Test")}}</a>
					@endif
				@endif
				<button class="btn btn-info pull-right" @click="back"
				        style="margin-right:15px">{{__("Back")}}</button>
			</div>
	    </div>
	</div>
@endsection
@section('scripts')
	<script>
        _.forEach(document.getElementsByTagName('video'), function (player) {
          player.setAttribute("height", "auto")
          player.setAttribute("width", "100%")
        })
	</script>
@endsection