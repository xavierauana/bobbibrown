@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
  
        <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Lessons in {{$collection->title}}
                </div>

                <div class="panel-body">
                    <collection_lessons :collection="{{$collection}}"
                                        :lessons="{{$lessons}}"
                                        :selected-lessons="{{$collection->lessons()->select(['id', 'title'])->get()}}"></collection_lessons>
                </div>
	            
	            <div class="panel-footer">
		            <a class="btn btn-info btn-block"
		               href="{{route('collections.lessons.index', $collection->id)}}">Back</a>
	            </div>
            </div>
        
	</div>
@endsection