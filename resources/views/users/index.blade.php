@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Events
	                @if(auth('admin')->user()->can('view', 'App\User'))
		                <a class="pull-right btn btn-success" href="{{route('users.create')}}">Create New User</a>
	                @endif
                </div>

                <div class="panel-body">
                <user_table :initial-users="{{$users}}"></user_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection