<form class="form" action="{{route('events.store')}}" method="POST"
      enctype="multipart/form-data">
	{{csrf_field()}}
	
	<div class="form-group">
		<label for="photo">Photo</label>
		<input type="file" id="photo" name="photo" class="form-control">
		@if ($errors->has("photo"))
			<span class="help-block">
                <strong>{{ $errors->first("photo") }}</strong>
            </span>
		@endif
	</div>
	
	@include('elements.inputs.text',[
	'field'=>'title',
	'label'=>'Event Name',
	'required'=>true,
	'autofocus'=>true,
	])
	
	@include('elements.inputs.select',[
	'field'=>'permission_id',
	'label'=>'Permission',
	'options'=>$permissions,
	'key'=>"label",
	'required'=>true,
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
            <input type='text' name="start_datetime" class="form-control"
                   required />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	
	<div class="form-group">
		<label>Event End Date and Time</label>
		<div class='input-group date' id='end_datetime'>
            <input type='text' name="end_datetime" class="form-control"
                   required />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Create">
	</div>
	<div class="form-group">
		<a href="{{route('events.index')}}" class="btn btn-block btn-primary">Back</a>
	</div>
</form>



@section('scripts')
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	
	<script>
        $('#start_datetime').datetimepicker({
                                              format: "lll"
                                            });
        $('#end_datetime').datetimepicker({
                                            format    : "lll",
                                            useCurrent: false //Important! See issue #1075
                                          });
        $("#start_datetime").on("dp.change", function (e) {
          $('#end_datetime').data("DateTimePicker").minDate(e.date);
        });
        $("#end_datetime").on("dp.change", function (e) {
          $('#start_datetime').data("DateTimePicker").maxDate(e.date);
        });

        function removePhoto(e) {
          e.preventDefault()
          $("#preview-container").hide()
          $("#remove_photo").val("1")
          console.log(e)
        }
    </script>
@endsection