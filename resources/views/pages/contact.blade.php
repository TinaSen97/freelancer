<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $allsettings->site_title }} - {{ __('Contact') }}</title>
  @include('meta')
  @include('style')
  @if($addition_settings->site_google_recaptcha == 1)
    {!! RecaptchaV3::initJs() !!}
  @endif

  <!-- Custom Styles for a Modern, Sleek Look with Animations -->
  <style>
    /* General Fade In Animation */
    .fade-in {
      opacity: 0;
      animation: fadeIn 1s ease-in-out forwards;
    }
    @keyframes fadeIn {
      to { opacity: 1; }
    }

    /* Header Banner Section */
    section.bg-position-center-top {
      background-size: cover;
      background-position: center;
      position: relative;
    }
    section.bg-position-center-top::after {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 1;
    }
    section.bg-position-center-top .container {
      position: relative;
      z-index: 2;
    }

    /* Cards Hover Animation */
    .hover-animate {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .hover-animate:hover {
      transform: scale(1.03);
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    /* Contact Form Animation */
    #contact_form {
      animation: slideInUp 0.8s ease-out both;
    }
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Iframe Full Height */
    .iframe-full-height-wrap {
      position: relative;
      overflow: hidden;
      height: 100%;
    }
    .iframe-full-height {
      border: 0;
      width: 100%;
      height: 100%;
      min-height: 300px;
    }

    /* Footer Custom Styling */
    .footer-modern {
      background: {{ $allsettings->site_header_color }} !important;
      color: #ffffff;
    }
    .footer-modern a {
      color: #ffffff;
      transition: color 0.3s;
    }
    .footer-modern a:hover {
      color: #f1c40f;
      text-decoration: none;
    }
    /* Social Buttons */
    .social-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      background: rgba(255, 255, 255, 0.1);
      margin-right: 8px;
      transition: background 0.3s;
    }
    .social-btn:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    /* Scroll-to-Top Button (Smooth & Animated) */
    .btn-scroll-top {
      position: fixed;
      bottom: 20px;
      right: 10px!important;
      background: #01c064;
      color: #ffffff;
      border-radius: 50%;
      padding: 10px 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: opacity 0.3s, visibility 0.3s, transform 0.3s, background 0.3s;
      z-index: 999;
      border: none;
      opacity: 0;
      visibility: hidden;
      transform: translateY(20px);
    }
    .btn-scroll-top.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .btn-scroll-top:hover {
      background: #ffffff;
      color: #01c064;
    }
    /* Cookie Alert */
    .cookiealert {
      background: #343a40;
      color: #ffffff;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      padding: 15px;
      z-index: 1050;
      text-align: center;
    }
    .input-group-text { border-radius: unset; }

    /* Increase spacing between footer widget links */
    .widget-list-item {
      margin-right: 20px;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
      .social-btn {
        width: 35px;
        height: 35px;
        font-size: 16px;
        margin-right: 6px;
      }
      .btn-scroll-top {
        bottom: 15px;
        right: 10px;
        padding: 8px 10px;
      }
      .footer-modern { text-align: center; }
      /* Make iframe full height on mobile */
      .iframe-full-height {
        min-height: 250px;
      }
    }
  </style>
