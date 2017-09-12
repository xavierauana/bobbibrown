<form class="form" action="{{route('permissions.update', $permission->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	<div class="form-group">
		<label>Permission Label</label>
		<input type="text" name="label" class="form-control" value="{{$permission->label}}" />
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('permissions.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>