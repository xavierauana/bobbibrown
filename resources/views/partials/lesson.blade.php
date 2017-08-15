<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 lesson_wrapper">
	<a href="{{route("show.lesson", $lesson->id)}}">
		<div class="lesson_item" style="background-image:url('{{$lesson->poster}}')">
			@if(auth()->user()->passTest($lesson->test))
				<span class="text-success text-center check"><i class="fa fa-check fa-2x" aria-hidden="true"></i></span>
			@endif
			
		</div>
		<span class="title">{{$lesson->title}}</span>
	</a>
</div>