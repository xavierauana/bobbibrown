<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 collection_item_wrapper">
	<a href="{{route('show.collection', $collection->id)}}">
		<div class="collection_item"
		     style="background-image:url('{{$collection->poster}}')">
			@if(auth()->user()->passCollection($collection))
				<span class="text-success text-center check"><i class="fa fa-check" aria-hidden="true"></i></span>
			@endif
		</div>
		<span class="title">{{$collection->title}}</span>
	</a>
</div>