<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scrolling Columns with Repeating Images & Overlays</title>
  <!-- Bootstrap (Optional) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- (Optional) FontAwesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    /* Basic reset */
    * { box-sizing: border-box; }
    body {
      margin: 0;
      font-family: "Helvetica Neue", Arial, sans-serif;
      background-color: #ffffff;
      color: #333;
    }
    /* ====== Hero Section ====== */
    .hero-section {
      position: relative;
      padding: 60px 0;
      background: #f5f5f5;
      overflow: hidden;
    }
    /* ====== Left Text Column ====== */
    .hero-content .tagline {
      font-size: 2.1rem;
      color: #000;
      margin-bottom: 0px;
      font-weight:700;
      line-height: 2.1rem;
    }
    .hero-content .main-heading {
      font-size: 6.3rem;
      font-weight: 700;
      color: #111;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    /* "code" portion less bold */
    .main-heading .lighter-code { font-weight: 500; }
    .hero-content .sub-description {
      font-size: 1.45rem;
      color: #555;
      line-height: 1.6;
      max-width: 600px;
      font-weight: 700;
    }
    .hero-content .sub-description span.extra {
      display: block;
      margin-top: 10px;
      font-size: 1rem;
      color: #666;
    }
    /* ====== Two Scrolling Columns (Right Side) ====== */
    .scrolling-images-wrapper { display: flex; gap: 20px; }
    .scrolling-images-column {
      flex: 1; height: 500px; overflow: hidden; position: relative;
    }
    .scrolling-images-inner {
      position: absolute; top: 0; left: 0; width: 100%;
      display: flex; flex-direction: column;
      animation: scrollUp 12s linear infinite;
    }
    .scrolling-images-inner img {
      width: 100%; margin-bottom: 20px;
      border-radius: 8px; object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    @keyframes scrollUp {
      0%   { transform: translateY(0%); }
      100% { transform: translateY(-50%); }
    }
    /* Fading overlays for each column */
    .scrolling-images-column::before,
    .scrolling-images-column::after {
      content: "";
      position: absolute;
      left: 0; right: 0;
      height: 80px;
      z-index: 2;
      pointer-events: none;
    }
    .scrolling-images-column::before {
      top: 0;
      background: linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
    }
    .scrolling-images-column::after {
      bottom: 0;
      background: linear-gradient(to top, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
    }
    /* ====== Search Section ====== */
    .search-section {
      text-align: center;
      padding: 40px 0;
      background: #f5f5f5;
    }
    .search-section h3 {
      font-size: 2rem;
      margin-bottom: 0px;
      min-height: 2.5rem; /* to accommodate typewriter effect */
    }
    /* ====== Search Container ====== */
    /* Default (collapsed) state: no white pill styling */
    #search-container {
      display: inline-flex;
      align-items: center;
      border-radius: 50px;
      transition: all 0.4s ease;
      cursor: pointer;
      padding: 6px 12px;
      width: 100%;
      max-width: 800px; /* Updated container width */
      background: transparent; /* No white background */
      border: none;          /* No border */
      box-shadow: none;      /* No shadow */
    }
    /* Center the content when not active */
    #search-container:not(.active) {
      justify-content: center;
    }
    /* Active state: white pill styling appears */
    #search-container.active {
      background: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      justify-content: flex-start;
    }
    #search-container {
  transition: all 0.4s ease;
  transform: scale(1);
}

