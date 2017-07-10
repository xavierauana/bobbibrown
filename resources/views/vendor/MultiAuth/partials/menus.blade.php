@if(auth('admin')->check())
	@can('view', new App\Menu())
		<li><a href="{{route('menus.index')}}">Menus</a></li>
	@endcan
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
	
	
	<li class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
        aria-expanded="false">
           User Settings <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
			@if(auth('admin')->user()->hasPermission('showUser'))
		        <li><a href="#">Users</a></li>
	        @endif
	        @if(auth('admin')->user()->hasPermission('showUserRole'))
		        <li><a href="#">Roles</a></li>
	        @endif
	        @if(auth('admin')->user()->hasPermission('showUserPermission'))
		        <li><a href="{{route("permissions.index")}}">Permissions</a></li>
	        @endif
        </ul>
</li>
	<li class="dropdown">
 <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
    aria-expanded="false">
       Admin Settings <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
	     @if(auth('admin')->user()->hasPermission('showAdmin'))
		    <li><a href="#">Administrators</a></li>
	    @endif
	    @if(auth('admin')->user()->hasPermission('showAdminRole'))
		    <li><a href="#">Admin Roles</a></li>
	    @endif
    </ul>
</li>
@endif