<div class="row lessons_section">
	<h2>Lessons</h2>
	@foreach($lessons as $lesson)
		@include('partials.lesson')
	@endforeach
</div>