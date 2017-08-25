<div class="checkbox{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{$field}}">
     <input id="{{$field}}" type="checkbox"
            name="{{$field}}"
            value="1"
            @if(isset($value) && $value == true) checked @endif
            @if(isset($required) && $required === true) required @endif
            @if(isset($autofocus) && $autofocus === true) autofocus @endif>
	    {{$label}}</label>
	@if ($errors->has($field))
		<span class="help-block">
		        <strong>{{ $errors->first($field) }}</strong>
		    </span>
	@endif
</div>