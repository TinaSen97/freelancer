<!DOCTYPE HTML>
<html lang="en">

<head>
  <title>{{ $addition_settings->site_home_title }} - {{ $allsettings->site_title }}</title>
  @include('meta')
  @include('style')
  <style>
    /* ---------------------------------------------------------
       BASE & EXISTING STYLES
    --------------------------------------------------------- */
    .rounded-pill {
      border-radius: 50rem !important;
    }
    .rounded-left-pill {
      border-top-left-radius: 50rem !important;
      border-bottom-left-radius: 50rem !important;
    }
    /* Category Select Styling */
    .home-category-select {
      background-color: #f8f9fa !important;
      border: none !important;
      margin-left: 0 !important;
      border-top-left-radius: 0 !important;
      border-bottom-left-radius: 0 !important;
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    .home-category-select:hover,
    .home-category-select:focus {
      background: linear-gradient(to right, #01c064, #00c853) !important;
      color: #fff !important;
    }
    .home-category-select option {
      background-color: #fff;
      color: #333;
    }
    .home-category-select option:hover {
      background: #01c064;
      color: #fff;
    }
    .prepended-form-control {
      padding-left: 40px !important;
      background-color: #f8f9fa !important;
      border: none !important;
      border-top-right-radius: 0 !important;
      border-bottom-right-radius: 0 !important;
    }
    .input-group-prepend-overlay {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 4;
    }
    #search_form .prepended-form-control {
      border-top-left-radius: 50rem !important;
      border-bottom-left-radius: 50rem !important;
      border-right: 2px solid #03a84e !important;
    }
    .input-group-append {
      display: flex;
      align-items: center;
      margin-left: 5px;
    }

    /* ---------------------------------------------------------
       MODERN BUTTON & INPUT FOCUS STYLES
    --------------------------------------------------------- */
    .btn-primary {
      background: linear-gradient(45deg, #03a84e, #00c853) !important;
      border: none !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease !important;
    }
    .btn-primary:hover {
      background: linear-gradient(45deg, #00c853, #03a84e) !important;
      color: #fff !important;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .input-group .form-control:focus {
      box-shadow: none;
      border-color: #03a84e;
    }

    /* ---------------------------------------------------------
       NEW MODERN & ANIMATED STYLES
    --------------------------------------------------------- */
    .bg-banner {
      position: relative;
      overflow: hidden;
    }
    .bg-banner::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(180deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7));
      z-index: 1;
    }
    .bg-banner > * {
      position: relative;
      z-index: 2;
    }
    .product-card-alt {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      background-color: #fff;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card-alt:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    .product-thumb img {
      transition: transform 0.5s ease;
    }
    .product-thumb:hover img {
      transform: scale(1.05);
    }
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .section-animate {
      animation: fadeInUp 0.8s ease-out both;
    }
    header {
      transition: background 0.5s ease;
    }
    header.scrolled {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    #my-welcome-message {
      animation: slideDown 1s ease-out;
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translateX(-50%);
      z-index: 1050;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      max-width: 90%;
      overflow: hidden;
    }
    @keyframes slideDown {
      0% {
        opacity: 0;
        transform: translate(-50%, -50px);
      }
      100% {
        opacity: 1;
        transform: translate(-50%, 0);
      }
    }

    /* ---------------------------------------------------------
       NEW STATIC COMPONENTS
    --------------------------------------------------------- */
    /* POPULAR CATEGORIES SECTION (Dynamic: First 4 from $categories['menu'])
       Now using these four images in the given order as placeholders:
         1. public/assets/images/blocakchain.png
         2. public/assets/images/web.webp
         3. public/assets/images/fintech.png
         4. public/assets/images/api-integration.webp
    */
    .categories-section {
      padding: 60px 0;
      background-color: #f1f1f1;
      text-align: center;
    }
    .categories-section h2 {
      font-size: 32px;
      margin-bottom: 30px;
      font-weight: bold;
      color: #01c064;
    }
    .category-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .category-box {
      background: #fff;
      border: 2px solid #eee;
      border-radius: 10px;
      overflow: hidden;
      width: 220px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .category-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .category-box img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }
    .category-box h4 {
      margin: 10px 0;
      color: #01c064;
      font-size: 18px;
    }
    /* CTA BANNER SECTION */
    .cta-banner {
      position: relative;
      background-color: blue;
      background-size: cover;
      background-position: center;
      padding: 80px 0;
      text-align: center;
      color: #fff;
    }
    .cta-banner h2 {
      font-size: 36px;
      margin-bottom: 20px;
    }
    .cta-banner p {
      font-size: 18px;
      margin-bottom: 30px;
    }
    .cta-banner .btn {
      background: #fff;
      color: #01c064;
      border-radius: 50px;
      padding: 12px 30px;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .cta-banner .btn:hover {
      background: #f0f0f0;
    }
    /* SERVICES SECTION */
    .services-section {
      padding: 60px 0;
      background-color: #f9f9f9;
      text-align: center;
    }
    .services-section h2 {
      font-size: 32px;
      margin-bottom: 20px;
      font-weight: bold;
    }
    .services-section p {
      max-width: 600px;
      margin: 0 auto 40px;
      color: #666;
    }
    .service-card {
      background: #fff;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      margin-bottom: 30px;
    }
    .service-card:hover {
      transform: translateY(-5px);
    }
    .service-icon {
      font-size: 48px;
      color: #03a84e;
      margin-bottom: 20px;
    }
    .service-card h4 {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .service-card p {
      font-size: 14px;
      color: #777;
    }
    /* TESTIMONIALS SECTION */
    .testimonials-section {
      padding: 60px 0;
      background-color: #fff;
      text-align: center;
    }
    .testimonials-section h2 {
      font-size: 32px;
      margin-bottom: 40px;
      font-weight: bold;
    }
    .testimonial-card {
      background: #f1f1f1;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      margin-bottom: 30px;
    }
    .testimonial-card:hover {
      transform: scale(1.02);
    }
    .testimonial-text {
      font-style: italic;
      margin-bottom: 15px;
      font-size: 15px;
      color: #555;
    }
    .testimonial-author {
      font-weight: bold;
      color: #03a84e;
      font-size: 16px;
    }
    /* NEWSLETTER SECTION */
    .newsletter-section {
      padding: 60px 0;
      background: linear-gradient(90deg, #03a84e, #00c853);
      color: #fff;
      text-align: center;
    }
    .newsletter-section h2 {
      margin-bottom: 20px;
      font-size: 28px;
      font-weight: bold;
    }
    .newsletter-section p {
      margin-bottom: 30px;
      font-size: 16px;
    }
    .newsletter-form input {
      padding: 12px 20px;
      border: none;
      border-radius: 50px;
      margin-right: 10px;
      width: 300px;
      max-width: 90%;
    }
    .newsletter-form button {
      padding: 12px 30px;
      border: none;
      border-radius: 50px;
      background: #fff;
      color: #03a84e;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .newsletter-form button:hover {
      background: #e0e0e0;
    }
  </style>
</head>

<body>
  @include('header')

  <!-- Banner Section with Gradient Overlay -->
  <section class="bg-banner bg-position-center-top" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="mb-lg-3 pb-4 pt-5">
      <div class="container">
        <div class="row mb-4 mb-sm-5">
          <div class="col-lg-7 col-md-9 text-center mx-auto">
            <h1 class="text-white line-height-base" style="font-weight:bold">{{ $allsettings->site_banner_heading }}</h1>
            <h2 class="h4 text-white font-weight-light">{{ $allsettings->site_banner_subheading }}</h2>
          </div>
        </div>
        <form action="{{ route('shop') }}" id="search_form" method="post" class="form-noborder searchbox" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row mb-4 mb-sm-5">
            <div class="col-lg-7 col-md-7 mx-auto text-center">
              <div class="input-group input-group-overlay input-group-lg rounded-pill rounded-left-pill">
                <div class="input-group-prepend-overlay">
                  <span class="input-group-text bg-transparent border-0">
                    <i class="dwg-search"></i>
                  </span>
                </div>
                <input class="form-control form-control-lg prepended-form-control border-0 bg-light rounded-pill rounded-left-pill"
                  type="text" id="product_item" name="product_item" placeholder="{{ __('Search your products...') }}">
                @if(count($category['view']) != 0)
                <select name="category_names[]" id="product_cat" class="custom-select home-category-select border-0 bg-light rounded-pill ml-2">
                  <option value="">{{ __('All categories') }}</option>
                  @foreach($category['view'] as $cat)
                  <option value="{{ 'category_'.$cat->cat_id }}">{{ $cat->category_name }}</option>
                  @foreach($cat->subcategory as $sub_category)
                  <option value="{{ 'subcategory_'.$sub_category->subcat_id }}">- {{ $sub_category->subcategory_name }}</option>
                  @endforeach
                  @endforeach
                </select>
                @endif
                <div class="input-group-append">
                  <button class="btn btn-primary btn-lg font-size-base rounded-pill" type="submit">{{ __('Search Now') }}</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Top Ads Section -->
  @if(in_array('home', $top_ads))
  <section class="container mb-lg-1" data-aos="fade-up" data-aos-delay="200">
    <div class="row">
      <div class="col-lg-12 mb-1" align="center">
        @php echo html_entity_decode($addition_settings->top_ads); @endphp
      </div>
    </div>
  </section>
  @endif

  <!-- DYNAMIC POPULAR CATEGORIES SECTION (First Four Categories) -->
  @php
    $placeholderImages = [
      asset('public/assets/images/blocakchain.png'),
      asset('public/assets/images/web.webp'),
      asset('public/assets/images/fintech.png'),
      asset('public/assets/images/api-integration.webp'),
    ];
  @endphp
  <section class="categories-section" data-aos="fade-up" data-aos-delay="150">
    <div class="container">
      <h2>Popular Categories</h2>
      <div class="category-grid">
        @if(count($categories['menu']) != 0)
          @foreach($categories['menu'] as $index => $menu)
            @if($index < 4)
              <div class="category-box">
                <a href="{{ URL::to('/shop/category/') }}/{{ $menu->category_slug }}">
                  <img src="{{ $placeholderImages[$index] }}" alt="{{ $menu->category_name }}">
                  <h4>{{ $menu->category_name }}</h4>
                </a>
              </div>
            @endif
          @endforeach
        @endif
      </div>
    </div>
  </section>

  <!-- Featured Items Section -->
  @if(count($featured['items']) != 0)
  <section class="container mb-lg-1" data-aos="fade-up" data-aos-delay="200">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
      <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100">{{ __('Featured Files') }}</h2>
      <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
        <a class="btn btn-outline-accent" href="{{ URL::to('/') }}/featured-items">{{ __('Browse All Items') }}<i class="dwg-arrow-right font-size-ms ml-1"></i></a>
      </div>
    </div>
    <div class="row pt-2 mx-n2 flash-sale">
      @php $no = 1; @endphp
      @foreach($featured['items'] as $featured)
      @php
        $price = Helper::price_info($featured->item_flash, $featured->regular_price);
        $count_rating = Helper::count_rating($featured->ratings);
      @endphp
      <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-grid-gutter">
        <div class="card product-card-alt">
          @if($custom_settings->author_key == Helper::Key_Owner() && $featured->item_flash == 1)
          <div class="ribbon ribbon-top-left"><span>{{ $addition_settings->flash_sale_value }}% {{ __('OFF') }}</span></div>
          @endif
          <div class="product-thumb">
            @if(Auth::guest())
            <a class="btn-wishlist btn-sm" href="{{ url('/') }}/login"><i class="dwg-heart"></i></a>
            @elseif(Auth::check() && $featured->user_id != Auth::user()->id)
            <a class="btn-wishlist btn-sm" href="{{ url('/item') }}/{{ base64_encode($featured->item_id) }}/favorite/{{ base64_encode($featured->item_liked) }}"><i class="dwg-heart"></i></a>
            @endif
            <div class="product-card-actions">
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $featured->item_slug }}"><i class="dwg-eye"></i></a>
              @php $checkif_purchased = Helper::if_purchased($featured->item_token); @endphp
              @if($addition_settings->guest_checkout == 1)
                @if($checkif_purchased == 0)
                  @if($featured->free_download == 0)
                    @if(Auth::check() && Auth::user()->id != 1 && $featured->user_id != Auth::user()->id)
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->item_slug }}"><i class="dwg-cart"></i></a>
                    @elseif(!Auth::check())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $featured->item_slug }}"><i class="dwg-cart"></i></a>
                    @endif
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($featured->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @endif
              @else
                @if($checkif_purchased == 0)
                  @if($featured->free_download == 0)
                    <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $featured->item_slug }}"><i class="dwg-cart"></i></a>
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($featured->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @else
                  <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $featured->item_slug }}"><i class="dwg-cart"></i></a>
                @endif
              @endif
            </div>
            <a class="product-thumb-overlay" href="{{ URL::to('/item') }}/{{ $featured->item_slug }}"></a>
            @if($featured->item_preview != '')
              <img class="lazy" src="{{ Helper::Image_Path($featured->item_preview, 'no-image.png') }}" alt="{{ $featured->item_name }}" width="300" height="200">
            @else
              <img class="lazy" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $featured->item_name }}" width="300" height="200">
            @endif
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
              <div class="text-muted font-size-xs mr-1">
                <a class="product-meta font-weight-medium" href="{{ URL::to('/shop') }}/item-type/{{ $featured->item_type }}">
                  {{ Helper::ItemTypeIdGetData($featured->item_type_id) }}
                </a>
              </div>
              <div class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                  @if($i <= $count_rating)
                    <i class="sr-star dwg-star-filled active"></i>
                  @else
                    <i class="sr-star dwg-star"></i>
                  @endif
                @endfor
              </div>
            </div>
            <h3 class="product-title font-size-sm mb-2">
              <a href="{{ URL::to('/item') }}/{{ $featured->item_slug }}">
                @if($addition_settings->item_name_limit != 0)
                  {{ mb_substr($featured->item_name, 0, $addition_settings->item_name_limit, 'utf-8').'...' }}
                @else
                  {{ $featured->item_name }}
                @endif
              </a>
            </h3>
            <div class="card-footer d-flex align-items-center font-size-xs">
              <a class="blog-entry-meta-link" href="{{ URL::to('/user') }}/{{ $featured->username }}">
                <div class="blog-entry-author-ava">
                  @if($featured->user_photo != '')
                    <img class="lazy" src="{{ url('/') }}/public/storage/users/{{ $featured->user_photo }}" alt="{{ $featured->username }}" width="26" height="26">
                  @else
                    <img class="lazy" src="{{ url('/') }}/public/img/no-user.png" alt="{{ $featured->username }}" width="26" height="26">
                  @endif
                </div>
                @if($addition_settings->author_name_limit != 0)
                  {{ mb_substr($featured->username, 0, $addition_settings->author_name_limit, 'utf-8') }}
                @else
                  {{ $featured->username }}
                @endif
                @if($addition_settings->subscription_mode == 1 && $featured->user_document_verified == 1)
                  <span class="badges-success"><i class="dwg-check-circle danger"></i> {{ __('verified') }}</span>
                @endif
              </a>
              <div class="ml-auto text-nowrap">
                <i class="dwg-time"></i> {{ date('d M Y', strtotime($featured->updated_item)) }}
              </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center">
              @if($featured->file_type == 'serial')
                @php
                  $result_count = ($featured->item_delimiter == 'comma')
                                  ? substr_count($featured->item_serials_list, ",")
                                  : substr_count($featured->item_serials_list, "\n");
                @endphp
                <div class="font-size-sm mr-2">
                  <i class="dwg-cart text-muted mr-1"></i>{{ $result_count }}
                  <span class="font-size-xs ml-1">{{ __('Stock') }}</span>
                </div>
              @else
                <div class="font-size-sm mr-2">
                  @if($addition_settings->item_sale_count == 1)
                    <i class="dwg-download text-muted mr-1"></i>{{ $featured->item_sold }}
                    <span class="font-size-xs ml-1">{{ __('Sales') }}</span>
                  @endif
                </div>
              @endif
              <div>
                @if($featured->free_download == 0)
                  @if($featured->item_flash == 1)
                    <del class="price-old">{{ Helper::price_format($allsettings->site_currency_position, $featured->regular_price, $currency_symbol, $multicurrency) }}</del>
                  @endif
                  <span class="bg-faded-accent text-accent rounded-sm py-1 px-2">
                    {{ Helper::price_format($allsettings->site_currency_position, $price, $currency_symbol, $multicurrency) }}
                  </span>
                @else
                  <span class="price-badge rounded-sm py-1 px-2">{{ __('Free') }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @php $no++; @endphp
      @endforeach
    </div>
  </section>
  @endif

  <!-- Popular Items Section -->
  @if(count($popular['items']) != 0)
  <section class="container mb-lg-1 flash-sale" data-aos="fade-up" data-aos-delay="200">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
      <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100">{{ __('Popular Items') }}</h2>
      <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
        <a class="btn btn-outline-accent" href="{{ URL::to('/') }}/popular-items">{{ __('Browse All Items') }}<i class="dwg-arrow-right font-size-ms ml-1"></i></a>
      </div>
    </div>
    <div class="row pt-2 mx-n2">
      @php $no = 1; @endphp
      @foreach($popular['items'] as $popularItem)
      @php
        $price = Helper::price_info($popularItem->item_flash, $popularItem->regular_price);
        $count_rating = Helper::count_rating($popularItem->ratings);
      @endphp
      <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-grid-gutter">
        <div class="card product-card-alt">
          @if($custom_settings->author_key == Helper::Key_Owner() && $popularItem->item_flash == 1)
          <div class="ribbon ribbon-top-left"><span>{{ $addition_settings->flash_sale_value }}% {{ __('OFF') }}</span></div>
          @endif
          <div class="product-thumb">
            @if(Auth::guest())
              <a class="btn-wishlist btn-sm" href="{{ url('/') }}/login"><i class="dwg-heart"></i></a>
            @elseif(Auth::check() && $popularItem->user_id != Auth::user()->id)
              <a class="btn-wishlist btn-sm" href="{{ url('/item') }}/{{ base64_encode($popularItem->item_id) }}/favorite/{{ base64_encode($popularItem->item_liked) }}"><i class="dwg-heart"></i></a>
            @endif
            <div class="product-card-actions">
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $popularItem->item_slug }}"><i class="dwg-eye"></i></a>
              @php $checkif_purchased = Helper::if_purchased($popularItem->item_token); @endphp
              @if($addition_settings->guest_checkout == 1)
                @if($checkif_purchased == 0)
                  @if($popularItem->free_download == 0)
                    <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $popularItem->item_slug }}"><i class="dwg-cart"></i></a>
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($popularItem->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @endif
              @else
                @if($checkif_purchased == 0)
                  @if($popularItem->free_download == 0)
                    <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $popularItem->item_slug }}"><i class="dwg-cart"></i></a>
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($popularItem->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @else
                  <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $popularItem->item_slug }}"><i class="dwg-cart"></i></a>
                @endif
              @endif
            </div>
            <a class="product-thumb-overlay" href="{{ URL::to('/item') }}/{{ $popularItem->item_slug }}"></a>
            @if($popularItem->item_preview != '')
              <img class="lazy" src="{{ Helper::Image_Path($popularItem->item_preview, 'no-image.png') }}" alt="{{ $popularItem->item_name }}" width="300" height="200">
            @else
              <img class="lazy" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $popularItem->item_name }}" width="300" height="200">
            @endif
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
              <div class="text-muted font-size-xs mr-1">
                <a class="product-meta font-weight-medium" href="{{ URL::to('/shop') }}/item-type/{{ $popularItem->item_type }}">
                  {{ Helper::ItemTypeIdGetData($popularItem->item_type_id) }}
                </a>
              </div>
              <div class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                  @if($i <= $count_rating)
                    <i class="sr-star dwg-star-filled active"></i>
                  @else
                    <i class="sr-star dwg-star"></i>
                  @endif
                @endfor
              </div>
            </div>
            <h3 class="product-title font-size-sm mb-2">
              <a href="{{ URL::to('/item') }}/{{ $popularItem->item_slug }}">
                @if($addition_settings->item_name_limit != 0)
                  {{ mb_substr($popularItem->item_name, 0, $addition_settings->item_name_limit, 'utf-8').'...' }}
                @else
                  {{ $popularItem->item_name }}
                @endif
              </a>
            </h3>
            <div class="card-footer d-flex align-items-center font-size-xs">
              <a class="blog-entry-meta-link" href="{{ URL::to('/user') }}/{{ $popularItem->username }}">
                <div class="blog-entry-author-ava">
                  @if($popularItem->user_photo != '')
                    <img class="lazy" src="{{ url('/') }}/public/storage/users/{{ $popularItem->user_photo }}" alt="{{ $popularItem->username }}" width="26" height="26">
                  @else
                    <img class="lazy" src="{{ url('/') }}/public/img/no-user.png" alt="{{ $popularItem->username }}" width="26" height="26">
                  @endif
                </div>
                @if($addition_settings->author_name_limit != 0)
                  {{ mb_substr($popularItem->username, 0, $addition_settings->author_name_limit, 'utf-8') }}
                @else
                  {{ $popularItem->username }}
                @endif
                @if($addition_settings->subscription_mode == 1 && $popularItem->user_document_verified == 1)
                  <span class="badges-success"><i class="dwg-check-circle danger"></i> {{ __('verified') }}</span>
                @endif
              </a>
              <div class="ml-auto text-nowrap">
                <i class="dwg-time"></i> {{ date('d M Y', strtotime($popularItem->updated_item)) }}
              </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center">
              @if($popularItem->file_type == 'serial')
                @php
                  $result_count = ($popularItem->item_delimiter == 'comma')
                                  ? substr_count($popularItem->item_serials_list, ",")
                                  : substr_count($popularItem->item_serials_list, "\n");
                @endphp
                <div class="font-size-sm mr-2">
                  <i class="dwg-cart text-muted mr-1"></i>{{ $result_count }}
                  <span class="font-size-xs ml-1">{{ __('Stock') }}</span>
                </div>
              @else
                <div class="font-size-sm mr-2">
                  @if($addition_settings->item_sale_count == 1)
                    <i class="dwg-download text-muted mr-1"></i>{{ $popularItem->item_sold }}
                    <span class="font-size-xs ml-1">{{ __('Sales') }}</span>
                  @endif
                </div>
              @endif
              <div>
                @if($popularItem->free_download == 0)
                  @if($popularItem->item_flash == 1)
                    <del class="price-old">{{ Helper::price_format($allsettings->site_currency_position, $popularItem->regular_price, $currency_symbol, $multicurrency) }}</del>
                  @endif
                  <span class="bg-faded-accent text-accent rounded-sm py-1 px-2">
                    {{ Helper::price_format($allsettings->site_currency_position, $price, $currency_symbol, $multicurrency) }}
                  </span>
                @else
                  <span class="price-badge rounded-sm py-1 px-2">{{ __('Free') }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @php $no++; @endphp
      @endforeach
    </div>
  </section>
  @endif

  <!-- Free Items Section -->
  @if(count($free['items']) != 0)
  <section class="container mb-lg-1 flash-sale" data-aos="fade-up" data-aos-delay="200">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
      <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100">{{ __('Free Items') }}</h2>
      <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
        <a class="btn btn-outline-accent" href="{{ URL::to('/') }}/free-items">{{ __('Browse All Items') }}<i class="dwg-arrow-right font-size-ms ml-1"></i></a>
      </div>
    </div>
    <div class="row pt-2 mx-n2">
      @php $no = 1; @endphp
      @foreach($free['items'] as $freeItem)
      @php
        $price = Helper::price_info($freeItem->item_flash, $freeItem->regular_price);
        $count_rating = Helper::count_rating($freeItem->ratings);
      @endphp
      <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-grid-gutter">
        <div class="card product-card-alt">
          @if($custom_settings->author_key == Helper::Key_Owner() && $freeItem->item_flash == 1)
          <div class="ribbon ribbon-top-left"><span>{{ $addition_settings->flash_sale_value }}% {{ __('OFF') }}</span></div>
          @endif
          <div class="product-thumb">
            @if(Auth::guest())
              <a class="btn-wishlist btn-sm" href="{{ url('/') }}/login"><i class="dwg-heart"></i></a>
            @elseif(Auth::check() && $freeItem->user_id != Auth::user()->id)
              <a class="btn-wishlist btn-sm" href="{{ url('/item') }}/{{ base64_encode($freeItem->item_id) }}/favorite/{{ base64_encode($freeItem->item_liked) }}"><i class="dwg-heart"></i></a>
            @endif
            <div class="product-card-actions">
              <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $freeItem->item_slug }}"><i class="dwg-eye"></i></a>
              @php $checkif_purchased = Helper::if_purchased($freeItem->item_token); @endphp
              @if($addition_settings->guest_checkout == 1)
                @if($checkif_purchased == 0)
                  @if($freeItem->free_download == 0)
                    <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/add-to-cart') }}/{{ $freeItem->item_slug }}"><i class="dwg-cart"></i></a>
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($freeItem->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @endif
              @else
                @if($checkif_purchased == 0)
                  @if($freeItem->free_download == 0)
                    <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $freeItem->item_slug }}"><i class="dwg-cart"></i></a>
                  @else
                    @if(Auth::guest())
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/login') }}"><i class="dwg-download"></i></a>
                    @else
                      <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/download/{{ base64_encode($freeItem->item_token) }}"><i class="dwg-download"></i></a>
                    @endif
                  @endif
                @else
                  <a class="btn btn-light btn-icon btn-shadow font-size-base mx-2" href="{{ URL::to('/item') }}/{{ $freeItem->item_slug }}"><i class="dwg-cart"></i></a>
                @endif
              @endif
            </div>
            <a class="product-thumb-overlay" href="{{ URL::to('/item') }}/{{ $freeItem->item_slug }}"></a>
            @if($freeItem->item_preview != '')
              <img class="lazy" src="{{ Helper::Image_Path($freeItem->item_preview, 'no-image.png') }}" alt="{{ $freeItem->item_name }}" width="300" height="200">
            @else
              <img class="lazy" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $freeItem->item_name }}" width="300" height="200">
            @endif
          </div>
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
              <div class="text-muted font-size-xs mr-1">
                <a class="product-meta font-weight-medium" href="{{ URL::to('/shop') }}/item-type/{{ $freeItem->item_type }}">
                  {{ Helper::ItemTypeIdGetData($freeItem->item_type_id) }}
                </a>
              </div>
              <div class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                  @if($i <= $count_rating)
                    <i class="sr-star dwg-star-filled active"></i>
                  @else
                    <i class="sr-star dwg-star"></i>
                  @endif
                @endfor
              </div>
            </div>
            <h3 class="product-title font-size-sm mb-2">
              <a href="{{ URL::to('/item') }}/{{ $freeItem->item_slug }}">
                @if($addition_settings->item_name_limit != 0)
                  {{ mb_substr($freeItem->item_name, 0, $addition_settings->item_name_limit, 'utf-8').'...' }}
                @else
                  {{ $freeItem->item_name }}
                @endif
              </a>
            </h3>
            <div class="card-footer d-flex align-items-center font-size-xs">
              <a class="blog-entry-meta-link" href="{{ URL::to('/user') }}/{{ $freeItem->username }}">
                <div class="blog-entry-author-ava">
                  @if($freeItem->user_photo != '')
                    <img class="lazy" src="{{ url('/') }}/public/storage/users/{{ $freeItem->user_photo }}" alt="{{ $freeItem->username }}" width="26" height="26">
                  @else
                    <img class="lazy" src="{{ url('/') }}/public/img/no-user.png" alt="{{ $freeItem->username }}" width="26" height="26">
                  @endif
                </div>
                @if($addition_settings->author_name_limit != 0)
                  {{ mb_substr($freeItem->username, 0, $addition_settings->author_name_limit, 'utf-8') }}
                @else
                  {{ $freeItem->username }}
                @endif
                @if($addition_settings->subscription_mode == 1 && $freeItem->user_document_verified == 1)
                  <span class="badges-success"><i class="dwg-check-circle danger"></i> {{ __('verified') }}</span>
                @endif
              </a>
              <div class="ml-auto text-nowrap">
                <i class="dwg-time"></i> {{ date('d M Y', strtotime($freeItem->updated_item)) }}
              </div>
            </div>
            <div class="d-flex flex-wrap justify-content-between align-items-center">
              @if($freeItem->file_type == 'serial')
                @php
                  $result_count = ($freeItem->item_delimiter == 'comma')
                                  ? substr_count($freeItem->item_serials_list, ",")
                                  : substr_count($freeItem->item_serials_list, "\n");
                @endphp
                <div class="font-size-sm mr-2">
                  <i class="dwg-cart text-muted mr-1"></i>{{ $result_count }}
                  <span class="font-size-xs ml-1">{{ __('Stock') }}</span>
                </div>
              @else
                <div class="font-size-sm mr-2">
                  @if($addition_settings->item_sale_count == 1)
                    <i class="dwg-download text-muted mr-1"></i>{{ $freeItem->item_sold }}
                    <span class="font-size-xs ml-1">{{ __('Sales') }}</span>
                  @endif
                </div>
              @endif
              <div>
                @if($freeItem->free_download == 0)
                  @if($freeItem->item_flash == 1)
                    <del class="price-old">{{ Helper::price_format($allsettings->site_currency_position, $freeItem->regular_price, $currency_symbol, $multicurrency) }}</del>
                  @endif
                  <span class="bg-faded-accent text-accent rounded-sm py-1 px-2">
                    {{ Helper::price_format($allsettings->site_currency_position, $price, $currency_symbol, $multicurrency) }}
                  </span>
                @else
                  <span class="price-badge rounded-sm py-1 px-2">{{ __('Free') }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @php $no++; @endphp
      @endforeach
    </div>
  </section>
  @endif

  <!-- New Releases Section -->
  @if(count($newest['items']) != 0)
  <section class="container pb-4 pb-md-5" data-aos="fade-up" data-aos-delay="200">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
      <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100">{{ __('New Releases') }}</h2>
      <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
        <a class="btn btn-outline-accent" href="{{ URL::to('/new-releases') }}">{{ __('Browse All Items') }}<i class="dwg-arrow-right font-size-ms ml-1"></i></a>
      </div>
    </div>
    <div class="row">
      @php $no = 1; @endphp
      @foreach($newest['items'] as $newItem)
      @php
        $price = Helper::price_info($newItem->item_flash, $newItem->regular_price);
        $count_rating = Helper::count_rating($newItem->ratings);
      @endphp
      <div class="col-lg-4 col-md-6 mb-2 py-3">
        <div class="widget">
          <div class="media align-items-center pb-2 border-bottom">
            <a class="d-block mr-2" href="{{ URL::to('/item') }}/{{ $newItem->item_slug }}">
              @if($newItem->item_preview != '')
                <img class="lazy" src="{{ Helper::Image_Path($newItem->item_preview, 'no-image.png') }}" alt="{{ $newItem->item_name }}" width="64" height="48">
              @else
                <img class="lazy" src="{{ url('/') }}/public/img/no-image.png" alt="{{ $newItem->item_name }}" width="64" height="48">
              @endif
            </a>
            <div class="media-body">
              <h6 class="widget-product-title"><a href="{{ URL::to('/item') }}/{{ $newItem->item_slug }}">{{ $newItem->item_name }}</a></h6>
              <div class="widget-product-meta">
                @if($newItem->free_download == 0)
                  <span class="text-accent">{{ Helper::price_format($allsettings->site_currency_position, $price, $currency_symbol, $multicurrency) }}</span>
                  @if($newItem->item_flash == 1)
                    <del class="price-old">{{ Helper::price_format($allsettings->site_currency_position, $newItem->regular_price, $currency_symbol, $multicurrency) }}</del>
                  @endif
                @else
                  <span class="text-accent">{{ __('Free') }}</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @php $no++; @endphp
      @endforeach
    </div>
  </section>
  @endif

  <!-- Features Section -->
  @if($allsettings->site_features_display == 1)
  <section class="bg-size-cover bg-position-center pt-5 pb-4 pb-lg-5 feature-panel" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
    <div class="container pt-lg-3" data-aos="fade-up" data-aos-delay="200">
      <h2 class="h3 mb-3 pb-4 text-light text-center">{{ __('Why Choose') }} {{ $allsettings->site_title }}?</h2>
      <div class="row pt-lg-2 text-center">
        <div class="col-lg-3 col-md-3 col-sm-12 mb-grid-gutter" data-aos="fade-right" data-aos-delay="200">
          <div class="d-inline-block">
            <div class="media media-ie-fix align-items-center text-left">
              <span class="{{ $allsettings->site_icon1 }}"></span>
              <div class="media-body pl-3">
                <h6 class="text-light font-size-base mb-1">{{ $allsettings->site_text1 }}</h6>
                <p class="text-light font-size-ms opacity-70 mb-0">{{ $allsettings->site_sub_text1 }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 mb-grid-gutter" data-aos="fade-right" data-aos-delay="200">
          <div class="d-inline-block">
            <div class="media media-ie-fix align-items-center text-left">
              <span class="{{ $allsettings->site_icon2 }}"></span>
              <div class="media-body pl-3">
                <h6 class="text-light font-size-base mb-1">{{ $allsettings->site_text2 }}</h6>
                <p class="text-light font-size-ms opacity-70 mb-0">{{ $allsettings->site_sub_text2 }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 mb-grid-gutter" data-aos="fade-right" data-aos-delay="200">
          <div class="d-inline-block">
            <div class="media media-ie-fix align-items-center text-left">
              <span class="{{ $allsettings->site_icon3 }}"></span>
              <div class="media-body pl-3">
                <h6 class="text-light font-size-base mb-1">{{ $allsettings->site_text3 }}</h6>
                <p class="text-light font-size-ms opacity-70 mb-0">{{ $allsettings->site_sub_text3 }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 mb-grid-gutter" data-aos="fade-right" data-aos-delay="200">
          <div class="d-inline-block">
            <div class="media media-ie-fix align-items-center text-left">
              <span class="{{ $allsettings->site_icon4 }}"></span>
              <div class="media-body pl-3">
                <h6 class="text-light font-size-base mb-1">{{ $allsettings->site_text4 }}</h6>
                <p class="text-light font-size-ms opacity-70 mb-0">{{ $allsettings->site_sub_text4 }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <!-- Blog Section -->
  @if($allsettings->site_blog_display == 1)
    @if($allsettings->home_blog_display == 1)
      @if(count($blog['data']) != 0)
      <section class="container pb-4 pb-md-5 homeblog" data-aos="fade-up" data-aos-delay="200">
        <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
          <h2 class="h3 mb-0 pt-3 mr-2" data-aos="fade-down" data-aos-delay="100">{{ __('Our Blog') }}</h2>
          <div class="pt-3" data-aos="fade-down" data-aos-delay="100">
            <a class="btn btn-outline-accent" href="{{ URL::to('/blog') }}">{{ __('Ream more posts') }}<i class="dwg-arrow-right font-size-ms ml-1"></i></a>
          </div>
        </div>
        <div class="row">
          @php $no = 1; @endphp
          @foreach($blog['data'] as $post)
          <div class="col-lg-4 col-md-6 mb-2 py-3">
            <div class="card">
              <a class="blog-entry-thumb" href="{{ URL::to('/single') }}/{{ $post->post_slug }}" title="{{ $post->post_title }}">
                @if($post->post_image != '')
                  <img class="lazy card-img-top" src="{{ url('/') }}/public/storage/post/{{ $post->post_image }}" alt="{{ $post->post_title }}" width="388" height="240">
                @else
                  <img class="lazy card-img-top" src="{{ url('/') }}/public/img/no-image.png" width="388" height="240">
                @endif
              </a>
              <div class="card-body">
                <h2 class="h6 blog-entry-title">
                  <a href="{{ URL::to('/single') }}/{{ $post->post_slug }}">{{ $post->post_title }}</a>
                </h2>
                <p class="font-size-sm">
                  @if($addition_settings->post_short_desc_limit != 0)
                    {{ mb_substr($post->post_short_desc, 0, $addition_settings->post_short_desc_limit, 'utf-8').'...' }}
                  @else
                    {{ $post->post_short_desc }}
                  @endif
                </p>
                <div class="font-size-xs text-nowrap">
                  <span class="blog-entry-meta-link text-nowrap">{{ date('d M Y', strtotime($post->post_date)) }}</span>
                  <span class="blog-entry-meta-divider mx-2"></span>
                  <span class="blog-entry-meta-link text-nowrap"><i class="dwg-message"></i>{{ $comments->has($post->post_id) ? count($comments[$post->post_id]) : 0 }}</span>
                </div>
              </div>
            </div>
          </div>
          @php $no++; @endphp
          @endforeach
        </div>
      </section>
      @endif
    @endif
  @endif

  <!-- CTA Banner Section -->
  <section class="cta-banner" data-aos="fade-up" data-aos-delay="150">
    <div class="container">
      <h2>Join Our Creative Community</h2>
      <p>Explore, share, and create your masterpiece with us.</p>
      <a href="{{ URL::to('/join') }}" class="btn">Get Started</a>
    </div>
  </section>

  <!-- Bottom Ads Section -->
  @if(in_array('home', $bottom_ads))
  <section class="container pt-2" data-aos="fade-up" data-aos-delay="200">
    <div class="row">
      <div class="col-lg-12 mb-3" align="center">
        @php echo html_entity_decode($addition_settings->bottom_ads); @endphp
      </div>
    </div>
  </section>
  @endif

  <!-- Promotion Popup Section -->
  @if($custom_settings->promotion_popup == 1)
  <div id="my-welcome-message">
    <div class="header">
      <h3>{{ $custom_settings->pr_promo_heading }}</h3>
    </div>
    <div class="bodies">
      <div class="container-fluid p-0">
        <div class="row no-gutters">
          <div class="col-md-12 textboxrow" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $custom_settings->promotion_bg_image }}'); background-size:cover;">
            <h1>{{ $custom_settings->pr_promo_title_one }}</h1>
            <h5>{{ $custom_settings->pr_promo_title_two }}</h5>
            <p class="saledate">{{ __('Sales end') }} {{ date('M d, Y', strtotime($custom_settings->pr_promo_date)) }}</p>
            <a class="btn btn-outline-accent" href="{{ $custom_settings->pr_promo_button_link }}">{{ __('Download Now') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @include('footer')
  @include('script')

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var header = document.querySelector('header');
      window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
      });
    });
  </script>
</body>

</html>
