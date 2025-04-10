 <!-- leftbar-tab-menu -->
 <div class="left-sidebar">
    <!-- LOGO -->
    <div class="brand" style="background-color: #fff">
        <a href="{{ route('admin.index')}}" class="logo" >
            {{-- <span>
                <img src="{{ asset('assets/img/logo/nav-log.png')}}" alt="logo-small" class="logo-sm">
            </span> 
            <span>
                <img src="{{ asset('assets/img/logo/nav-log.png')}}" alt="logo-large" class="logo-lg logo-light">
                <img src="{{ asset('assets/img/logo/nav-log.png')}}" alt="logo-large" class="logo-lg logo-dark">
            </span> --}}
        </a> 
    </div> 
    <div class="sidebar-user-pro media border-end">                    
        <div class="position-relative mx-auto">
            <img src="{{ asset($contactDetials->favicon) }}" alt="user" class="rounded-circle thumb-md">
            <span class="online-icon position-absolute end-0"><i class="mdi mdi-record text-success"></i></span>
        </div>
        <div class="media-body ms-2 user-detail align-self-center">
            <h5 class="font-14 m-0 fw-bold">{{ Auth('admin')->user()->name}} </h5>  
            <p class="opacity-50 mb-0">{{ Auth('admin')->user()->email}}</p>          
        </div>                    
    </div>
    <div class="border-end">
        <ul class="nav nav-tabs menu-tab nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="{{ route('admin.index') }}" role="tab" aria-selected="true">M<span>ain</span></a>
            </li>
            
        </ul>
    </div>
    <!-- Tab panes -->

    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <div class="menu-body navbar-vertical">
            <div class="collapse navbar-collapse tab-content" id="sidebarCollapse">
                <!-- Navigation -->
                <ul class="navbar-nav tab-pane active" id="Main" role="tabpanel">
                    <li class="menu-label mt-0 text-primary font-12 fw-semibold">M<span>ain</span><br><span class="font-10 text-secondary fw-normal">Unique Dashboard</span></li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users')}}" role="button"
                            aria-expanded="false" aria-controls="sidebarAnalytics">
                            <i class="ti ti-users menu-icon"></i>
                            <span>Users</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.properties.index') }}" >
                            <i class="ti ti-brand-asana menu-icon"></i>
                            <span>Properties</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.buy.index') }}" >
                            <i class="ti ti-arrow-up menu-icon"></i>
                            <span>Buy</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.sell.index') }}" >
                            <i class="ti ti-arrow-down menu-icon"></i>
                            <span>Sell</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.transfer.index') }}" >
                            <i class="ti ti-recycle menu-icon"></i>
                            <span>Transfer</span>
                        </a>
                    </li><!--end nav-item-->

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.post.index')}}" >
                            <i class="ti ti-shopping-cart menu-icon"></i>
                            <span>Blog</span>
                        </a>
                    </li><!--end nav-item--> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.faq.index')}}" >
                            <i class="ti ti-shopping-cart menu-icon"></i>
                            <span>FAQs</span>
                        </a>
                    </li><!--end nav-item-->

                    <li class="menu-label mt-0 text-primary font-12 fw-semibold">S<span>etting</span></li> 
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarElements">
                            <i class="ti ti-settings menu-icon"></i>
                        <span>Setting</span>
                        </a>
                        <div class="collapse " id="sidebarElements">
                            <ul class="nav flex-column">
                               
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.menu.index')}}">Manage Menu</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.settings.index')}}">Contents</a>
                                </li><!--end nav-item--> 
                            </ul><!--end nav-->
                        </div><!--end sidebarElements-->
                    </li><!--end nav-item-->

                    
                   
                </ul>
                
            </div><!--end sidebarCollapse-->
        </div>
    </div>    
</div>
<!-- end left-sidenav-->
<!-- end leftbar-menu-->
