@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Questions in {{$test->title}}
	                @if(auth('admin')->user()->hasPermission('editTest'))
		                <a class="pull-right btn btn-success" href="{{route('tests.questions.create', $test->id)}}">Create New Question</a>
	                @endif
                </div>

                <div class="panel-body">
                    <h4>Questions</h4>
                    <question_list :initial-questions="{{$questions}}" :test-id="{{$test->id}}"></question_list>
                </div>
                <div class="panel-footer">
                    <a href="{{route('tests.index')}}" class="btn btn-block btn-info">Back</a>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection