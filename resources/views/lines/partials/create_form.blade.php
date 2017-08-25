<form class="form" action="{{route('lines.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Line Name',
	'required'=>true,
	'autofocus'=>true
	])
	@include('elements.inputs.select', [
	'field'=>'category_id',
	'label'=>'Belong to which Category',
	'options'=>$categories,
	'key' =>"name",
	'required'=>true,
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('lines.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>