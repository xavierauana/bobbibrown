<form class="form" action="{{route('users.update', $user->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	@include('elements.inputs.text',
	[
	'label'=>"Name",
	'field'=>'name',
	'value'=>$user->name,
	'autofocus'=>true,
	])
	@include('elements.inputs.text',
	[
	'label'=>"Email",
	'field'=>'email',
	'value'=>$user->email,
	])
	@include('elements.inputs.text',
	[
	'label'=>"Employee Id",
	'field'=>'employee_id',
	'value'=>$user->employee_id,
	])
	<div class="form-group{{ $errors->has("role_ids") ? ' has-error' : '' }}">
    <label for="role_ids">Roles</label>
	<select id="role_ids" name="role_ids" class="form-control" required>
		<option value="">-- Please Select One --</option>
		@foreach($user->roles as $role)
			<option value="{{$role->id}}"
			        @if(in_array($role->id, $user->roles->pluck('id')->toArray())) selected @endif>{{$role->label}}</option>
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
		<a href="{{route('users.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>