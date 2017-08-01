@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<form method="POST">

		<div class="panel panel-default">
			
	        <div class="panel-heading">My Profile</div>
	        <div class="panel-body">
			        {{csrf_field()}}
		        @include('elements.inputs.text', [
					'label'=>'Name',
					'field'=>'name',
					'value'=>$user->name,
					'required'=>true,
					'autofocus'=>true
				])
		        @include('elements.inputs.text', [
					'label'=>'Email',
					'field'=>'email',
					'value'=>$user->email,
					'required'=>true
				])
		        @include('elements.inputs.password', [
					'label'=>'Password',
					'field'=>'password',
				])
		        @include('elements.inputs.password', [
					'label'=>'Password Confirmation',
					'field'=>'password_confirmation',
				])
		       
	        </div>
			<div class="panel-footer">
					<a class="btn btn-info" href="{{route('home')}}">back</a>
					<button class="btn btn-primary">Update</button>
			</div>
	    </div>
			
		</form>
</div>
@endsection
