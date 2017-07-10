@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Test
                </div>
                <div class="panel-body">
                   @include('tests.partials.create_form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
