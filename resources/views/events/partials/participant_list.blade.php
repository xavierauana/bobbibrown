<h4>Participants</h4>
<table class="table">
	<thead>
		<th>Name</th>
		<th>Employee ID</th>
		<th>Sign In</th>
		<th>Actions</th>
	</thead>
	<tbody>
	@foreach($participants as $participant)
		<tr>
			<td>{{$participant->name}}</td>
			<td>{{$participant->employee_id}}</td>
			<td>{{$participant->showEventSingInTimestamp($event)}}</td>
			<td>
				<form action="{{route('events.participants.remove', [$event->id, $participant->id])}}"
				      method="post"
				style="display: inline-block">
					{{csrf_field()}}
					<input type="submit" value="Remove"
					       class="btn btn-sm btn-danger">
				</form>
				<button class="btn btn-sm btn-primary">Reminder</button>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>