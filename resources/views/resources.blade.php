@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">Resources</div>
	        <div class="panel-body">
		       <resources_table :initial-categories="{{$categories}}"></resources_table>
	        </div>
	    </div>
	</div>
@endsection
