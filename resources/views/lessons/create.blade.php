@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Lesson
                </div>

                <div class="panel-body">
                   @include('lessons.partials.create_form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script>
         CKEDITOR.replace('content');
    </script>
@endsection
