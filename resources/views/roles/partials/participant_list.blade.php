<h4>Participants</h4>
<table class="table">
	<thead>
		<th>Name</th>
		<th>Employee ID</th>
		<th>Actions</th>
	</thead>
	<tbody>
	@foreach($participants as $participant)
		<tr>
			<td>{{$participant->name}}</td>
			<td>{{$participant->employee_id}}</td>
			<td>{{$participant->name}}</td>
			<td>
				<button class="btn btn-sm btn-danger">Remove</button>
				<button class="btn btn-sm btn-primary">Reminder</button>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>