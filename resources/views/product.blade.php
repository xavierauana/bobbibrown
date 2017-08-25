@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$product->name}}</div>
	        <div class="panel-body">
		       {!! $product->content !!}
	        </div>
			<div class="panel-footer">
				<a href="{{route('show.resources')}}" class="btn btn-info btn-sm">Back</a>
			</div>
	    </div>
	</div>
@endsection
