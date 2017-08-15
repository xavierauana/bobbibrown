<form class="form" action="{{route('collections.update', $collection->id)}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	
	@include('elements.inputs.poster_edit',[
	'field'=>'poster',
	'label'=>'Poster',
	'value'=>$collection->poster
	])
	
	@include('elements.inputs.text', [
	'label'=>"Collection Title",
	'field'=>"title",
	'autofocus'=>true,
	'value'=>$collection->title
	])
	@include('elements.inputs.textarea', [
	'label'=>"Collection Description",
	'field'=>"description",
	'value'=>$collection->description
	])
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