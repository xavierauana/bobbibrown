@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Menus
	                @can('create', new App\Menu())
		                <a class="pull-right btn btn-success" href="{{route('menus.create')}}">Create New Menu Item</a>
	                @endcan
                </div>

                <div class="panel-body">
                <menu_table :initial-menus="{{$menus}}"></menu_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection