@section('styles')
	@parent
	<style href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"></style>
@endsection

<form class="form" action="{{route('events.update', $event->id)}}" method="POST">
	{{csrf_field()}}
	<input type='hidden' name="_method" value="PATCH">
	<div class="form-group">
		<label>Event Title</label>
		<input type="text" name="title" class="form-control" value="{{$event->title}}" />
	</div>
	<div class="form-group">
		<label>Event Description</label>
		<textarea name="body" class="form-control"> {{$event->body}} </textarea>
	</div>
	<div class="form-group">
		<label>Vacancy</label>
		<input type="number" step="1" name="vacancies" class="form-control" value="{{$event->vacancies}}" />
	</div>
		
	<div class="form-group">
		<label>Event Start Date and Time</label>
		<div class='input-group date' id='start_datetime'>
            <input type='text' name="start_datetime" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
	
	<div class="form-group">
		<label>Event End Date and Time</label>
		<div class='input-group date' id='end_datetime'>
            <input type='text' name="end_datetime" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
	</div>
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
    </script>
@endsection
