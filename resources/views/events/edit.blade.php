@extends("MultiAuth::layouts.admin")

@section("content")
	@include('partials.alert')
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Event - {{$event->title}}
                </div>

                <div class="panel-body">
                   @include('events.partials.edit_form')
	                <hr>
	                @include('events.partials.participant_list',['participants'=>$event->participants])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection