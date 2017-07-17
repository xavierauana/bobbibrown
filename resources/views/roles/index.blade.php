@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        @include('partials.alert')
		<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Roles
	                @if(auth('admin')->user()->can('create', 'App\Role'))
		                <a class="pull-right btn btn-success" href="{{route('roles.create')}}">Create New Role</a>
	                @endif
                </div>

                <div class="panel-body">
                <role_table :initial-roles="{{$roles}}"></role_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection