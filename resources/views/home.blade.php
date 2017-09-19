@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-body">
		        @include('partials.new')
		        @include('partials.featured_section')
		        @include('partials.collection_section')
		        @include('partials.lessons_section')
	        </div>
	    </div>
	</div>
@endsection
