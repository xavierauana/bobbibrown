<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{$field}}">{{$label}}</label>
     <textarea id="{{$field}}" class="form-control" name="{{$field}}"
               @if(isset($required) && $required == true) required @endif
               @if(isset($autofocus) && $autofocus == true) autofocus @endif>{{ isset($value)?$value:old($field) }}</textarea>
	@if ($errors->has($field))
		<span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
	@endif
</div>