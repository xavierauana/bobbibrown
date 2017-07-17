<div class="row">
	<div class="col-sm-7">
		{!! $question->content !!}
	</div>
	<div class="col-sm-5">
		@foreach($question->choices->shuffle() as $choice)
			<div class="form-control">
				<label>
					<input type="radio" name="{{$question->id}}" value="{{$choice->id}}" /> {{$choice->content}}
				</label>
			</div>
		@endforeach
	</div>
</div>