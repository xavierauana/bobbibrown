<html>
	<div style='width:50%; max-width:500px; margin:0 auto; text-align:center'>
		<h1>Thank for registration</h1>
		<p>Hello {{$user->name}},</p>
		<p>Please confirm your email by clicking the following button.</p>
			<a href="{{route("email.confirmation", [$user->email_token, 'email'=>$user->email])}}"
			   style="display:inline-block; width:40%; background-color:black; color:white;padding:15px">Click</a>
	</div>
</html>