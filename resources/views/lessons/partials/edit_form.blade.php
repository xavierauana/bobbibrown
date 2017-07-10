<form class="form" action="{{route('lessons.update', $lesson->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	<div class="form-group">
		<label>Lesson Title</label>
		<input type="text" name="title" class="form-control" value="{{$lesson->title}}" />
	</div>
	<div class="form-group checkbox {{ $errors->has('is_standalone') ? ' has-error' : '' }}">
		<select name="is_standalone" class="form-control">
			<option value="1" @if($lesson->is_standalone) selected @endif> Can stand alone </option>
			<option value="0" @if(!$lesson->is_standalone) selected @endif> In collection only </option>
		</select>
		
		@if ($errors->has('is_standalone'))
			<span class="help-block">
                <strong>{{ $errors->first('is_standalone') }}</strong>
            </span>
		@endif
	</div>
	<div class="form-group">
		<label>Permission</label>
		<select name="permission_id" class="form-control">
			<option value="">-- Please Select One Permission --</option>
			@foreach($permissions as $permission)
				<option value="{{$permission->id}}"
				        @if($permission->id === $lesson->permission_id) selected @endif>{{$permission->label}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>Content</label>
		<textarea name="body" id="body" class="form-control">{{$lesson->body}}</textarea>
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('lessons.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>