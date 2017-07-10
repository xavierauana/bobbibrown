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


@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
	
	<script>
        
        var startDateTime = moment("{{$event->start_datetime}}", "YYYY-MM-DD hh:mm:ss")
        var endDateTime = moment("{{$event->end_datetime}}", "YYYY-MM-DD hh:mm:ss")
        $('#start_datetime').datetimepicker({
                                              defaultDate: startDateTime,
                                              format     : "lll"
                                            });
        $('#end_datetime').datetimepicker({
                                            format     : "lll",
                                            defaultDate: endDateTime,
                                            useCurrent : false //Important! See issue #1075
                                          });
        $("#start_datetime").on("dp.change", function (e) {
          $('#end_datetime').data("DateTimePicker").minDate(e.date);
        });
        $("#end_datetime").on("dp.change", function (e) {
          $('#start_datetime').data("DateTimePicker").maxDate(e.date);
        });
    </script>
@endsection
