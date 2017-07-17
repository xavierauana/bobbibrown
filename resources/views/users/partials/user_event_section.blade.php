<section>
  <h3>Registered Events</h3>
	<table class="table">
		<thead>
			<th>Event Name</th>
		</thead>
		<tbody>
		 @foreach($user->events as $event)
			 <tr>
				<td>{{$event->title}}</td>
			</tr>
		 @endforeach
		</tbody>
	</table>
</section>