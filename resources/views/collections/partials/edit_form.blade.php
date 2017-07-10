<form class="form" action="{{route('collections.update', $collection->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	<div class="form-group">
		<label>Collection Title</label>
		<input type="text" name="title" class="form-control" value="{{$collection->title}}" />
	</div>
	<div class="form-group">
		<label>Collection Description</label>
		<textarea name="body" id="description" class="form-control">{{$collection->description}}</textarea>
	</div>
	<div class="form-group">
		<label>Permission</label>
		<select name="permission_id" class="form-control">
			<option value="">-- Please Select One Permission --</option>
			@foreach($permissions as $permission)
				<option value="{{$permission->id}}"
				        @if($collection->permission_id == $permission->id) selected @endif>{{$permission->label}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('collections.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>