@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        @include("partials.alert")
		<div class="panel panel-default">
            <div class="panel-heading" style="line-height: 36px">
                Users
            </div>

            <div class="panel-body">
                <user_table :initial-users="{{$users}}"></user_table>
            </div>
        </div>
</div>
@endsection