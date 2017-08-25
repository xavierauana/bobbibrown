<form class="form" action="{{route('products.update', $product->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Prodcut Name',
	'required'=>true,
	'autofocus'=>true,
	'value'=>$product->name
	])
	
	@include('elements.inputs.text', [
	'field'=>'keywords',
	'label'=>'keywords',
	'required'=>true,
	'value'=>$product->keywords
	])
	
	@include('elements.inputs.select', [
	'field'=>'line_id[]',
	'label'=>'Belong to which Line',
	'options'=>$lines,
	'key' =>"name",
	'multiple' =>true,
	'required'=>true,
	'value'=>$product->lines->pluck('id')->toArray()
	])
	
	
	@include('elements.inputs.select', [
	'field'=>'permission_id',
	'label'=>'Permission',
	'options'=>$permissions,
	'key' =>"label",
	'required'=>true,
	'value'=>$product->permission_id
	])
	
	@include('elements.inputs.textarea', [
	'field'=>'content',
	'label'=>'Content',
	'required'=>true,
	'ckeditor'=>true,
	'value'=>$product->content
	])
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('products.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>