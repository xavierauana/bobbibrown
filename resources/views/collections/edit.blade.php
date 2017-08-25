@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    
        <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Collection - {{$collection->title}}
                </div>

                <div class="panel-body">
                   @include('collections.partials.edit_form')
                </div>
            </div>
        
    </div>

@endsection
