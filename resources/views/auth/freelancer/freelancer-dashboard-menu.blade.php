<div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-2 mb-5 mb-lg-0">
  <div class="px-4 mb-4">
    <div class="media align-items-center">
      <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
      @if(!empty(Auth::user()->user_photo))
      <img class="lazy rounded-circle" width="102" height="102" src="{{ url('/') }}/public/storage/users/{{ Auth::user()->user_photo }}"  alt="{{ Auth::user()->name }}">
      @endif
      </div>
      <div class="media-body pl-3">
        <h3 class="font-size-base mb-0">
        
  
      </div>
    </div>
  </div>
  <div class="d-lg-block collapse" id="account-menu">    
  <div class="bg-secondary px-4 py-3">
    <h3 class="font-size-sm mb-0 text-muted">{{ __('account') }}</h3>
  </div>
  <ul class="list-unstyled mb-0">
    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ route('freelancer.profile-settings.edit') }}"><i class="dwg-home opacity-60 mr-2"></i>{{ __('Profile') }}</a></li>
    <li class="border-bottom mb-0"><a class="nav-link-style d-flex align-items-center px-4 py-3" href="{{ url('/freelancer/logout') }}"><i class="dwg-sign-out opacity-60 mr-2"></i>{{ __('Logout') }}</a></li>
  </ul>
</div>