@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
        @include("partials.alert")
		<div class="panel panel-default">
            <div class="panel-heading" style="line-height: 36px">
                Deleted Users
            </div>

            <div class="panel-body">
                <trashed-user-table
		                :initial-users="{{$deletedUsers}}"></trashed-user-table>
            </div>
        </div>
</div>
@endsection