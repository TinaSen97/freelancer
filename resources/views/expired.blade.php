<section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
      <div class="py-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-star">
              <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Subscription') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Subscription') }}</h1>
        </div>
      </div>
      </div>
    </section>
    <div class="container py-5 mt-md-2 mb-2">
      <div class="row">
        <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200" align="center">
            @if(Auth::guard('freelancer')->check())
                <h4>
                    {{ __('Your subscription has been expired. Please renew your') }} 
                    <a href="{{ URL::to('/freelancer-subscription') }}">{{ __('Subscription') }}</a>
                </h4><br/>
            @elseif(!Auth::check())
                <h4>
                    {{ __('Your subscription has been expired. Please renew your') }} 
                    <a href="{{ URL::to('/subscription') }}">{{ __('Subscription') }}</a>
                </h4><br/>
            @else
                <h4>
                    {{ __('Your subscription has been expired. Please renew your') }} 
                    <a href="{{ URL::to('/subscription') }}">{{ __('Subscription') }}</a>
                </h4><br/>
            @endif
         </div>
      </div>
    </div>