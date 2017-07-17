@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Permissions in {{$role->title}}
                </div>

                <div class="panel-body">
                    <role_permissions :role="{{$role}}"
                                      :permissions="{{$lessons}}"
                                      :selected-permissions="{{$role->permissions}}"></role_permissions>
                </div>
	            
	            <div class="panel-footer">
		            <a class="btn btn-info btn-block" href="{{route('collections.lessons.index', $role->id)}}">Back</a>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection