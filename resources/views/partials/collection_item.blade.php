<div class="col-sm-3 collection_item_wrapper">
	<div class="collection_item">
		<a href="{{route('show.collection', $collection->id)}}">
		@if(auth()->user()->passCollection($collection))
				<span class="text-success text-center check"><i class="fa fa-check" aria-hidden="true"></i></span>
			@endif
			{{$collection->title}}</a>
	</div>
</div>