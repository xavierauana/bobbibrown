<div class="row featured_section">
	<h2>{{__("Featured")}}</h2>
	@foreach($featured as $item)
		@if($item instanceof \App\Collection)
			@include('partials.collection_item', ['collection'=>$item])
		@else
			@include('partials.lesson', ['lesson'=>$item])
		@endif
	@endforeach
</div>