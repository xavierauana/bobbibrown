@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Test - {{$test->title}}
                </div>

                <div class="panel-body">
                    @include('tests.partials.edit_form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection