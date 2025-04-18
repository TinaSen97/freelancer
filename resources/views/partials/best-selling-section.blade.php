<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Best Selling Products Section</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    /* ========== Global Reset & Basic Styles ========== */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      color: #333;
    }

    /* ========== Best Selling Products Section ========== */
    .best-selling-section {
      background-color: #fff;
      padding: 60px 0;
    }
    .best-selling-left,
    .best-selling-right {
      padding: 0 15px;
    }

    /* Left Column Styling (mimicking the Banner left section) */
    .best-selling-left .sticky-content {
      position: sticky;
      top: 20px;
      height: auto;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 10px;
    }
    .best-selling-left .tagline {
      font-size: 2rem;
      color: #000;
      margin-bottom: 10px;
    }
    .best-selling-left .main-heading {
      font-size: 6rem;
      font-weight: 700;
      color: #111;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    .best-selling-left .main-heading .lighter-code {
      font-weight: 500;
    }
    .best-selling-left .sub-description {
      font-size: 1.2rem;
      color: #555;
      line-height: 1.6;
      max-width: 600px;
      margin-bottom: 20px;
    }
    .best-selling-left .sub-description .extra {
      display: block;
      margin-top: 10px;
      font-size: 1rem;
      color: #666;
    }
    .best-selling-left .btn-group {
      margin-top: 20px;
    }
    .best-selling-left .btn {
      padding: 0.5rem 1rem;
      font-size: 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-right: 10px;
    }
    .best-selling-left .btn-primary {
      background: #7e36f4;
      color: #fff;
    }
    .best-selling-left .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .best-selling-left .btn-outline-primary {
      background: transparent;
      color: #7e36f4;
      border: 1px solid #7e36f4;
    }
    .best-selling-left .btn-outline-primary:hover {
      background: #7e36f4;
      color: #fff;
    }

    /* Right Column: Grid of Products */
    .best-selling-right {
      max-height: 600px;
      overflow-y: auto;
      padding-left: 20px;
      scrollbar-width: thin;
      scrollbar-color: #7e36f4 #f1f1f1;
    }
    .best-selling-right::-webkit-scrollbar {
      width: 8px;
    }
    .best-selling-right::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }
    .best-selling-right::-webkit-scrollbar-thumb {
      background: #7e36f4;
      border-radius: 4px;
      border: 2px solid #f1f1f1;
    }
    .best-selling-right::-webkit-scrollbar-thumb:hover {
      background: #019a58;
    }

    /* Grid: 2 columns (8 items in each column) */
    .best-selling-products-grid {
      display: grid;
      grid-template-columns: 1fr 1fr; /* 2 columns side by side */
      gap: 1px;
      background-color: #ccc;
    }

    /* ========== Card Styles ========== */
    .dummy-product-card {
      border: none;
      background: #fff;
      position: relative;
      overflow: hidden;
      /* You can add margin or padding here if desired */
    }
    .dummy-product-card .card-img-top {
      width: 100%;
      height: 200px; /* Adjust as needed */
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .dummy-product-card:hover .card-img-top {
      transform: scale(1.05);
    }

    /* ========== Product Name Overlay ========== */
    .product-name-overlay {
      position: absolute;
      bottom: 8px;
      left: 8px;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(2px);
      color: #fff;
      font-size: 0.9rem;
      padding: 6px 10px;
      border-radius: 4px;
      max-width: 80%;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    /* ========== Hexagon Styling ========== */
    .hexagon {
      width: 25px;
      height: 25px;
      background: #fff;
      clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #7e36f4;
      font-weight: bold;
      font-size: 9px;
      position: absolute;
      top: 5px;
      right: 5px;
      transition: background 0.3s ease, color 0.3s ease;
    }
    /* Hover effects for Hexagon on both hexagon hover and card hover */
    .hexagon:hover,
    .dummy-product-card:hover .hexagon {
      background: #000;
      color: #fff;
    }
  </style>
</head>
<body>

@php
  /* Define your focusData in a PHP array so Blade can iterate over it. */
  $focusData = [
    [
      "title" => "Gizmo Turbo",
      "image" => "https://plus.unsplash.com/premium_photo-1661753668576-d7e14f27edf4?q=80&w=1470&auto=format&fit=crop",
      "author" => "John Doe",
      "price" => "$19.99",
      "sold" => 25,
      "description" => "Experience blazing speed with Gizmo Turbo—built for performance and style. Perfect for on-the-go enthusiasts."
    ],
    [
      "title" => "Widget Supreme",
      "image" => "https://images.unsplash.com/photo-1588200908342-23b585c03e26?q=80&w=1470&auto=format&fit=crop",
      "author" => "Jane Smith",
      "price" => "$24.99",
      "sold" => 30,
      "description" => "Widget Supreme sets the standard in quality and innovation, offering a superior experience in everyday tech."
    ],
    [
      "title" => "Mega Gadget",
      "image" => "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1470&auto=format&fit=crop",
      "author" => "Alice Cooper",
      "price" => "$29.99",
      "sold" => 40,
      "description" => "Mega Gadget redefines versatility with cutting-edge features, perfect for those who demand more from their devices."
    ],
    [
      "title" => "Quantum Widget",
      "image" => "https://images.unsplash.com/photo-1530435460869-d13625c69bbf?q=80&w=1470&auto=format&fit=crop",
      "author" => "Bob Martin",
      "price" => "$34.99",
      "sold" => 18,
      "description" => "Step into the future with Quantum Widget—designed to elevate your digital experience with its advanced technology."
    ],
    [
      "title" => "Nano Tech",
      "image" => "https://images.unsplash.com/photo-1625662171891-9a3348f961f4?q=80&w=1470&auto=format&fit=crop",
      "author" => "Emily Davis",
      "price" => "$39.99",
      "sold" => 22,
      "description" => "Nano Tech combines precision and power in a compact design, ideal for tech-savvy individuals on the move."
    ],
    [
      "title" => "Fusion Device",
      "image" => "https://plus.unsplash.com/premium_photo-1661582360225-60ba513153e3?q=80&w=1632&auto=format&fit=crop",
      "author" => "Chris Lee",
      "price" => "$44.99",
      "sold" => 35,
      "description" => "Fusion Device offers unmatched connectivity and performance, blending style with functionality effortlessly."
    ],
    [
      "title" => "Vortex Gear",
      "image" => "https://images.unsplash.com/photo-1493723843671-1d655e66ac1c?q=80&w=1470&auto=format&fit=crop",
      "author" => "Samantha Ray",
      "price" => "$49.99",
      "sold" => 28,
      "description" => "Vortex Gear is engineered for dynamic performance and sleek design, a must-have for modern adventurers."
    ],
    [
      "title" => "Alpha Module",
      "image" => "https://images.unsplash.com/photo-1612171709946-7fc1298a5a53?q=80&w=1526&auto=format&fit=crop",
      "author" => "Michael Chen",
      "price" => "$54.99",
      "sold" => 32,
      "description" => "Alpha Module stands at the forefront of innovation, delivering cutting-edge technology in a refined package."
    ]
  ];
@endphp

<!-- BEST SELLING PRODUCTS SECTION -->
<section class="best-selling-section py-5">
  <div class="container">
    <div class="row">
      <!-- Left Column: Sticky Content (Banner Left Section Style) -->
      <div class="col-md-7 best-selling-left" data-aos="fade-right" data-aos-delay="100">
        <div class="sticky-content">
          <div class="tagline">Our</div>
          <h1 class="main-heading">
            <span class="lighter-code">Best</span> Selling Products
          </h1>
          <p class="sub-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut imperdiet nisi eu volutpat consequat.
            <br>
            Vivamus non diam sit amet magna ultricies vestibulum. Sed auctor, velit at accumsan interdum.
            <br>
            Morbi scelerisque, est ac hendrerit blandit, elit dolor suscipit dui.
          </p>
          <div class="btn-group">
            <a href="#" class="btn btn-primary animated-btn">Shop Now</a>
            <a href="#" class="btn btn-outline-primary animated-btn">Learn More</a>
          </div>
        </div>
      </div>

      <!-- Right Column: Products Grid (8 + 8 reversed) -->
      <div class="col-md-5 best-selling-right" data-aos="fade-left" data-aos-delay="100">
        <div class="best-selling-products-grid">
          <!-- COLUMN 1: Normal Order -->
          <div>
            @foreach($focusData as $index => $item)
              <div class="card dummy-product-card">
                <div class="image-container" style="position: relative;">
                  <!-- Card Image -->
                  <img class="card-img-top"
                       src="{{ $item['image'] }}"
                       alt="{{ $item['title'] }}">
                  <!-- Hexagon with iteration number (1 to 8) -->
                  <div class="hexagon">{{ $loop->iteration }}</div>
                  <!-- Product Name Overlay -->
                  <div class="product-name-overlay">
                    {{ $item['title'] }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- COLUMN 2: Reverse Order -->
          <div>
            @foreach(array_reverse($focusData) as $index => $item)
              <div class="card dummy-product-card">
                <div class="image-container" style="position: relative;">
                  <!-- Card Image -->
                  <img class="card-img-top"
                       src="{{ $item['image'] }}"
                       alt="{{ $item['title'] }}">
                  <!-- Hexagon with iteration number (also 1 to 8 in reversed loop) -->
                  <div class="hexagon">{{ $loop->iteration }}</div>
                  <!-- Product Name Overlay -->
                  <div class="product-name-overlay">
                    {{ $item['title'] }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>

        </div> <!-- end .best-selling-products-grid -->
      </div> <!-- end .col-md-5 -->
    </div> <!-- end .row -->
  </div> <!-- end .container -->
</section>
</body>
</html>
