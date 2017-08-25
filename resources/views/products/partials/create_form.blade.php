<form class="form" action="{{route('products.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Prodcut Name',
	'required'=>true,
	'autofocus'=>true
	])
	
	@include('elements.inputs.text', [
	'field'=>'keywords',
	'label'=>'keywords',
	'required'=>true,
	])
	
	@include('elements.inputs.select', [
	'field'=>'line_id[]',
	'label'=>'Belong to which Line',
	'options'=>$lines,
	'key' =>"name",
	'multiple' =>true,
	'required'=>true,
	])
	
	
	@include('elements.inputs.select', [
	'field'=>'permission_id',
	'label'=>'Permission',
	'options'=>$permissions,
	'key' =>"label",
	'required'=>true,
	])
	
	@include('elements.inputs.textarea', [
	'field'=>'content',
	'label'=>'Content',
	'ckeditor'=>true,
	'required'=>true,
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('products.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>