#search-container.active {
  transform: scale(1.02);
}

    /* Initially show only the search icon */
    #search-container .dwg-search {
      font-size: 36px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: #000 !important;
    }
    /* Elevate search icon on hover */
    #search-container:hover .dwg-search {
      transform: translateY(-3px);
    }
    /* When active, hide the search icon inside the overlay */
    #search-container.active .hide { display: none; }
    /* Search input hidden by default */
    #search-container input[type="text"] {
      width: 0;
      opacity: 0;
      padding: 0;
      border: none;
      background: transparent;
      transition: width 0.4s ease, opacity 0.4s ease, padding 0.4s ease, transform 0.3s ease;
      margin-left: 5px;
      font-size: 16px;
      color: #333;
      /* Only left side rounded */
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
    }
    /* When active, expand the search input with left rounding only */
    #search-container.active input[type="text"] {
      width: 200px;
      opacity: 1;
      padding: 8px 10px;
      border-top-left-radius: 50px;
      border-bottom-left-radius: 50px;
      border-top-right-radius: 0;
      border-bottom-right-radius: 0;
      margin-right: 5px;
    }
    /* Remove focus border and elevate search input on focus */
    #search-container input[type="text"]:focus {
      outline: none;
      box-shadow: none;
      transform: translateY(-3px);
    }
    #search-container input::placeholder { color: #aaa; }
    /* Divider between search input and category select */
    #search-container.active .divider {
      border-left: 1px solid #ddd;
      margin: 0 10px;
      height: 30px;
    }
    /* Category select and search button hidden by default */
    #search-container select,
    #search-container .input-group-append {
      display: none;
    }
    /* When active, show them inline */
    #search-container.active select,
    #search-container.active .input-group-append {
      display: inline-block;
    }
    /* Reduce text size and increase width in the category dropdown */
    #search-container select {
      font-size: 14px;
      width: 200px;  /* Updated category dropdown width */
    }
    /* Search button styling with icon */
    #search-container .btn-primary {
      background: black;
      border: none !important;
      transition: background 0.3s ease;
      border-radius: 50px;
      border-top-left-radius: 0!important;
    }
    #search-container .btn-primary i {
      font-size: 36px;
      color: #fff!important;
    }
    #search-container .btn-primary:hover { background: #000 !important; }
    /* Hover effect for category select */
    #search-container select:hover {
      background-color: #f8f8f8;
      transition: background-color 0.3s ease;
    }
    /* ====== Responsive Tweak ====== */
    @media (max-width: 992px) {
      .hero-section { padding: 30px 0; }
      .hero-content .main-heading { font-size: 2.2rem; }
      .hero-content .sub-description { font-size: 1rem; }
      .scrolling-images-wrapper { flex-direction: column; }
      .scrolling-images-column { height: 300px; }
    }

    .width70{
      width:60%;
    }

    .width70 h3{
      width:90%;
      float:left;
      display:inline;
    }

    .width70 form{
      float:right;
      display:inline;
      
    }
  </style>


<style>
      *,
