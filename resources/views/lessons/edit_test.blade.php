@extends("MultiAuth::layouts.admin")

@section("content")>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Associate Test
                </div>

                <div class="panel-body">
                    <form method="POST">
	                    {{csrf_field()}}
	                    <div class="form-group">
		                    <label for="test_id">Pick a Test</label>
		                     <select name="test_id" class="form-control">
		                    <option value="">-- Select Test--</option>
			                     @foreach($tests as $test)
				                     <option value="{{$test->id}}"
				                             @if($lesson->hasTest() and $lesson->tests->first()->id  === $test->id) selected @endif>{{$test->title}}</option>
			                     @endforeach
	                    </select>
	                    </div>
	                   
	                    <div class="form-group">
		                    <button class="btn btn-success btn-block">Update</button>
	                    </div>
                    </form>
                </div>
	            
	            <div class="panel-footer">
		            <a class="btn btn-info btn-block" href="{{route('lessons.index')}}">Back</a>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection