<div class="az-header az-header-mail">
    <div class="container">
      <div class="az-header-left">
        <a href="{{ route('home') }}" class="az-logo">{{ config('app.name') }}</a>
        <a href="" id="azNavShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        <a href="" id="azContentBodyHide" class="az-header-arrow d-md-none"><i class="icon ion-md-arrow-back"></i></a>
      </div><!-- az-header-left -->
      <div class="az-header-center">
        
      </div><!-- az-header-center -->
      <div class="az-header-right">
            @auth
                <div class="dropdown az-profile-menu">
                    <a class="az-img-user">
                        <img class="user-avatar rounded-circle mr-2" 
                        src="{{ 
                            !empty(auth()->user()->image)
                                ? url('/storage'.'/'.auth()->user()->image)
                                    : 'https://via.placeholder.com/500x500'
                        }}" alt="User Avatar" height="40" width="40" style="cursor:pointer">
                    </a>
                    <div class="dropdown-menu">
                        <div class="az-dropdown-header d-sm-none">
                            <a class="az-header-arrow"><i class="icon ion-md-arrow-back" style="cursor:pointer"></i></a>
                        </div>
                        <div class="az-header-profile">
                            <div class="az-img-user">
                                <img class="user-avatar rounded-circle mr-2" 
                                src="{{ 
                                    !empty(auth()->user()->image)
                                        ? url('/storage'.'/'.auth()->user()->image)
                                            : 'https://via.placeholder.com/500x500'
                                }}" alt="User Avatar" height="40" width="40">
                            </div><!-- az-img-user -->
                            
                            <h6>{{ Auth::user()->name }} 
                                @if(Auth::user()->email_verified_at != null)
                                    <i class="material-icons">check</i>
                                @endif     
                            </h6>
                            
                        </div><!-- az-header-profile -->
                        @if(Auth::user()->email_verified_at == null)
                            <a href="{{url('/email/resend')}}" class="dropdown-item">Click Here to Verification</a>
                        @endif
                        <a href="{{ route('accounts.edit', Crypt::encrypt(auth()->user()->id) )}}" class="dropdown-item">Account Settings</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item">Sign Out</a>
                    </div><!-- dropdown-menu -->
                </div>
            @else
                <a href="{{ route('login') }}" style="margin-right:10px">
                    <button class="btn btn-az-secondary btn-block add__btn" style="font-weight:bold;">
                        Sign In
                    </button>
                </a>

                <a href="{{ route('register') }}">
                    <button class="btn btn-az-secondary btn-block add__btn" style="font-weight:bold">
                        Sign Up
                    </button>
                </a>
            @endauth
      </div><!-- az-header-right -->
    </div><!-- container -->
  </div><!-- az-header -->