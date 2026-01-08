 <aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
        <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" alt="site logo" class="light-logo">
        <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" alt="site logo" class="dark-logo">
        <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" alt="site logo" class="logo-icon">
        </a>
    </div> 
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
        <li >
            <a href="{{ route('admin.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}">
            <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
            <span>Users</span>
            </a>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)">
            <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
            <span>Blogs</span> 
            </a>
            <ul class="sidebar-submenu">
                <li>
                    <a href="{{ route('admin.blogs.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
                </li>
                <li>
                    <a href="{{ route('admin.blogs.create') }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Add new</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)">
            <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
            <span>Events</span> 
            </a>
            <ul class="sidebar-submenu">
            <li>
                <a href="{{ route('admin.events.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
            </li>
            <li>
                <a href="{{ route('admin.events.create') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>  Add new</a>
            </li>
           
            
            </ul>
        </li>
         <li class="dropdown">
            <a href="javascript:void(0)">
            <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
            <span>Courses</span> 
            </a>
            <ul class="sidebar-submenu">
            <li>
                <a href="{{ route('admin.courses.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> List</a>
            </li>
            <li>
                <a href="{{ route('admin.courses.create') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>  Add new</a>
            </li>
           
            
            </ul>
        </li>
      
        
        </ul>
    </div>
    </aside>