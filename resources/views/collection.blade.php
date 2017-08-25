@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$collection->title}}</div>
	        <div class="panel-body">
		        <section class="description">
					{!! nl2br($collection->description) !!}
				</section>
		        <br>
		        @foreach($collection->lessons as $index=>$lesson)
			        @include('partials.collection_lesson')
		        @endforeach
	        </div>
			<div class="panel-footer clearfix">
				<a href="/" class="btn btn-sm btn-info pull-right">Back</a>
				@if($collection->hasTest())
					@if(auth()->user()->passTest($collection->test))
						<h5 class="text-success" style="display: inline-block"><i class="fa fa-check" aria-hidden="true"></i> You have pass the Test</h5>
					@else
						<a href="{{route('show.collection.test', $collection->id)}}" class="btn btn-sm btn-primary">Test</a>
					@endif
					
				@endif
				
			</div>
	    </div>
	</div>
@endsection
