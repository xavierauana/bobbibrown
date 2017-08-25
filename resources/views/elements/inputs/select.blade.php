<div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="{{$field}}">{{$label}}</label>
	<select id="{{$field}}" name="{{$field}}" class="form-control"
	        @if(isset($required) && $required === true) required @endif
	        @if(isset($autofocus) && $autofocus === true) autofocus @endif
	        @if(isset($multiple) && $multiple === true) multiple @endif>
		
		@if(!isset($multiple) || $multiple != true)
			<option value="">-- Please Select One --</option>
		@endif
		
		@foreach($options as $option)
			<option value="{{$option->id}}"
			        @if(isset($value))
			            @if(isset($multiple) && $multiple === true)
			                @if(in_array($option->id, $value ))selected @endif
			            @else
			                @if($value === $option->id) selected @endif
						@endif
					@endif>
				@if(isset($key))
					{{$option[$key]}}
				@else
					{{$option->title}}
				@endif
			</option>
		@endforeach
	</select>
	
	@if ($errors->has($field))
		<span class="help-block">
            <strong>{{ $errors->first($field) }}</strong>
        </span>
	@endif
</div>