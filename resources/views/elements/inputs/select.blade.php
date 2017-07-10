<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{$field}}">{{$label}}</label>
	<select id="{{$field}}" name="{{$field}}" class="form-control" required
	        @if(isset($autofocus) && $autofocus == true) autofocus @endif>
		<option value="">-- Please Select One --</option>
		@foreach($options as $option)
			<option value="{{$option->id}}">{{$option->title}}</option>
		@endforeach
	</select>
	
	@if ($errors->has($field))
		<span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
	@endif
</div>