</head>
<body class="fade-in">
  @include('header')

  <!-- Banner Section with Background Image and Overlay -->
  <section class="bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="py-4">
      <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
              <li class="breadcrumb-item">
                <a class="text-nowrap" href="{{ URL::to('/') }}">
                  <i class="dwg-home"></i>{{ __('Home') }}
                </a>
              </li>
              <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Contact') }}</li>
            </ol>
          </nav>
        </div>
        <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
          <h1 class="h3 mb-0 text-white">{{ __('Contact') }}</h1>
        </div>
      </div>
    </div>
  </section>

  <!-- Outlet Stores/Contact Info Section -->
  <section class="container pt-grid-gutter fade-in">
    <div class="row">
      @if($addition_settings->site_address_display == 1)
      <div class="col-xl-4 col-md-6 mb-grid-gutter">
        <a class="card hover-animate" href="#map" data-scroll>
          <div class="card-body text-center">
            <i class="dwg-location h3 mt-2 mb-4 text-primary"></i>
            <h3 class="h6 mb-2">{{ __('Office Address') }}</h3>
            <p class="font-size-sm text-muted">{{ $allsettings->office_address }}</p>
            <div class="font-size-sm text-primary">
              {{ __('Click to see map') }} <i class="czi-arrow-right align-middle ml-1"></i>
            </div>
          </div>
        </a>
      </div>
      @endif
      @if($addition_settings->site_email_display == 1)
      <div class="col-xl-4 col-md-6 mb-grid-gutter">
        <div class="card hover-animate">
          <div class="card-body text-center">
            <i class="dwg-mail h3 mt-2 mb-4 text-primary"></i>
            <h3 class="h6 mb-3">{{ __('Email') }}</h3>
            <p class="font-size-sm text-muted">{{ $allsettings->office_email }}</p>
          </div>
        </div>
      </div>
      @endif
      @if($addition_settings->site_phone_display == 1)
      <div class="col-xl-4 col-md-6 mb-grid-gutter">
        <div class="card hover-animate">
          <div class="card-body text-center">
            <i class="dwg-phone h3 mt-2 mb-4 text-primary"></i>
            <h3 class="h6 mb-2">{{ __('Phone Number') }}</h3>
            <p class="font-size-sm text-muted">{{ $allsettings->office_phone }}</p>
          </div>
        </div>
      </div>
      @endif
    </div>
  </section>

  <!-- Map and Contact Form Section -->
  <div class="container-fluid px-0 fade-in" id="map">
    <div class="row no-gutters">
      <div class="col-lg-6 iframe-full-height-wrap">
        <iframe class="iframe-full-height" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q={{ $allsettings->office_address }}&ie=UTF8&t=&z=14&iwloc=B&output=embed"></iframe>
      </div>
      <div class="col-lg-6 px-4 px-xl-5 py-5 border-top">
        <h2 class="h4 mb-4">{{ __('Write To Us') }}</h2>
        <form method="POST" action="{{ route('contact') }}" id="contact_form" class="needs-validation" novalidate>
          @csrf
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cf-name">{{ __('Name') }} <span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="from_name" name="from_name" placeholder="John Doe" data-bvalidator="required">
                <div class="invalid-feedback">{{ __('Please fill in your full name') }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cf-email">{{ __('Email') }} <span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="cf-email" name="from_email" placeholder="johndoe@email.com" data-bvalidator="email,required">
                <div class="invalid-feedback">{{ __('Please provide a valid email address') }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cf-phone">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="cf-phone" name="from_phone" placeholder="+1 (212) 00 000 000" data-bvalidator="required">
                <div class="invalid-feedback">{{ __('Please provide a valid phone number') }}</div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="cf-subject">{{ __('Subject') }}</label>
                <input class="form-control" type="text" id="cf-subject" name="subject" placeholder="{{ __('Provide a short title for your request') }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="cf-message">{{ __('Message') }} <span class="text-danger">*</span></label>
            <textarea class="form-control" id="cf-message" rows="6" name="message_text" placeholder="{{ __('Please describe your request in detail') }}" data-bvalidator="required"></textarea>
            <div class="invalid-feedback">{{ __('Please write a message') }}</div>
          </div>
          @if($addition_settings->site_google_recaptcha == 1)
            <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
              {!! RecaptchaV3::field('register') !!}
              @if ($errors->has('g-recaptcha-response'))
                <span class="help-block">
                  <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                </span>
              @endif
            </div>
          @endif
          <button class="btn btn-primary capital" type="submit">{{ __('Send Message') }}</button>
        </form>
      </div>
    </div>
  </div>
      
  <!-- Optional Ads Section -->
  <div class="container px-0" id="map">
    @if(in_array('contact',$top_ads))
      <div class="row">
        <div class="col-lg-12 mt-4 text-center">
          @php echo html_entity_decode($addition_settings->top_ads); @endphp
        </div>
      </div>   
    @endif
    @if(in_array('contact',$bottom_ads))
      <div class="row">
        <div class="col-lg-12 mt-2 mb-2 text-center">
          @php echo html_entity_decode($addition_settings->bottom_ads); @endphp
        </div>
      </div>   
    @endif
  </div>

  @include('footer')
  @include('script')

  <!-- Scroll to Top Button with Animated Appearance and Updated Icon -->
  <a class="btn-scroll-top" href="#top" data-bs-scroll>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 12a.5.5 0 0 0 .5-.5V6.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 6.707V11.5A.5.5 0 0 0 8 12z"/>
    </svg>
  </a>

  <!-- JavaScript to Toggle Scroll-to-Top Button Visibility and Enable Smooth Scroll -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var btnScrollTop = document.querySelector('.btn-scroll-top');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 200) {
          btnScrollTop.classList.add('show');
        } else {
          btnScrollTop.classList.remove('show');
        }
      });
      btnScrollTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>
