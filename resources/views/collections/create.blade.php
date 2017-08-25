@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        <div class="panel panel-default">
                <div class="panel-heading">
                    New Collections
                </div>

                <div class="panel-body">
                   @include('collections.partials.create_form')
                </div>
            </div>
    </div>
@endsection
