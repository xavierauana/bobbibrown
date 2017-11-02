@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" style="line-height: 36px">
                {{$user->name}} {{$test->title}} records:
            </div>
    
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Result</th>
                        <th>Submission Time</th>
                    </thead>
                    <tbody>
                    @foreach($attempts as $attempt)
	                    <tr>
                            <td>{{$attempt->score * $test->questions->count()}}
	                            / {{$test->questions->count()}}</td>
                            <td>{{$attempt->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
@endsection