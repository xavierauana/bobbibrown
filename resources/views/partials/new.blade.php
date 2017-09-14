<div class="row new_section">
	<h2>{{__("New")}}</h2>
	@foreach($new as $item)
		@if($item instanceof App\Collection)
			@include('partials.collection_item', ['collection'=>$item])
		@elseif($item instanceof App\Lesson)
			@include('partials.lesson', ['lesson'=>$item])
		@else
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 collection_item_wrapper">
				<a href="{{route('show.event.detail', $item->id)}}">
					<div class="collection_item">
					</div>
					<span class="event title">{{$item->title}}</span>
				</a>
			</div>
		@endif
	@endforeach
</div>