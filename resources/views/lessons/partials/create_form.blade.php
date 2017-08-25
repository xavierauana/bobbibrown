<form class="form" action="{{route('lessons.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	
	@include('elements.inputs.poster' ,[
		'field'=>'poster',
		'label'=>'Poster'
	])
	
	<div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
		<label>Lesson Title</label>
		<input type="text" name="title" class="form-control" />
		@if ($errors->has('title'))
			<span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group checkbox {{ $errors->has('is_standalone') ? ' has-error' : '' }}">
		<select name="is_standalone" class="form-control">
			<option value="1" selected> Can stand alone </option>
			<option value="0"> In collection only </option>
		</select>
		
		@if ($errors->has('is_standalone'))
			<span class="help-block">
                <strong>{{ $errors->first('is_standalone') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group {{ $errors->has('permission_id') ? ' has-error' : '' }}">
		<label>Permission</label>
		<select name="permission_id" class="form-control">
			<option value="">-- Please Select One Permission --</option>
			@foreach($permissions as $permission)
				<option value="{{$permission->id}}">{{$permission->label}}</option>
			@endforeach
		</select>
		@if ($errors->has('permission_id'))
			<span class="help-block">
                <strong>{{ $errors->first('permission_id') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group {{ $errors->has('schedule.compare') ? ' has-error' : '' }}">
		<label>Deadline Target</label>
		<select name="schedule[compare]" class="form-control">
			<option value="">-- Please Select One Target --</option>
			<option value="lesson">Lesson Creation Date</option>
			<option value="user">User Creation Date</option>
		</select>
		@if ($errors->has('schedule.compare'))
			<span class="help-block">
                <strong>{{ $errors->first('schedule.compare') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group {{ $errors->has('schedule.days') ? ' has-error' : '' }}">
		<label>Deadline days</label>
		<input class="form-control" name="schedule[days]" type="number" step="1" min="0">
		@if ($errors->has('schedule.days'))
			<span class="help-block">
                <strong>{{ $errors->first('schedule.days') }}</strong>
            </span>
		@endif
	</div>
	@include('elements.inputs.checkbox', [
		'label'=>"Is Featured",
		'field'=>"is_featured",
	])
	@include('elements.inputs.checkbox', [
		'label'=>"Is New",
		'field'=>"is_new",
	])
	<div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
		<label>Lesson Content</label>
		<textarea name="body" id="body" class="form-control"></textarea>
		@if ($errors->has('body'))
			<span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('lessons.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>