@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
	    <div class="panel panel-default">
	        <div class="panel-heading" style="line-height: 36px">
	            Collections
		        @if(auth('admin')->user()->hasPermission('createCollection'))
			        <a class="pull-right btn btn-success"
			           href="{{route('collections.create')}}">Create New Collection</a>
		        @endif
	        </div>
	
	        <div class="panel-body">
	            <collection_table :initial-collections="{{$collections}}"></collection_table>
	        </div>
	    </div>
	</div>
@endsection