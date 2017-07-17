@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$user->name}}
                    </div>
    
                    <div class="panel-body">
                      <section>
                          <h3>Basic User Info</h3>
                          <p><strong>Name:</strong> {{$user->name}}</p>
                          <p><strong>Email:</strong> {{$user->email}}</p>
                          <p><strong>Employee ID:</strong> {{$user->employee_id}}</p>
                      </section>
	                    @include('users.partials.user_lesson_section')
	                    @include('users.partials.user_event_section')
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection