<div class="row featured_section">
	<h2>New</h2>
	@foreach($new as $item)
		@if($item instanceof App\Collection)
			@include('partials.collection_item', ['collection'=>$item])
		@else
			@include('partials.lesson', ['lesson'=>$item])
		@endif
	@endforeach
</div>