<html>
	<div style='width:50%; max-width:500px; margin:0 auto; text-align:center'>
		<h1>{{$event->title}}</h1>
		<p>Hello {{$user->name}},</p>
		<p>You can view this event by clicking the following button.</p>
			<a href="{{route("show.event.detail", $event->id)}}"
			   style="display:inline-block; width:40%; background-color:black; color:white;padding:15px">Show Event</a>
	</div>
</html>