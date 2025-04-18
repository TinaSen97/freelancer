<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $addition_settings->site_home_title }} - {{ $allsettings->site_title }}</title>
  @include('meta')
  @include('style')
  <!-- AOS CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  
  <!-- Global Custom Styles (if any) -->
  <style>
    /* Global resets and common classes */
    *, *::before, *::after { box-sizing: border-box; }
    html, body { overflow-x: hidden; }
    @media (min-width: 1200px) {
    .container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 1300px!important;
    }
}
  </style>
</head>
<body style="background-color: #f8f9fa;">
  @include('header')
  
  <!-- Main content -->
  @yield('content')
  
  @include('footer')
  @include('script')
  
  <!-- AOS JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, easing: 'ease-out', once: true });
  </script>
  <!-- Additional JavaScript -->
<script>
  AOS.init({
    duration: 800,
    easing: 'ease-out',
    once: true
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Show welcome popup after 3 seconds
    setTimeout(function() {
      var promoPopup = document.getElementById('my-welcome-message');
      if (promoPopup) {
        promoPopup.style.display = 'block';
      }
    }, 3000);

    // Allow cookies button functionality
    var allowCookiesBtn = document.getElementById('allow-cookies-button');
    if (allowCookiesBtn) {
      allowCookiesBtn.addEventListener('click', function() {
        document.getElementById('my-welcome-message').style.display = 'none';
      });
    }
    
    // Close popup button functionality
    var closeBtn = document.getElementById('close-popup');
    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        document.getElementById('my-welcome-message').style.display = 'none';
      });
    }

    // Change header style on scroll
    var header = document.querySelector('header');
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  })

</script>

</body>
</html>