*:after,
*:before {
	box-sizing: border-box;
}
:root {
	--transition: 0.25s;
	--spark: 1.8s;
}
      #signup-button {
        --cut: 0.1em;
        --active: 0;
        --bg:
          radial-gradient(
            40% 50% at center 100%,
            hsl(270 calc(var(--active) * 97%) 72% / var(--active)),
            transparent
          ),
          radial-gradient(
            80% 100% at center 120%,
            hsl(260 calc(var(--active) * 97%) 70% / var(--active)),
            transparent
          ),
          hsl(260 calc(var(--active) * 97%) calc((var(--active) * 44%) + 12%));
        background: var(--bg);
        font-size: 2rem;
        font-weight: 500;
        border: 0;
        height: 80px;
        cursor: pointer;
        padding: 0.9em 1.3em;
        display: flex;
        align-items: center;
        gap: 0.25em;
        white-space: nowrap;
        border-radius: 100px;
        position: relative;
        /* box-shadow:
          0 0 calc(var(--active) * 6em) calc(var(--active) * 3em) hsl(260 97% 61% / 0.75),
          0 0.05em 0 0 hsl(260 calc(var(--active) * 97%) calc((var(--active) * 50%) + 30%)) inset,
          0 -0.05em 0 0 hsl(260 calc(var(--active) * 97%) calc(var(--active) * 60%)) inset;
        transition: box-shadow var(--transition), scale var(--transition), background var(--transition); */
        scale: calc(1 + (var(--active) * 0.1));
      }

      #signup-button:active {
        scale: 1;
      }

      svg {
        overflow: visible !important;
      }

      .sparkle path {
        color: hsl(0 0% calc((var(--active, 0) * 70%) + var(--base)));
        transform-box: fill-box;
        transform-origin: center;
        fill: currentColor;
        stroke: currentColor;
        animation-delay: calc((var(--transition) * 1.5) + (var(--delay) * 1s));
        animation-duration: 0.6s;
        transition: color var(--transition);
      }

      #signup-button:is(:hover, :focus-visible) path {
        animation-name: bounce;
      }

      @keyframes bounce {
        35%, 65% {
          scale: var(--scale);
        }
      }
      .sparkle path:nth-of-type(1) {
        --scale: 0.5;
        --delay: 0.1;
        --base: 40%;
      }

      .sparkle path:nth-of-type(2) {
        --scale: 1.5;
        --delay: 0.2;
        --base: 20%;
      }

      .sparkle path:nth-of-type(3) {
        --scale: 2.5;
        --delay: 0.35;
        --base: 30%;
      }

      #signup-button:before {
        content: "";
        position: absolute;
        inset: -0.25em;
        z-index: -1;
        border: 0.25em solid hsl(260 97% 50% / 0.5);
        border-radius: 100px;
        opacity: var(--active, 0);
        transition: opacity var(--transition);
      }

      .spark {
        position: absolute;
        inset: 0;
        border-radius: 100px;
        rotate: 0deg;
        overflow: hidden;
        mask: linear-gradient(white, transparent 50%);
        animation: flip calc(var(--spark) * 2) infinite steps(2, end);
      }

      @keyframes flip {
        to {
          rotate: 360deg;
        }
      }

      .spark:before {
        content: "";
        position: absolute;
        width: 200%;
        aspect-ratio: 1;
        top: 0%;
        left: 50%;
        z-index: -1;
        translate: -50% -15%;
        rotate: 0;
        transform: rotate(-90deg);
        opacity: calc((var(--active)) + 0.4);
        background: conic-gradient(
          from 0deg,
          transparent 0 340deg,
          white 360deg
        );
        transition: opacity var(--transition);
        animation: rotate var(--spark) linear infinite both;
      }

      .spark:after {
        content: "";
        position: absolute;
        inset: var(--cut);
        border-radius: 100px;
      }

      .backdrop {
        position: absolute;
        inset: var(--cut);
        background: var(--bg);
        border-radius: 100px;
        transition: background var(--transition);
      }

      @keyframes rotate {
        to {
          transform: rotate(90deg);
        }
      }



      @supports(selector(:has(:is(+ *)))) {
        body:has(#signup-button:is(:hover, :focus-visible)) {
          --active: 1;
          --play-state: running;
        }
        .bodydrop {
          display: none;
        }
      }

      #signup-button:is(:hover, :focus-visible) ~ :is(.bodydrop, .particle-pen) {
        --active: 1;
        --play-state: runnin;
      }

      .bodydrop {
        background: hsl(
          260
          calc(var(--active) * 97%)
          6%
        );
        position: fixed;
        inset: 0;
        z-index: -1
      }



      #signup-button:is(:hover, :focus-visible) {
        --active: 1;
        --play-state: running;
      }


      .sparkle-button {
        position: relative;
      }

      .particle-pen {
        position: absolute;
        width: 200%;
        aspect-ratio: 1;
        top: 50%;
        left: 50%;
        translate: -50% -50%;
        -webkit-mask: radial-gradient(white, transparent 65%);
        z-index: -1;
        opacity: var(--active, 0);
        transition: opacity var(--transition);
      }

      .particle {
        fill: white;
        width: calc(var(--size, 0.25) * 1rem);
        aspect-ratio: 1;
        position: absolute;
        top: calc(var(--y) * 1%);
        left: calc(var(--x) * 1%);
        opacity: var(--alpha, 1);
        animation: float-out calc(var(--duration, 1) * 1s) calc(var(--delay) * -1s) infinite linear;
        transform-origin: var(--origin-x, 1000%) var(--origin-y, 1000%);
        z-index: -1;
        animation-play-state: var(--play-state, paused);
      }

      .particle path {
        fill: hsl(0 0% 90%);
        stroke: none;
      }

      .particle:nth-of-type(even) {
        animation-direction: reverse;
      }

      @keyframes float-out {
        to {
          rotate: 360deg;
        }
      }

      .text {
        translate: 2% -6%;
        letter-spacing: 0.01ch;
        background: linear-gradient(90deg, hsl(0 0% calc((var(--active) * 100%) + 65%)), hsl(0 0% calc((var(--active) * 100%) + 26%)));
        -webkit-background-clip: text;
        color: transparent;
        transition: background var(--transition);
      }

      #signup-button svg {
        inline-size: 1.25em;
        translate: -25% -5%;
      }
  </style>
