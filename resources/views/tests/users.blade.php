@extends("MultiAuth::layouts.admin")

@section("content")
	@if (isset($test))
		<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" style="line-height: 36px">
               Users for Test: {{$test->title}}
            </div>
    
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Pass</th>
                        <th>Number Of Attempts</th>
                        <th>Last Attempt</th>
                        <th>Overdue</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
	                        <tr>
                                <td>{{$user->name}}</td>
                                <td><span class="label
                                    @if($pass = !! $user->passTest($test))
			                                label-success
@else
			                                label-warning
@endif">
                                        @if($pass) Pass @else Not Yet @endif
                                    </span>
                                </td>
                                <td>{{DB::table('attempts')->whereUserId($user->id)->whereTestId($test->id)->count()}}</td>
                                <td>{{($attempt = DB::table('attempts')->whereUserId($user->id)->whereTestId($test->id)->latest()->first())?$attempt->created_at:"" }}</td>
                                <td>
                                    <span class="label
                                    @if($overDue = !! $lesson->isOverDue($user))
		                                    label-warning
@else
		                                    label-success
@endif">
                                        @if($overDue) Overdue @else No @endif
                                    </span>
                                </td>
                                <td>
                                    {{$lesson->dueInDays($user)}}
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm"
                                            data-userId="{{$user->id}}"
                                            onclick="sendReminder(event)"
                                            @if($pass) disabled @endif>Reminder</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
	@else
		<div class="container">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                   There is no test for this lesson
                </div>
            </div>
        </div>
	@endif
@endsection

@section('scripts')
	<script>
        function sendReminder(e) {
          const lessonId = "{{$lesson->id}}",
                userId   = e.target.dataset.userid,
                url      = "/admin/lessons/" + lessonId + "/users/" + userId + "/reminder"
          axios.post(url)
               .then(response => console.log(resposne))
               .catch(({response}) => console.log(response))
        }
    </script>
@endsection
