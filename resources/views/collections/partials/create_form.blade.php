<form class="form" action="{{route('collections.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	
	@include('elements.inputs.poster' ,[
		'field'=>'poster',
		'label'=>'Poster'
	])
	
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
	
	@include('elements.inputs.checkbox', [
		'label'=>"Is Featured",
		'field'=>"is_featured",
	])
	@include('elements.inputs.checkbox', [
		'label'=>"Is New",
		'field'=>"is_new",
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('collections.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>