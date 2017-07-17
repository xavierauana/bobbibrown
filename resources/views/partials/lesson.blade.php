<div class="col-sm-3 lesson_wrapper">
	<div class="lesson_item">
		@if(auth()->user()->passTest($lesson->test))
			<span class="text-success text-center check"><i class="fa fa-check fa-2x" aria-hidden="true"></i></span>
		@endif
			
			<a href="{{route("show.lesson", $lesson->id)}}">{{$lesson->title}}</a>
		
	</div>
</div>