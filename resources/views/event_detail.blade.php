@extends('layouts.app')

@section('content')
	<div class="container" id="event">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$event->title}}</div>
	        <div class="panel-body">
		        <h5>Event Start Date and Time: @{{event.start_datetime}}</h5>
		        <h5>Event End Date and Time: @{{event.end_datetime}}</h5>
		        <section>
		        <h5>Description</h5>
		        <div v-html="event.body">
		        </div>
		        </section>
		        
		        </div>
		        <div class="panel-footer">
				<a href="{{route('show.events')}}" class="btn btn-sm btn-info">Back</a>
				<button class="btn btn-sm btn-success" :disabled="!event.can_register">Register</button>
			</div>
	    </div>
	</div>
@endsection


@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script>
				      new Vue({
                                el     : '#event',
                                data   : {
                                  event: {
                                    'id'            : {!! $event->id !!},
                                    'title'         : "{!! $event->title !!}",
                                    'body'          : "{!! $event->body !!}",
                                    'vacancies'     : {!! $event->vacancies !!},
                                    'start_datetime': moment("{!! $event->start_datetime !!}").format('YYYY-MM-D, h:mm a'),
                                    'end_datetime'  : moment("{!! $event->end_datetime !!}").format('YYYY-MM-D, h:mm a'),
                                    'participants'  : {!! $event->participants->count() !!},
                                    'can_register'  : {!! auth()->user()->canRegisterEvent($event)? "true":"false"  !!},
                                  }
                                },
                                methods: {
                                  register: function (eventId) {
                                    var url = this._getUrl(eventId)
                                    axios.post(url)
                                         .then(function (response) {
                                           if (response.data.register) {
                                             this.event.participants += 1
                                             this.event.can_register = false
                                             alert('Event Register!')
                                           } else {
                                             alert(response.data.message)
                                           }
                                         }.bind(this))
                                         .catch(function (response) {
                                           console.log(response)
                                         })
                                  },
                                  _getUrl : function () {
                                    return window.location.href + '/register'
                                  }
                                }
                              })
        </script>
@endsection
