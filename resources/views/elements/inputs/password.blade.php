<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{$field}}">{{$label}}</label>
     <input id="{{$field}}" type="password" class="form-control" name="{{$field}}"
            value="{{ isset($value)?$value:old($field) }}"
            @if(isset($required) && $required == true) required @endif
            @if(isset($autofocus) && $autofocus == true) autofocus @endif>
	@if ($errors->has($field))
		<span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
	@endif
</div>