<form class="form" action="{{route('tests.store')}}" method="POST">
	{{csrf_field()}}
	
	@include("elements.inputs.text", [
		'field'=>'title',
		'label'=>'Test Title',
		'required'=>true,
		'$autofocus'=>true,
	])
	
	@include("elements.inputs.number", [
		'field'=>'question_number',
		'label'=>'Number of Questions in the Test',
		'required'=>true,
		'step'=>1
	])
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('tests.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>