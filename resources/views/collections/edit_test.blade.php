@extends("MultiAuth::layouts.admin")

@section("content")>
<div class="container">
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
				                             @if($collection->tests->count() and $collection->tests->first()->id  === $test->id) selected @endif>{{$test->title}}</option>
			                     @endforeach
	                    </select>
	                    </div>
	                   
	                    <div class="form-group">
		                    <button class="btn btn-success btn-block">Update</button>
	                    </div>
                    </form>
                </div>
	            
	            <div class="panel-footer">
		            <a class="btn btn-info btn-block" href="{{route('collections.index')}}">Back</a>
	            </div>
            </div>
</div>
@endsection