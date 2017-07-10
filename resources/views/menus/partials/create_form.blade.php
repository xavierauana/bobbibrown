<form class="form" action="{{route('menus.store')}}" method="POST">
	{{csrf_field()}}
	
	@include('elements.inputs.text',['label'=>'Menu Title', 'field'=>'title', 'autofocus'=>true])
	
	@include('elements.inputs.text',['label'=>'Menu Url', 'field'=>'url'])
	
	<div class="form-group{{ $errors->has("collection_lesson") ? ' has-error' : '' }}">
	    <label for="collection_lesson">Map To</label>
		<select id="collection_lesson" name="collection_lesson" class="form-control" required
		        @if(isset($autofocus) && $autofocus == true) autofocus @endif>
			<option value="">-- Please Select One --</option>
			@foreach($options as $option)
				<option value="{{get_class($option)."_".$option->id}}">{{$option->title}}</option>
			@endforeach
		</select>
			
			@if ($errors->has("collection_lesson"))
				<span class="help-block">
	                <strong>{{ $errors->first("collection_lesson") }}</strong>
	            </span>
			@endif
	</div>
	
	<div class="form-group">
		<label name="is_active">
			<input type="checkbox" checked name="is_active" value="1"> Is Active
		</label>
	</div>
	
	
	
	<div class="form-group">
	<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
	<a href="{{route('menus.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>