@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Events
	                @if(auth('admin')->user()->hasPermission('createEvent'))
		                <a class="pull-right btn btn-success" href="{{route('events.create')}}">Create New Event</a>
	                @endif
                </div>

                <div class="panel-body">
                <event_table :initial-events="{{$events}}"></event_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection