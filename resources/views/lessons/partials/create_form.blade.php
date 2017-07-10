<form class="form" action="{{route('lessons.store')}}" method="POST">
	{{csrf_field()}}
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
	<div class="form-group {{ $errors->has('permission') ? ' has-error' : '' }}">
		<label>Permission</label>
		<select name="permission" class="form-control">
			<option value="">-- Please Select One Permission --</option>
			@foreach($permissions as $permission)
				<option value="{{$permission->id}}">{{$permission->label}}</option>
			@endforeach
		</select>
		@if ($errors->has('permission'))
			<span class="help-block">
                <strong>{{ $errors->first('permission') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group {{ $errors->has('content') ? ' has-error' : '' }}">
		<label>Lesson Content</label>
		<textarea name="content" id="content" class="form-control"></textarea>
		@if ($errors->has('content'))
			<span class="help-block">
                <strong>{{ $errors->first('content') }}</strong>
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