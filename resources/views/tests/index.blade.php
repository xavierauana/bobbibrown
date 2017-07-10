@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Tests
	                @if(auth('admin')->user()->hasPermission('createTest'))
		                <a class="pull-right btn btn-success" href="{{route('tests.create')}}">Create New Test</a>
	                @endif
                </div>

                <div class="panel-body">
                    <test_table :initial-tests="{{$tests}}"></test_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection