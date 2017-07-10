@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Collections - {{$collection->title}}
	                @if(auth('admin')->user()->hasPermission('editCollection'))
		                <a class="pull-right btn btn-success"
		                   href="{{route('collections.lessons.edit', $collection->id)}}">Update Lessons in Collections</a>
	                @endif
                </div>

                <div class="panel-body">
                    <lesson_list :initial-lessons="{{$lessons}}" :collection-id="{{$collection->id}}"></lesson_list>
                </div>
	            
	            <div class="panel-footer">
		            <a class="btn btn-info btn-block" href="{{route('collections.index')}}">Back</a>
	            </div>
            </div>
        </div>
    </div>
</div>
@endsection