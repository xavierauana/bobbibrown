@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Lines
	                @if(auth('admin')->user()->hasPermission('createLine'))
		                <a class="pull-right btn btn-success" href="{{route('lines.create')}}">Create New Line</a>
	                @endif
                </div>

                <div class="panel-body">
                    <lines_table :initial-lines="{{$lines}}"></lines_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection