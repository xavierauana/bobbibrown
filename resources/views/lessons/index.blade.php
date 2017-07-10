@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Lessons
	                @if(auth('admin')->user()->hasPermission('createLesson'))
		                <a class="pull-right btn btn-success" href="{{route('lessons.create')}}">Create New Lesson</a>
	                @endif
                </div>

                <div class="panel-body">
                <lesson_table :initial-lessons="{{$lessons}}"></lesson_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection