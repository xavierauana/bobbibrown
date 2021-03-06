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