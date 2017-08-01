<form class="form" action="{{route('tests.update', $test->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	@include("elements.inputs.text", [
		'field'=>'title',
		'label'=>'Test Title',
		'required'=>true,
		'autofocus'=>true,
		'value'=>$test->title
	])
	
	@include("elements.inputs.number", [
		'field'=>'question_number',
		'label'=>'Number of Questions in the Test',
		'required'=>true,
		'step'=>1,
		'value'=>$test->question_number
	])
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('tests.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>