<form class="form" action="{{route('lines.update', $line->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	@include('elements.inputs.text', [
	'field'=>'name',
	'label'=>'Line Name',
	'required'=>true,
	'autofocus'=>true,
	'value'=>$line->name
	])
	@include('elements.inputs.select', [
	'field'=>'category_id',
	'label'=>'Belong to which Category',
	'options'=>$categories,
	'key' =>"name",
	'required'=>true,
	'value'=>$line->category_id
	])
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('lines.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>