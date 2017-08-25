@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Categories
	                @if(auth('admin')->user()->hasPermission('createCategory'))
		                <a class="pull-right btn btn-success" href="{{route('categories.create')}}">Create New Category</a>
	                @endif
                </div>

                <div class="panel-body">
                <categories_table :initial-categories="{{$categories}}"></categories_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection