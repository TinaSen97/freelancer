{{-- Modernized Footer and Flash Message Section --}}
{{-- Make sure to include Bootstrap 5 CSS and JS in your main layout --}}

<!-- Custom Styles for a Modern Look -->
<style>
  /* Footer Modern Styling */
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
      right: 10px!important; /* slight gap from the right edge */
      background: #01c064;
      color: #ffffff;
      border-radius: 50%;
      padding: 10px 12px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      transition: opacity 0.3s, visibility 0.3s, transform 0.3s, background 0.3s;
      z-index: 999;
      border: none;
      /* Start hidden and moved down a bit for slide-up effect */
      opacity: 0;
      visibility: hidden;
      transform: translateY(20px);
  }
  /* When the scroll-to-top button should be visible, add the 'show' class */
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
  .input-group-text {
    border-radius: unset;
  }
  /* Increase spacing between the widget links */
  .widget-list-item {
      margin-right: 20px;  /* Adjust this value for more or less spacing */
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
      .footer-modern {
          text-align: center;
      }
  }
</style>

<!-- Toast Notifications for Success, Error and Validation Messages -->
@if ($message = Session::get('success'))
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
  <div class="toast fade show mb-3" id="cart-toast-success" data-bs-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <i class="dwg-check-circle me-2"></i>
      <strong class="me-auto">{{ __('Success!') }}</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ $message }}
    </div>
  </div>
</div>
@endif 

@if ($message = Session::get('error'))
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
  <div class="toast fade show mb-3" id="cart-toast-error" data-bs-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-danger text-white">
      <i class="dwg-close-circle me-2"></i>
      <strong class="me-auto">{{ __('Error!') }}</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ $message }}
    </div>
  </div>
</div>
@endif

@if (!$errors->isEmpty())
<div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
  <div class="toast fade show mb-3" id="cart-toast-error" data-bs-delay="5000" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-danger text-white">
      <i class="dwg-close-circle me-2"></i>
      <strong class="me-auto">{{ __('Error!') }}</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  </div>
</div>
@endif

