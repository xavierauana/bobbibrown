@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
		        <div class="panel-heading">{{$test->title}}</div>
		        <div class="panel-body test">
			        <test></test>
		        </div>
				<div class="panel-footer">
					<button class="btn btn-info" @click="backWithConfirm(__('Are you sure to give up this test'+!))">{{__("Give up")}}</button>
				</div>
		    </div>
	</div>
@endsection
