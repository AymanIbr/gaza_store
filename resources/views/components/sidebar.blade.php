<div id="sidebar_color" class="">
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('dashboard.dash') }}</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCategories"
                aria-expanded="true" aria-controls="collapseTwoCategories">
                <i class="fas fa-fw fa-tag"></i>
                <span>{{ __('dashboard.categories') }}</span>
            </a>
            <div id="collapseTwoCategories" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item " href="">{{ __('dashboard.all_categories') }}</a>
                    <a class="collapse-item  " href="">{{ __('dashboard.add_new') }}</a>
                </div>
            </div>
        </li>


        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoProducts"
                aria-expanded="true" aria-controls="collapseTwoProducts">
                <i class="fas fa-fw fa-heart"></i>
                <span>{{ __('dashboard.products') }}</span>
            </a>
            <div id="collapseTwoProducts" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item " href="">{{ __('dashboard.products') }}</a>
                    <a class="collapse-item  " href="">{{ __('dashboard.add_new') }}</a>
                </div>
            </div>
        </li>


        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>{{ __('dashboard.orders') }}</span></a>
        </li>

        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>{{ __('dashboard.payments') }}</span></a>
        </li>


        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-users"></i>
                <span>{{ __('dashboard.customers') }}</span></a>
        </li>

        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoRole"
                aria-expanded="true" aria-controls="collapseTwoRole">
                <i class="fas fa-fw fa-lock"></i>
                <span>{{ __('dashboard.role') }}</span>
            </a>
            <div id="collapseTwoRole" class="collapse" aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item " href="">{{ __('dashboard.all_role') }}</a>
                    <a class="collapse-item  " href="">{{ __('dashboard.add_new') }}</a>
                </div>
            </div>
        </li>
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
   </div>
