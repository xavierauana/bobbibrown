<form class="form" action="{{route('categories.update', $category->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Category Name',
	'required'=>true,
	'autofocus'=>true,
	'value'=>$category->name
	])
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('categories.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>