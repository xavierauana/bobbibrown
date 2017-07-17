@extends("MultiAuth::layouts.admin")

@section("content")
	<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="line-height: 36px">
                    Settings
                </div>

                <div class="panel-body">
                <table class="table">
                    <thead>
                        <th>Label</th>
                        <th>Code</th>
                        <th>Value</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($settings as $setting)
	                        <tr>
                                <td>{{$setting->label}}</td>
                                <td>{{$setting->code}}</td>
                                <td>{{$setting->value}}</td>
                                <td>
                                    <a class="btn btn-info btn-sm" href="{{route('settings.edit', $setting->id)}}">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection