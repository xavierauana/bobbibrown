<form class="form" action="{{route('collections.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text', [
	'label'=>"Collection Title",
	'field'=>"title",
	'autofocus'=>true
	])
	@include('elements.inputs.textarea', [
	'label'=>"Collection Description",
	'field'=>"description",
	])
	
	<div class="form-group">
		<label>Permission</label>
		<select name="permission_id" class="form-control">
			<option value="">-- Please Select One Permission --</option>
			@foreach($permissions as $permission)
				<option value="{{$permission->id}}">{{$permission->label}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('collections.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>