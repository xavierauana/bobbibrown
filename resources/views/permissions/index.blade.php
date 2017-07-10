@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Permissions
	                @if(auth('admin')->user()->hasPermission('createUserPermission'))
		                <a class="pull-right btn btn-success" href="{{route('permissions.create')}}">Create New Permission</a>
	                @endif
                </div>

                <div class="panel-body">
                <permission_table :initial-permissions="{{$permissions}}"></permission_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection