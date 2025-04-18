@php
  // Map each locale to its corresponding flag image file.
  // Ensure these files are present in the public/assets/images/flags/ folder.
  $flagImages = [
    'en' => 'us.png',      // English flag (US)
    'es' => 'es.png',      // Spanish flag (from Flaticon)
    'ar' => 'sa.png',      // Arabic flag (for example, Saudi flag)
  ];
@endphp



<header class="bg-light box-shadow-sm navbar-sticky">
  <!-- Removed the Topbar -->

  <!-- Main Navbar -->
  <div class="navbar-sticky">
    <div class="navbar navbar-expand-lg navbar-light navbar-modern new">
      <div class="container">
        <!-- Logo -->
        @if($allsettings->site_logo != '')
        <a class="navbar-brand" href="{{ URL::to('/') }}" style="min-width: 7rem;">
          <img class="lazy" src="{{ url('/') }}/public/storage/settings/{{ $allsettings->site_logo }}" 
               alt="{{ $allsettings->site_title }}" style="max-height: 50px;">
        </a>
        @endif

        <!-- Desktop Menu (Centered) -->
        <div class="d-none d-lg-flex mx-auto" style="margin-left:20%!important">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">{{ __('Shop') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/pricing') }}">{{ __('Pricing') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">{{ __('About') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">{{ __('Contact') }}</a></li>
          </ul>
        </div>

        <!-- Right Side Icons -->
        <div class="navbar-toolbar d-flex align-items-center ml-auto">
          <!-- Favorites Icon (directly inline) -->
          <a class="navbar-tool d-none d-lg-flex" href="{{ URL::to('/favourites') }}">
            <span class="navbar-tool-tooltip">{{ __('Favourites') }}</span>
            <div class="navbar-tool-icon-box">
              <i class="navbar-tool-icon dwg-heart"></i>
            </div>
          </a>
          <!-- User Profile (Login or Dropdown with Cash/Earnings) -->
          @if(Auth::guest())
          <a class="navbar-tool ml-1 mr-n1" href="{{ URL::to('/login') }}">
            <span class="navbar-tool-tooltip">{{ __('Account') }}</span>
            <div class="navbar-tool-icon-box">
              <i class="navbar-tool-icon dwg-user"></i>
            </div>
          </a>
          @else
          <div class="navbar-tool dropdown ml-2">
            <a class="navbar-tool-icon-box dropdown-toggle" data-toggle="dropdown"
              @if(Auth::user()->id == 1)
                href="{{ url('/admin') }}" target="_blank"
              @else
                href="{{ URL::to('/user') }}/{{ Auth::user()->username }}"
              @endif>
              @if(!empty(Auth::user()->user_photo))
              <img class="lazy" width="32" height="32" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}" 
                   alt="{{ Auth::user()->name }}" />
              @else
              <img class="lazy" width="32" height="32" src="{{ url('/') }}/public/img/no-user.png" 
                   alt="{{ Auth::user()->name }}">
              @endif
            </a>
            <a class="navbar-tool-text ml-n1"
              @if(Auth::user()->id == 1)
                href="{{ url('/admin') }}" target="_blank"
              @else
                href="{{ URL::to('/user') }}/{{ Auth::user()->username }}"
              @endif>
              <small>{{ Auth::user()->name }}</small>
              {{ Helper::price_format($allsettings->site_currency_position, Auth::user()->earnings, $currency_symbol, $multicurrency) }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="min-width: 14rem;">
              @if(Auth::user()->user_type == 'vendor')
              <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('/user') }}/{{ Auth::user()->username }}">
                <i class="dwg-home opacity-60 mr-2"></i> {{ __('Profile') }}
              </a>
              <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('/profile-settings') }}">
                <i class="dwg-settings opacity-60 mr-2"></i> {{ __('Setting') }}
              </a>
              @elseif(Auth::user()->user_type == 'customer')
              <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('/user') }}/{{ Auth::user()->username }}">
                <i class="dwg-home opacity-60 mr-2"></i> {{ __('Profile') }}
              </a>
              <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('/profile-settings') }}">
                <i class="dwg-settings opacity-60 mr-2"></i> {{ __('Setting') }}
              </a>
              @elseif(Auth::user()->user_type == 'admin')
              <a class="dropdown-item d-flex align-items-center" href="{{ url('/admin') }}">
                <i class="dwg-settings opacity-60 mr-2"></i> {{ __('Admin Panel') }}
              </a>
              @endif
              <div class="dropdown-divider"></div>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('/logout') }}">
                <i class="dwg-sign-out opacity-60 mr-2"></i> {{ __('Logout') }}
              </a>
            </div>
          </div>
          @endif

          <!-- Cart Icon -->
          <a class="navbar-tool ml-2" href="{{ url('/cart') }}">
            <span class="navbar-tool-label">{{ $cartcount }}</span>
            <div class="navbar-tool-icon-box">
              <i class="navbar-tool-icon dwg-cart"></i>
            </div>
          </a>

          <!-- Language Selection with Flag using Flaticon images -->
          @if($allsettings->multi_language == 1)
          <div class="dropdown ml-2">
            <a class="navbar-tool dropdown-toggle" data-toggle="dropdown" href="#">
              <img src="{{ asset('public/assets/images/flags/' . ($flagImages[$current_locale] ?? 'us.png')) }}" 
                   alt="{{ $current_locale }}" width="24" height="24">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              @foreach($available_locales as $locale_name => $available_locale)
              <a class="dropdown-item" href="{{ URL::to('/language') }}/{{ $available_locale }}">
                <img src="{{ asset('public/assets/images/flags/' . ($flagImages[$available_locale] ?? 'us.png')) }}" 
                     alt="{{ $available_locale }}" width="24" height="24">
                <span class="ml-1">{{ $locale_name }}</span>
              </a>
              @endforeach
            </div>
          </div>
          @endif

          <!-- Mobile Hamburger (Visible on small screens only) -->
          <button class="navbar-toggler hamburger ml-2 d-lg-none" type="button" data-toggle="collapse" data-target="#navbarMobileMenu">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
            </span>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Collapse -->
    <div class="collapse d-lg-none" id="navbarMobileMenu">
      <div class="bg-light">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">{{ __('Shop') }}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/pricing') }}">{{ __('Pricing') }}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">{{ __('About') }}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">{{ __('Contact') }}</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
