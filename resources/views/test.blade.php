@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.alert')
		<div class="panel panel-default">
	        <div class="panel-heading">{{$test->title}}</div>
	        <div class="panel-body">
	           @foreach($test->questions as $question)
			        @if($question->QuestionType->code == 'SingleMultipleChoice')
				        @include('questions.questions.single_mc')
			        @endif
		        @endforeach
	        </div>
			<div class="panel-footer clearfix">
				<a class="btn btn-success pull-right" href="{{route('show.lesson.test', $lesson->id)}}">Submit</a>
			</div>
	    </div>
	</div>
@endsection
