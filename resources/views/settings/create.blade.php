@extends("MultiAuth::layouts.admin")

@section('styles')
	<style href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"></style>
@endsection

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Event
                </div>

                <div class="panel-body">
                   @include('events.partials.create_form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection