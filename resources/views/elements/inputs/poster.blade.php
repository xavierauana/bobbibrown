<div class="form-group">
		<label for={{$field}}>{{$label}}</label>
		<input type="file" id="{{$field}}" name="{{$field}}" class="form-control">
	@if ($errors->has($field))
		<span class="help-block">
            <strong>{{ $errors->first($field) }}</strong>
        </span>
	@endif
</div>