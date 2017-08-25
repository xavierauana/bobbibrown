@if(auth('admin')->check())
	@if(auth('admin')->user()->hasPermission('showCollection'))
		<li><a href="{{route('collections.index')}}">Collections</a></li>
	@endif
	@if(auth('admin')->user()->hasPermission('showLesson'))
		<li><a href="{{route('lessons.index')}}">Lessons</a></li>
	@endif
	@if(auth('admin')->user()->hasPermission('showTest'))
		<li><a href="{{route('tests.index')}}">Tests</a></li>
	@endif
	@if(auth('admin')->user()->hasPermission('showEvent'))
		<li><a href="{{route('events.index')}}">Events</a></li>
	@endif
	@if(auth('admin')->user()->hasPermission('showSetting'))
		<li><a href="{{route('settings.index')}}">Setting</a></li>
	@endif
	<li class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
        aria-expanded="false">
           Resources <span class="caret"></span>
        </a>
		
		@if(auth('admin')->user()->hasPermission(['showCategory','showLine', 'showProduct' ]))
			<ul class="dropdown-menu" role="menu">
				@if(auth('admin')->user()->hasPermission('showCategory'))
					<li><a href="{{route('categories.index')}}">Categories</a></li>
				@endif
				@if(auth('admin')->user()->hasPermission('showLine'))
					<li><a href="{{route('lines.index')}}">Lines</a></li>
				@endif
				@if(auth('admin')->user()->hasPermission('showProduct'))
					<li><a href="{{route("products.index")}}">Products</a></li>
				@endif
            </ul>
		@endif
</li>
	
	
	<li class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
        aria-expanded="false">
           User Settings <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
			@if(auth('admin')->user()->hasPermission('showUser'))
		        <li><a href="{{route('users.index')}}">Users</a></li>
	        @endif
	        @if(auth('admin')->user()->hasPermission('showUserRole'))
		        <li><a href="{{route('roles.index')}}">Roles</a></li>
	        @endif
	        @if(auth('admin')->user()->hasPermission('showUserPermission'))
		        <li><a href="{{route("permissions.index")}}">Permissions</a></li>
	        @endif
        </ul>
</li>
	{{--<li class="dropdown">--}}
	{{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
	{{--aria-expanded="false">--}}
	{{--Admin Settings <span class="caret"></span>--}}
	{{--</a>--}}
	{{--<ul class="dropdown-menu" role="menu">--}}
	{{--@if(auth('admin')->user()->hasPermission('showAdmin'))--}}
	{{--<li><a href="#">Administrators</a></li>--}}
	{{--@endif--}}
	{{--@if(auth('admin')->user()->hasPermission('showAdminRole'))--}}
	{{--<li><a href="#">Admin Roles</a></li>--}}
	{{--@endif--}}
	{{--</ul>--}}
	{{--</li>--}}
@endif