</head>
<body>

  <!-- ====== Banner Section ====== -->
  <section class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <!-- LEFT COLUMN: Tagline, Large Heading, Sub-description -->
        <div class="col-lg-6 col-md-12 hero-content">
          <div class="tagline">Sell AI Digital Goods Effortlessly with</div>
          <h1 class="main-heading">
            <span class="lighter-code">code</span>market
          </h1>
          <p class="sub-description">
            Your Ultimate AI Marketplace for Scripts and Projects
            <span class="extra">
            Discover the future of coding with CodeMarket! Dive into thousands of AI code templates, scripts, and projects crafted by our global community of top developers and designers.
            </span>
          </p>
          <div class="sparkle-button">
                    <button id="signup-button" onclick='window.location.href="/login"'>
                      <span class="spark"></span>
                      <!-- <span class="spark"></span> -->
                      <span class="backdrop"></span>
                      <svg class="sparkle" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z" fill="black" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      <span class="text">Get Started</span>
                    </button>
                    
          </div>
        </div>
        <!-- RIGHT COLUMN: Scrolling Images -->
        <div class="col-lg-6 col-md-12 mt-4 mt-lg-0">
          <div class="scrolling-images-wrapper">
            <!-- First Column: repeated images for seamless loop -->
            <div class="scrolling-images-column">
              <div class="scrolling-images-inner">
                <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?q=80&w=1474&auto=format&fit=crop" alt="Image 1">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1472&auto=format&fit=crop" alt="Image 2">
                <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?q=80&w=1474&auto=format&fit=crop" alt="Image 1 again">
                <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=1472&auto=format&fit=crop" alt="Image 2 again">
              </div>
            </div>
            <!-- Second Column: repeated images in reverse order -->
            <div class="scrolling-images-column">
              <div class="scrolling-images-inner">
                <img src="https://plus.unsplash.com/premium_photo-1683121710572-7723bd2e235d?q=80&w=1632&auto=format&fit=crop" alt="Image 4">
                <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?q=80&w=1470&auto=format&fit=crop" alt="Image 3">
                <img src="https://plus.unsplash.com/premium_photo-1683121710572-7723bd2e235d?q=80&w=1632&auto=format&fit=crop" alt="Image 4 again">
                <img src="https://images.unsplash.com/photo-1432821596592-e2c18b78144f?q=80&w=1470&auto=format&fit=crop" alt="Image 3 again">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
      const RANDOM = (min, max) => Math.floor(Math.random() * (max - min + 1) + min)
      const PARTICLES = document.querySelectorAll('.particle')
      PARTICLES.forEach(P => {
        P.setAttribute('style', `
          --x: ${RANDOM(20, 80)};
          --y: ${RANDOM(20, 80)};
          --duration: ${RANDOM(6, 20)};
          --delay: ${RANDOM(1, 10)};
          --alpha: ${RANDOM(40, 90) / 100};
          --origin-x: ${Math.random() > 0.5 ? RANDOM(300, 800) * -1 : RANDOM(300, 800)}%;
          --origin-y: ${Math.random() > 0.5 ? RANDOM(300, 800) * -1 : RANDOM(300, 800)}%;
          --size: ${RANDOM(40, 90) / 100};
        `)
      })

  </script>

  <!-- ====== Search Section ====== -->
  <section class="search-section">
    <div class="container width70">
      <!-- Heading with typewriter effect -->
      <h3 id="search-heading">Search and discover exactly what you need</h3>
      <form action="#" id="search_form" method="post" class="form-noborder searchbox" enctype="multipart/form-data">
        <!-- @csrf if using Laravel -->
        <div id="search-container" class="input-group input-group-overlay input-group-lg rounded-pill mx-auto">
          <!-- Category Dropdown (always visible when active) -->
          <select name="category_names[]" id="product_cat" class="custom-select home-category-select border-0 bg-light rounded-pill" style="display: none;">
            <option value="">{{ __('All categories') }}</option>
            @foreach($category['view'] as $cat)
              <option value="{{ 'category_'.$cat->cat_id }}">{{ $cat->category_name }}</option>
              @foreach($cat->subcategory as $sub_category)
                <option value="{{ 'subcategory_'.$sub_category->subcat_id }}">- {{ $sub_category->subcategory_name }}</option>
              @endforeach
            @endforeach
          </select>
          <!-- Search Input -->
          <input class="form-control form-control-lg prepended-form-control border-0 bg-light" 
                 type="text" 
                 id="product_item" 
                 name="product_item" 
                 placeholder="">
          <!-- Search Submit Button with icon -->
          <div class="input-group-append" style="display: none;">
            <button class="btn btn-primary btn-lg animated-btn rounded-pill" type="submit">
              <i class="dwg-search"></i>
            </button>
          </div>
          <!-- Initially show search icon on the left -->
          <div class="input-group-prepend-overlay">
            <span class="input-group-text bg-transparent border-0">
              <i class="dwg-search hide"></i>
            </span>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- JavaScript for Typewriter Effects & Search Container Behavior -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // ---------- Typewriter for Search Heading ----------
      var searchHeading = document.getElementById('search-heading');
      var headingText = "Search the template you are looking for";
      var headingIndex = 0;
      var headingDirection = "forward";
      var headingCursor = "|";
      var headingDelay = 100;
      var headingPause = 2000;
      var headingTimeout;
      function typeHeading() {
        if (headingDirection === "forward") {
          if (headingIndex < headingText.length) {
            searchHeading.textContent = headingText.substring(0, headingIndex + 1) + headingCursor;
            headingIndex++;
            headingTimeout = setTimeout(typeHeading, headingDelay);
          } else {
            headingDirection = "backward";
            headingTimeout = setTimeout(typeHeading, headingPause);
          }
        } else {
          if (headingIndex > 0) {
            searchHeading.textContent = headingText.substring(0, headingIndex - 1) + headingCursor;
            headingIndex--;
            headingTimeout = setTimeout(typeHeading, headingDelay);
          } else {
            headingDirection = "forward";
            headingTimeout = setTimeout(typeHeading, headingDelay);
          }
        }
      }
      typeHeading();

      // ---------- Typewriter for Search Input Placeholder ----------
      var searchContainer = document.getElementById('search-container');
      var searchInput = document.getElementById('product_item');
      // Use backend categories for placeholder text (only main categories)
      var placeholderTexts = {!! json_encode($category['view']->pluck('category_name')->toArray()) !!};
      var pIndex = 0, pCharIndex = 0;
      var pDirection = "forward";
      var placeholderCursor = "|";
      var placeholderTypingDelay = 150, placeholderErasingDelay = 100, placeholderPause = 2000;
      var placeholderTimeout;
      function cyclePlaceholder() {
        if (placeholderTexts.length === 0) {
          searchInput.placeholder = "Search what's on your mind" + placeholderCursor;
          return;
        }
        var currentText = placeholderTexts[pIndex];
        if (pDirection === "forward") {
          if (pCharIndex < currentText.length) {
            searchInput.placeholder = currentText.substring(0, pCharIndex + 1) + placeholderCursor;
            pCharIndex++;
            placeholderTimeout = setTimeout(cyclePlaceholder, placeholderTypingDelay);
          } else {
            pDirection = "backward";
            placeholderTimeout = setTimeout(cyclePlaceholder, placeholderPause);
          }
        } else {
          if (pCharIndex > 0) {
            searchInput.placeholder = currentText.substring(0, pCharIndex - 1) + placeholderCursor;
            pCharIndex--;
            placeholderTimeout = setTimeout(cyclePlaceholder, placeholderErasingDelay);
          } else {
            pIndex = (pIndex + 1) % placeholderTexts.length;
            pDirection = "forward";
            placeholderTimeout = setTimeout(cyclePlaceholder, placeholderTypingDelay);
          }
        }
      }
      
      // ---------- Search Container Behavior ----------
      var typewriterActive = false;
      searchContainer.addEventListener('click', function(e) {
        this.classList.add('active');
        searchInput.focus();
        // Show category select and submit button; hide the initial search icon overlay
        var categorySelect = document.getElementById('product_cat');
        var appendDiv = this.querySelector('.input-group-append');
        if(categorySelect) categorySelect.style.display = 'inline-block';
        if(appendDiv) appendDiv.style.display = 'inline-block';
        if (!typewriterActive) {
          typewriterActive = true;
          cyclePlaceholder();
        }
        e.stopPropagation();
      });
      
      // Prevent closing when clicking inside the select
      var productCat = document.getElementById('product_cat');
      if (productCat) {
        productCat.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
      
      // Deactivate on outside click
      document.addEventListener('click', function(e) {
        if (!searchContainer.contains(e.target)) {
          searchContainer.classList.remove('active');
          searchInput.placeholder = "Search what's on your mind";
          typewriterActive = false;
          clearTimeout(placeholderTimeout);
          pIndex = 0; pCharIndex = 0; pDirection = "forward";
          var categorySelect = document.getElementById('product_cat');
          var appendDiv = searchContainer.querySelector('.input-group-append');
          if(categorySelect) categorySelect.style.display = 'none';
          if(appendDiv) appendDiv.style.display = 'none';
        }
      });
      
      // Periodic hover animation for the search icon (only when not active)
      setInterval(function() {
        if (!searchContainer.classList.contains('active')) {
          var searchIcon = searchContainer.querySelector('.dwg-search');
          if (searchIcon) {
            searchIcon.classList.add('hover-animation');
            setTimeout(function() {
              searchIcon.classList.remove('hover-animation');
            }, 600);
          }
        }
      }, 3000);
    });
  </script>

  <!-- Bootstrap JS (Optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
