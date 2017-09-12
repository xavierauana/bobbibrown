@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Products
	                @if(auth('admin')->user()->hasPermission('createProduct'))
		                <a class="pull-right btn btn-success" href="{{route('products.create')}}">Create New Product</a>
	                @endif
                </div>

                <div class="panel-body">
                    <products_table></products_table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection