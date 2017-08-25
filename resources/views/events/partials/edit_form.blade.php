@section('styles')
	@parent
	<style href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"></style>
@endsection

<form class="form" action="{{route('events.update', $event->id)}}" method="POST" enctype="multipart/form-data">
	
	{{csrf_field()}}
	<input hidden name="_method" value="PATCH">
	@if($event->photo)
		<div id="preview-container">
			<img src="{{$event->photo}}" class="img-thumbnail img-responsive">
			<button class="btn btn-danger" onclick="removePhoto(event)">Remove Image</button>
		</div>
	@endif
	<input type='hidden' name="remove_photo" id="remove_photo" value="0">
	@if ($errors->has("remove_photo"))
		<span class="help-block">
                <strong>{{ $errors->first("remove_photo") }}</strong>
            </span>
	@endif
	
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
	'value'=>$event->title
	])
	@include('elements.inputs.text',[
	'field'=>'venue',
	'label'=>'Venue',
	'required'=>true,
	'value'=>$event->venue
	])
	@include('elements.inputs.textarea',[
	'field'=>'body',
	'label'=>'Description',
	'required'=>true,
	'value'=>$event->body
	])
	
	@include('elements.inputs.number',[
	'field'=>'vacancies',
	'label'=>'Vacancy',
	'step'=>1,
	'required'=>true,
	'value'=>$event->vacancies
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
	
	@include('elements.inputs.select',[
	'field'=>'permission_id',
	'label'=>'Permission',
	'options'=>$permissions,
	'value'=>$event->permission_id,
	'key'=>'label',
	'required'=>true,
	])
	
	<div class="form-group">
		<input type="submit" class="btn btn-success btn-block" value="Update">
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
        var startDateTime = moment("{{$event->start_datetime}}", "YYYY-MM-DD hh:mm:ss")
        var endDateTime = moment("{{$event->end_datetime}}", "YYYY-MM-DD hh:mm:ss")
        $('#start_datetime').datetimepicker({
                                              defaultDate: startDateTime,
                                              format     : "lll"
                                            });
        $('#end_datetime').datetimepicker({
                                            format     : "lll",
                                            defaultDate: endDateTime,
                                            useCurrent : false //Important! See issue #1075
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
