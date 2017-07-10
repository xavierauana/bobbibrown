<form class="form" action="{{route('permissions.store')}}" method="POST">
	{{csrf_field()}}
	<div class="form-group">
		<label>Permission Label</label>
		<input type="text" name="label" class="form-control" />
	</div>
	<div class="form-group">
		<label>Permission Code</label>
		<input type="text" name="code" class="form-control" />
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('permissions.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>