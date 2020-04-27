<div class="main-navbar sticky-top bg-white">
    <!-- Main Navbar -->
    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <ul class="navbar-nav border-left flex-row ml-md-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    {{-- @if(Auth::user()->role == 'dosen' && !empty(Auth::user()->detailDosen) && Auth::user()->detailDosen->profile_pict != null)
                    <img class="user-avatar rounded-circle mr-2" src="{{ url('/').Storage::url(Auth::user()->detailDosen->profile_pict) }}" alt="User Avatar">
                    @else
                    <img class="user-avatar rounded-circle mr-2" src="{{ asset('dashboard_asset/images/no-profile-image.png') }}" alt="User Avatar">
                    @endif --}}
                    <img class="user-avatar rounded-circle mr-2" 
                    src="{{ 
                        !empty(auth()->guard('employee')->user()->image)
                            ? url('/storage'.'/'.auth()->guard('employee')->user()->image)
                                : asset('images/no-profile-image.png')
                    }}" alt="User Avatar" height="40" width="40">
                    <span class="d-none d-md-inline-block" style="min-width:65px;" >{{ auth()->guard('employee')->user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-small">
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    
                    <a class="dropdown-item {{ Auth::guard('employee')->user()->email_verified_at != null ? 'text-success' : ''}}" href="{{ route('admin.edit.account', auth()->guard('employee')->user()->id)}}">
                        <i class="material-icons mdl-list__item-icon">account_circle</i>
                        My account
                        @if(Auth::guard('employee')->user()->email_verified_at != null)
                            <i class="material-icons mdl-list__item-icon">verified_user</i>
                        @endif 
                    </a>
                    <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                        <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                        Log out
                    </a>
                </div>
            </li>
        </ul>
        <nav class="nav">
            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                <i class="material-icons">&#xE5D2;</i>
            </a>
        </nav>
    </nav>
</div>