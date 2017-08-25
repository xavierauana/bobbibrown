<div class="panel-group" id="accordion_{{$key}}" role="tablist" aria-multiselectable="true">
					@foreach($collection as $item)
		<div class="panel panel-default">
						    <div class="panel-heading" role="tab" id="category_{{$key}}_{{$item->id}}">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion_{{$key}}"
						           href="#collapse_{{$category->id}}"
						           aria-expanded="true" aria-controls="collapse_{{$category->id}}">
						          {{$category->name}}
						        </a>
						      </h4>
						    </div>
						    <div id="collapse_{{$category->id}}" class="panel-collapse collapse" role="tabpanel"
						         aria-labelledby="category_{{$key}}_{{$item->name}}">
						      <div class="panel-body">
							      
							      
							      
							      
							      
						        
						      </div>
						    </div>
						  </div>
	@endforeach
				</div>