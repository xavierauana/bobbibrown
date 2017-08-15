@if(isset($value))
	<div id="preview-container">
		<img src="{{$value}}" class="img-thumbnail img-responsive">
		<button class="btn btn-danger" onclick="remove{{ucwords($field)}}(event)">Remove Image</button>
	</div>
@endif
<input type='hidden' name="remove_{{$field}}" id="remove_{{$field}}" value="0">
@if ($errors->has("remove_".$field))
	<span class="help-block">
        <strong>{{ $errors->first("remove_".$field) }}</strong>
    </span>
@endif

<div class="form-group">
		<label for="{{$field}}">{{$label}}</label>
		<input type="file" id="{{$field}}" name="{{$field}}" class="form-control">
	@if ($errors->has($field))
		<span class="help-block">
                <strong>{{ $errors->first("poster") }}</strong>
            </span>
	@endif
</div>


@section('scripts')
	@parent
	<script>
		function remove{{ucwords($field)}}(e) {
          e.preventDefault()
          $("#preview-container").hide()
          $("#remove_{{$field}}").val("1")
          console.log(e)
        }
	</script>
@endsection

	