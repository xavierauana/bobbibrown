<div class="row collection_section">
	<h2>Series</h2>
	@foreach($collections as $collection)
		@include('partials.collection_item')
	@endforeach
</div>