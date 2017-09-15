<form class="form" action="{{route('administrators.update', $administrator->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	@include('elements.inputs.text',
	[
	'label'=>"Name",
	'field'=>'name',
	'value'=>$administrator->name,
	'autofocus'=>true,
	])
	@include('elements.inputs.text',
	[
	'label'=>"Email",
	'field'=>'email',
	'value'=>$administrator->email,
	])
	<div class="form-group{{ $errors->has("role_ids") ? ' has-error' : '' }}">
    <label for="role_ids">Roles</label>
	<select id="role_ids" name="role_ids" class="form-control" required>
		<option value="">-- Please Select One --</option>
		@foreach($roles as $role)
			<option value="{{$role->id}}"
			        @if(in_array($role->id, $administrator->roles->pluck('id')->toArray())) selected @endif>{{$role->label}}</option>
		@endforeach
	</select>
		@if ($errors->has("role_ids"))
			<span class="help-block">
                <strong>{{ $errors->first("role_ids") }}</strong>
            </span>
		@endif
</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('administrators.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>