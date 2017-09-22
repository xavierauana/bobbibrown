<section>
  <h3>Lesson</h3>
	
	<ul class="list-unstyled clearfix">
		<li>
			<h4>Lesson</h4>
			<h4>Passed</h4>
		</li>
		<hr>
		@foreach($user->collections as $collection)
			<li>
				<h5 class="clearfix"><strong>{{$collection->title}}</strong>
					@if($collection->hasTest())
						@if($user->passCollection($collection))
							<span class="label label-success">Passed</span>
						@else
							<span class="label label-warning">Not Yet</span>
						@endif
					@endif
				</h5>
				
				<ul class="list-unstyled lesson-list">
					@foreach($collection->lessons()->ordered()->get() as $lesson)
						<li>
							<p class="clearfix">
								{{$lesson->title}}
								@if($lesson->hasTest())
									@if( $user->passTest($lesson->test))
										<span class="label label-success">Passed</span>
									@else
										<span class="label label-warning">Not Yet</span>
									@endif
								@endif
							</p>
						</li>
					@endforeach
				</ul>
			</li>
			<hr>
		@endforeach
		
	</ul>
</section>

@section("styles")
	@parent
	<style>
		ul {
			margin: 0
		}
		
		ul span {
			float: right;
			margin-right: 1em;
		}
		
		ul.list-unstyled > li:first-child h4 {
			display: inline-block;
		}
		
		ul.list-unstyled > li:first-child h4:last-child {
			float: right;
			margin-right: 1em;
		}
		
		ul.lesson-list {
			margin-left: 15px
		}
	</style>

@endsection