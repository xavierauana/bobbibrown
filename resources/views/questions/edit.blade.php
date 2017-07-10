@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <edit_question :initial-question="{{json_encode($question)}}"
                           :test-id="{{$test->id}}"></edit_question>
        </div>
    </div>
</div>
@endsection