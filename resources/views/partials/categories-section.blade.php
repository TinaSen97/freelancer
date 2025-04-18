<!-- POPULAR CATEGORIES SECTION -->
<section class="categories-section">
  <style>
    .categories-section {
      padding: 60px 0;
      background-color: #f1f1f1;
      text-align: center;
    }
    .categories-section h2 {
      font-size: 32px;
      margin-bottom: 30px;
      font-weight: bold;
      color: #7e36f4;
    }
    .popular-category-row {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      margin-bottom: 30px;
      padding: 20px;
      background: #fff;
      border: 1px solid #eee;
      border-radius: 10px;
    }
    .popular-category-img {
      position: relative;
      width: 50%;
    }
    .popular-category-img img {
      width: 100%;
      border-radius: 10px;
    }
    .popular-category-overlay {
      position: absolute;
      bottom: 10px;
      left: 10px;
      background: rgba(1, 192, 100, 0.8);
      color: #fff;
      padding: 10px 15px;
      font-weight: bold;
      border-radius: 5px;
    }
    .popular-category-text {
      width: 50%;
      padding: 20px;
      font-size: 16px;
      text-align: left;
    }
    @media (max-width: 992px) {
      .popular-category-row { flex-direction: column; }
      .popular-category-img, .popular-category-text { width: 100%; text-align: center; }
      .popular-category-text { padding: 10px; }
    }
  </style>
  <div class="container">
    <h2 data-aos="fade-up" data-aos-delay="100" data-aos-duration="800" data-aos-easing="ease-out">
      Popular Categories
    </h2>
    @php
      $placeholderImages = [
        asset('public/assets/images/blocakchain.png'),
        asset('public/assets/images/web.webp'),
        asset('public/assets/images/fintech.png'),
        asset('public/assets/images/api-integration.webp'),
      ];
    @endphp
    @if(count($categories['menu']) != 0)
      @foreach($categories['menu'] as $index => $menu)
        @if($index < 4)
          @php $aosAnimation = ($index % 2==0) ? 'fade-right' : 'fade-left'; @endphp
          <div class="popular-category-row" data-aos="{{ $aosAnimation }}" data-aos-delay="{{ $index * 150 + 100 }}">
            @if($index % 2 == 0)
              <div class="popular-category-img">
                <img src="{{ $placeholderImages[$index] }}" alt="{{ $menu->category_name }}">
                <div class="popular-category-overlay">{{ $menu->category_name }}</div>
              </div>
              <div class="popular-category-text">
                <p>Blockchain technology is revolutionizing the way data is stored and shared across networks. Its decentralized
                  nature ensures security and transparency, making it a cornerstone for future innovations.</p>
                <p>Join the movement to explore how blockchain is reshaping industries worldwide.</p>
              </div>
            @else
              <div class="popular-category-text">
                <p>Blockchain technology is revolutionizing the way data is stored and shared across networks. Its decentralized
                  nature ensures security and transparency, making it a cornerstone for future innovations.</p>
                <p>Join the movement to explore how blockchain is reshaping industries worldwide.</p>
              </div>
              <div class="popular-category-img">
                <img src="{{ $placeholderImages[$index] }}" alt="{{ $menu->category_name }}">
                <div class="popular-category-overlay">{{ $menu->category_name }}</div>
              </div>
            @endif
          </div>
        @endif
      @endforeach
    @endif

    @for($i = 1; $i <= 4; $i++)
      @php $dummyAosAnimation = ($i % 2==0) ? 'fade-left' : 'fade-right'; @endphp
      <div class="popular-category-row" data-aos="{{ $dummyAosAnimation }}" data-aos-delay="{{ $i * 150 }}">
        @if($i % 2 == 0)
          <div class="popular-category-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dummy description for Category {{ $i }}.</p>
            <p>Explore more about Dummy Category {{ $i }} here.</p>
          </div>
          <div class="popular-category-img">
            <img src="{{ asset('public/assets/images/products/' . $i . '.jpg') }}" alt="Dummy Category {{ $i }}">
            <div class="popular-category-overlay">Dummy Category {{ $i }}</div>
          </div>
        @else
          <div class="popular-category-img">
            <img src="{{ asset('public/assets/images/products/' . $i . '.jpg') }}" alt="Dummy Category {{ $i }}">
            <div class="popular-category-overlay">Dummy Category {{ $i }}</div>
          </div>
          <div class="popular-category-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Dummy description for Category {{ $i }}.</p>
            <p>Explore more about Dummy Category {{ $i }} here.</p>
          </div>
        @endif
      </div>
    @endfor
  </div>
</section>
