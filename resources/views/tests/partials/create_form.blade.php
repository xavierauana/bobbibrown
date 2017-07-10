<form class="form" action="{{route('tests.store')}}" method="POST">
	{{csrf_field()}}
	<div class="form-group">
		<label>Test Title</label>
		<input type="text" name="title" class="form-control" />
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('tests.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>