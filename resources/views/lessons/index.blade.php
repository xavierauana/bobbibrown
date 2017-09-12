@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        <div class="panel panel-default">
            <div class="panel-heading" style="line-height: 36px">
                Lessons
                @if(auth('admin')->user()->hasPermission('createLesson'))
	                <a class="pull-right btn btn-success"
	                   href="{{route('lessons.create')}}">Create New Lesson</a>
                @endif
            </div>

            <div class="panel-body">
            <lesson_table></lesson_table>
            </div>
        </div>
</div>
@endsection