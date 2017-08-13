<html>
	<div style='width:50%; max-width:500px; margin:0 auto; text-align:center'>
		<h1>Please complete lesson: {{$lesson->title}}</h1>
		<p>Hello {{$user->name}},</p>
		<p>You haven't completed the lesson. So please complete it soon!</p>
		
		@if($lesson->is_standalone)
			<a href="{{route("show.lesson", $lesson->id)}}"
			   style="display:inline-block; width:40%; background-color:black; color:white;padding:15px">Go to Lesson</a>
		@else
            <?php
            $collection = $lesson->collections()->whereIn('permission_id', $user->permissions->pluck('id')->toArray())
                                 ->first();
            ?>
			<a href="{{route("show.collection.lesson", [$collection->id, $lesson->id])}}"
			   style="display:inline-block; width:40%; background-color:black; color:white;padding:15px">Go to Lesson</a>
		@endif
		
	</div>
</html>