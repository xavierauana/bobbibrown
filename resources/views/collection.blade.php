@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">Collection - {{$collection->title}}</div>
	        <div class="panel-body">
	            @foreach($collection->lessons as $lesson)
			        @include('partials.collection_lesson')
		        @endforeach
	        </div>
	    </div>
	</div>
@endsection
