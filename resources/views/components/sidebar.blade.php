<div id="sidebar_color" class="">
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ config('app.name') ?? "Gaza Store" }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.index') ? 'active' : '' }} ">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{ __('admin.dash') }}</span></a>
        </li>

        @canany(['users', 'create-user'])
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ request()->routeIs('admin.users.index' || 'admin.users.create') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoUser"
                    aria-expanded="true" aria-controls="collapseTwoUser">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <div id="collapseTwoUser"
                    class="collapse {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.create') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        @can('users')
                            <a class="collapse-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">All Users</a>
                        @endcan
                        @can('create-user')
                            <a class="collapse-item  {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                                href="{{ route('admin.users.create') }}">Create User</a>
                        @endcan

                    </div>
                </div>
            </li>
        @endcanany

        <!-- Nav Item - Pages Collapse Menu -->
        {{-- <li class="nav-item {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') ?  'active' : ''}} ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCategories"
                aria-expanded="true" aria-controls="collapseTwoCategories">
                <i class="fas fa-fw fa-tag"></i>
                <span>{{ __('admin.categories') }}</span>
            </a>
            <div id="collapseTwoCategories" class="collapse {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') ? 'show' : '' }} " aria-labelledby="headingTwo"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">{{ __('admin.all_categories') }}</a>
                    <a class="collapse-item {{ request()->routeIs('admin.categories.create') ? 'active' : '' }} " href="{{ route('admin.categories.create') }}">{{ __('admin.add_new') }}</a>
                </div>
            </div>
        </li> --}}
        <hr class="sidebar-divider my-0">

        @can('categories')
            <li class="nav-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }} ">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>{{ __('admin.all_categories') }}</span></a>
            </li>
        @endcan



        @canany(['create-product', 'products'])
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Pages Collapse Menu -->
            <li
                class="nav-item {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoProducts"
                    aria-expanded="true" aria-controls="collapseTwoProducts">
                    <i class="fas fa-fw fa-heart"></i>
                    <span>{{ __('admin.products') }}</span>
                </a>
                <div id="collapseTwoProducts"
                    class="collapse {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') ? 'show' : '' }} "
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('products')
                            <a class="collapse-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}">{{ __('admin.products') }}</a>
                        @endcan
                        @can('create-product')
                            <a class="collapse-item  {{ request()->routeIs('admin.products.create') ? 'active' : '' }}"
                                href="{{ route('admin.products.create') }}">{{ __('admin.add_new') }}</a>
                        @endcan
                    </div>
                </div>
            </li>
        @endcanany

        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>{{ __('admin.orders') }}</span></a>
        </li>

        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-dollar-sign"></i>
                <span>{{ __('admin.payments') }}</span></a>
        </li>


        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-users"></i>
                <span>{{ __('admin.customers') }}</span></a>
        </li>

        @canany(['create-role', 'roles'])
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ request()->routeIs('admin.roles.index' || 'admin.roles.create') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoRole"
                    aria-expanded="true" aria-controls="collapseTwoRole">
                    <i class="fas fa-fw fa-lock"></i>
                    <span>{{ __('admin.role') }}</span>
                </a>
                <div id="collapseTwoRole"
                    class="collapse {{ request()->routeIs('admin.roles.index') || request()->routeIs('admin.roles.create') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @can('roles')
                            <a class="collapse-item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}"
                                href="{{ route('admin.roles.index') }}">{{ __('admin.all_role') }}</a>
                        @endcan

                        @can('create-role')
                            <a class="collapse-item  {{ request()->routeIs('admin.roles.create') ? 'active' : '' }}"
                                href="{{ route('admin.roles.create') }}">{{ __('admin.add_new') }}</a>
                        @endcan

                    </div>
                </div>
            </li>
        @endcanany

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</div>
