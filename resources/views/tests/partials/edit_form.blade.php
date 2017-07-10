<form class="form" action="{{route('tests.update', $test->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	<div class="form-group">
		<label>Event Title</label>
		<input type="text" name="title" class="form-control" value="{{$test->title}}" />
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('tests.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>