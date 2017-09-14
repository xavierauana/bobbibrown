<form class="form" action="{{route('administrators.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	
	@include('elements.inputs.text',[
	'field'=>'title',
	'label'=>'Event Name',
	'required'=>true,
	'autofocus'=>true,
	])
	@include('elements.inputs.text',[
	'field'=>'venue',
	'label'=>'Venue',
	'required'=>true,
	])
	@include('elements.inputs.textarea',[
	'field'=>'body',
	'label'=>'Description',
	'required'=>true,
	])
	
	@include('elements.inputs.number',[
	'field'=>'vacancies',
	'label'=>'Vacancy',
	'step'=>1,
	'required'=>true,
	])
	<div class="form-group">
		<label>Event Start Date and Time</label>
		<div class='input-group date' id='start_datetime'>
            <input type='text' name="start_datetime" class="form-control" required />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	
	<div class="form-group">
		<label>Event End Date and Time</label>
		<div class='input-group date' id='end_datetime'>
            <input type='text' name="end_datetime" class="form-control" required />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('administrators.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>