@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">Dashboard</div>
	        <div class="panel-body">
	            @include('partials.collection_section')
	            @include('partials.lessons_section')
	        </div>
	    </div>
</div>
@endsection
