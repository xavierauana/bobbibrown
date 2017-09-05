@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<form method="POST">

		<div class="panel panel-default">
			
	        <div class="panel-heading">{{__('My Profile')}}</div>
	        <div class="panel-body">
			        {{csrf_field()}}
		        @include('elements.inputs.text', [
					'label'=>__("Name"),
					'field'=>'name',
					'value'=>$user->name,
					'required'=>true,
					'autofocus'=>true
				])
		        @include('elements.inputs.text', [
					'label'=>__("Email Address"),
					'field'=>'email',
					'value'=>$user->email,
					'required'=>true
				])
		        @include('elements.inputs.password', [
					'label'=>__("Password"),
					'field'=>'password',
				])
		        @include('elements.inputs.password', [
					'label'=>__('Password Confirmation'),
					'field'=>'password_confirmation',
				])
		       
	        </div>
			<div class="panel-footer">
					<a class="btn btn-info" href="{{route('home')}}">{{__("Back")}}</a>
					<button class="btn btn-primary">{{__("Update")}}</button>
			</div>
	    </div>
			
		</form>
</div>
@endsection
