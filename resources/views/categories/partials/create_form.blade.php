<form class="form" action="{{route('categories.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Category Name',
	'required'=>true,
	'autofocus'=>true
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('categories.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>