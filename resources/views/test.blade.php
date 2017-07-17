@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
		        <div class="panel-heading">{{$test->title}}</div>
		        <div class="panel-body test">
			        <test></test>
		        </div>
		    </div>
	</div>
@endsection
