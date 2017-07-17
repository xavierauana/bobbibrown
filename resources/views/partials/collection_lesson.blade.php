<div class="collection_lesson col-xs-12">
	<div class="col-sm-2 hidden-xs index text-center">
		@if(auth()->user()->passTest($lesson->test))
			<a href="{{route('show.collection.lesson', [$collection->id, $lesson->id])}}">			<span
						class="text-success text-center check"><i class="fa fa-check"
			                                                      aria-hidden="true"></i></span>
</a>
		@else
			<a href="{{route('show.collection.lesson', [$collection->id, $lesson->id])}}">{{$index + 1}}</a>
		@endif
		
	</div>
	<div class="col-sm-10">
			@if(auth()->user()->passTest($lesson->test))
				<span class="text-success text-center check visible-xs"><i class="fa fa-check" aria-hidden="true"></i></span>
			@endif
		
		<a href="{{route('show.collection.lesson', [$collection->id, $lesson->id])}}">{{$lesson->title}}</a>
	</div>
</div>