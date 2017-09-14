<section>
  <h3>Lesson</h3>
	<table class="table">
		<thead>
			<th>Lesson</th>
			<th>Passed</th>
		</thead>
		<tbody>
		 @foreach($user->availableLessons as $lesson)
			 <tr>
				<td>{{$lesson->title}}</td>
				<td>
					@if($user->passTest($lesson->test))
						<span class="label label-success">Passed</span>
					@else
						<span class="label label-warning">Not Yet</span>
					@endif
				</td>
			</tr>
		 @endforeach
		</tbody>
	</table>
</section>