<!-- Footer Section -->
<footer class="footer-modern pt-5">
  <div class="container pt-2 pb-3">
    <div class="row">
      <!-- Logo and Social Icons -->
      <div class="col-md-4  text-md-start mb-4">
        <div class="mb-3">
          <a class="d-inline-block align-middle mt-n2 me-2" href="{{ URL::to('/') }}">
            @if($addition_settings->site_footer_logo != '')
            <img class="d-block lazy" width="150" height="43" src="{{ url('/') }}/public/storage/settings/{{ $addition_settings->site_footer_logo }}" alt="{{ $allsettings->site_title }}"/>
            @endif
          </a>
        </div>
        <div class="mt-4  text-md-start">
          @if($allsettings->facebook_url != '')
          <a class="social-btn sb-light sb-facebook" href="{{ $allsettings->facebook_url }}" target="_blank"><i class="dwg-facebook"></i></a>
          @endif
          @if($allsettings->twitter_url != '')
          <a class="social-btn sb-light sb-twitter" href="{{ $allsettings->twitter_url }}" target="_blank"><i class="dwg-twitter"></i></a>
          @endif
          @if($allsettings->pinterest_url != '')
          <a class="social-btn sb-light sb-pinterest" href="{{ $allsettings->pinterest_url }}" target="_blank"><i class="dwg-pinterest"></i></a>
          @endif
          @if($allsettings->gplus_url != '')
          <a class="social-btn sb-light sb-dribbble" href="{{ $allsettings->gplus_url }}" target="_blank"><i class="dwg-google"></i></a>
          @endif
          @if($allsettings->linkedin_url != '')
          <a class="social-btn sb-light sb-behance" href="{{ $allsettings->linkedin_url }}" target="_blank"><i class="dwg-linkedin"></i></a>
          @endif
          @if($allsettings->instagram_url != '')
          <a class="social-btn sb-light sb-behance" href="{{ $allsettings->instagram_url }}" target="_blank"><i class="dwg-instagram"></i></a>
          @endif
        </div>
      </div>
      <!-- Desktop Menus Only (Categories & More Info) -->
      <div class="col-md-2 d-none d-md-block  text-md-start mb-4">
        <div class="widget widget-links widget-light pb-2">
          <h3 class="widget-title text-light">{{ __('Categories') }}</h3>
          <ul class="widget-list list-unstyled">
            @foreach($maincategory as $category)
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/shop/category/') }}/{{ $category->category_slug }}">{{ $category->category_name }}</a>
            </li> 
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-2 d-none d-md-block  text-md-start mb-4">
        <div class="widget widget-links widget-light pb-2">
          <h3 class="widget-title text-light">{{ __('More Info') }}</h3>
          <ul class="widget-list list-unstyled">
            @if($allsettings->site_blog_display == 1)
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/blog') }}">{{ __('Blog') }}</a>
            </li>
            @endif
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/contact') }}">{{ __('Contact') }}</a>
            </li>
            @if($addition_settings->subscription_mode == 1)
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/subscription') }}">{{ __('Subscription') }}</a>
            </li>
            @endif
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/shop') }}">{{ __('Shop') }}</a>
            </li>
            @if(Auth::guest())
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/favourites') }}">{{ __('Favourites') }}</a>
            </li>
            <li class="widget-list-item">
              <a class="widget-list-link" href="{{ URL::to('/purchases') }}">{{ __('Purchases') }}</a>
            </li>
            @endif
            @if (Auth::check())
              @if(Auth::user()->id != 1)
              <li class="widget-list-item">
                <a class="widget-list-link" href="{{ URL::to('/favourites') }}">{{ __('Favourites') }}</a>
              </li>
              <li class="widget-list-item">
                <a class="widget-list-link" href="{{ URL::to('/purchases') }}">{{ __('Purchases') }}</a>
              </li>
              @endif
            @endif 
          </ul>
        </div>
      </div>
      <!-- Newsletter Section (Centered & Input/Button on Separate Lines) -->
      @if($allsettings->site_newsletter_display == 1)
      <div class="col-md-4">
        <div class="widget pb-2 mb-4 ">
          <h3 class="widget-title text-light pb-1">{{ __('NEWSLETTER') }}</h3>
          <form class="validate" action="{{ route('newsletter') }}" method="post" id="footer_form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="mb-2">
              <input type="email" class="form-control d-block mx-auto" style="max-width: 300px;" placeholder="{{ __('Enter your email') }}" name="news_email" required>
            </div>
            <div class="mb-2">
              <button class="btn btn-primary d-block mx-auto" type="submit">{{ __('Subscribe') }}</button>
            </div>
            <small class="form-text text-light opacity-50">{{ $allsettings->site_newsletter }}</small>
          </form>
        </div>
      </div>
      @endif
    </div>
  </div>
  <div class="pt-4 bg-darker">
    <div class="container">
      <div class="d-md-flex justify-content-between align-items-center">
        <div class="pb-4 font-size-xs text-light opacity-50  text-md-start">
          &copy; {{ date('Y') }}  {{ $allsettings->site_title }}
        </div>
        <div class="widget widget-links widget-light pb-4">
          <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start list-unstyled mb-0">
            @foreach($footerpages['pages'] as $pages)
            <li class="widget-list-item me-4">
              <a class="widget-list-link font-size-ms" href="{{ URL::to('/') }}/{{ $pages->page_slug }}">{{ $pages->page_title }}</a>
            </li>
            @endforeach  
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- Cookie Popup -->
@if($allsettings->cookie_popup == 1)
<div class="alert cookiealert" role="alert">
    {{ $allsettings->cookie_popup_text }}
    <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
        {{ $allsettings->cookie_popup_button }}
    </button>
</div>
@endif

<!-- Scroll to Top Button with Animated Appearance and Updated Icon -->
<a class="btn-scroll-top" href="#top" data-bs-scroll>
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 12a.5.5 0 0 0 .5-.5V6.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 6.707V11.5A.5.5 0 0 0 8 12z"/>
  </svg>
</a>

<!-- JavaScript to Toggle Scroll-to-Top Button Visibility and Enable Smooth Scroll -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get the scroll-to-top button element
    var btnScrollTop = document.querySelector('.btn-scroll-top');

    // Listen for scroll events on the window
    window.addEventListener('scroll', function() {
      // If the user scrolls more than 200px, add the "show" class to display the button with animation
      if (window.scrollY > 200) {
        btnScrollTop.classList.add('show');
      } else {
        btnScrollTop.classList.remove('show');
      }
    });

    // When the button is clicked, smoothly scroll to the top of the page
    btnScrollTop.addEventListener('click', function(e) {
      e.preventDefault(); // Prevent the default anchor behavior
      window.scrollTo({
        top: 0,
        behavior: 'smooth'  // Smooth scroll effect
      });
    });
  });
</script>
