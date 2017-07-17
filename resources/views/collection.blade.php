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
	    </div>
	</div>
@endsection
