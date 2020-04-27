<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
    <div class="main-navbar">
        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
            <a class="navbar-brand w-100 mr-0" href="{{ url('/admin') }}" style="line-height: 25px;">
                <div class="d-table m-auto">
                    <span class="d-none d-md-inline ml-1">{{config('app.name')}}</span>
                </div>
            </a>
            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
        </nav>
    </div>
    <div class="nav-wrapper">
        <ul class="nav flex-column">
            <h6 class="nav-title">Dashboards</h6>

            @if(Auth::guard('employee')->user()->can('admin-list'))
            <li class="nav-item dropdown {{ !empty($menu) ? ($menu == "accounts" ? 'show' : '') : '' }}">
                <a class="nav-link dropdown-toggle {{ !empty($menu) ? ($menu == "accounts" ? 'active' : '') : '' }}" data-toggle="dropdown" href="#" role="button" aria-expanded="true">
                    <i class="material-icons">supervisor_account</i>
                    Account
                </a>
                <div class="dropdown-menu dropdown-menu-small {{ !empty($menu) ? ($menu == "accounts" ? 'show' : '') : '' }}">
                    @if(Auth::guard('employee')->user()->can('admin-list'))
                        <a class="dropdown-item {{ !empty($submenu) ? ($submenu == 'admins' ? 'active' : '') : '' }}" 
                        href="{{route('admin.admin.index')}}">
                            Admin
                        </a>
                    @endif

                    @if(Auth::guard('employee')->user()->can('roles-list'))
                        <a class="dropdown-item {{ !empty($submenu) ? ($submenu == 'roles' ? 'active' : '') : '' }}" 
                        href="{{route('admin.role.index')}}">
                        Role
                        </a>
                    @endif
                </div>
            </li>
            @endif
        </ul>
    </div>
</aside>