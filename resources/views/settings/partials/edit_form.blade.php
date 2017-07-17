<form class="form" action="{{route('settings.update', $setting->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PUT">
	<div class="form-group">
		<label>Label</label>
		<input type="text" name="label" class="form-control" value="{{$setting->label}}" />
	</div>
	<div class="form-group">
		<label>Code</label>
		<input type="text" value="{{$setting->code}}" class="form-control" disabled />
	</div>
	<div class="form-group">
		<label>Value</label>
		<input type="text" step="1" name="value" class="form-control" value="{{$setting->value}}" />
	</div>
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
	</div>
	<div class="form-group">
		<a href="{{route('settings.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>