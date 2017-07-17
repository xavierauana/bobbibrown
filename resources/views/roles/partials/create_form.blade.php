<form class="form" action="{{route('roles.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text', [
	'label'=> "Role Label",
	'field'=> "label",
	'autofocus'=>true
	])
	
	@include('elements.inputs.text', [
	'label'=> "Role Code",
	'field'=> "code",
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('roles.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>