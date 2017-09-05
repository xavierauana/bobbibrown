<div class="row collection_section">
	<h2>{{__("Series")}}</h2>
	@foreach($collections as $collection)
		@include('partials.collection_item')
	@endforeach
</div>