<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Parallax Demo with Tilted Images (No Links)</title>
  <style>
    /* ---------- Base Styles ---------- */
    * {
      box-sizing: border-box;
    }
    body,
    html {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
    }
    
    /* ---------- Parallax Container (with Background) ---------- */
    .parallax-container {
      position: relative;
      overflow: hidden;
      background: url('your-banner-url.jpg') no-repeat center top;
      background-size: cover;
    }
    .parallax-container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(180deg, rgba(19, 19, 19, 0.4), rgba(0, 0, 0, 0.7));
      z-index: 1;
    }
    
    /* ---------- Foreground Content (Unrotated Text & Cards) ---------- */
    .parallax-content {
      position: relative;
      z-index: 2;
      padding: 4rem 0;
      background-color: #7e36f4;
    }


    .hero-header h1 {
        color: #fff;
        font-weight:500;
      }
    
    /* ---------- Header ---------- */
    .hero-header {
      text-align: center;
      color: #fff;
      padding: 4rem 1rem;
    }
    .hero-header h1 {
      font-size: 2rem;
      font-weight: bold;
      margin: 0 0 1rem;
    }
    @media (min-width: 768px) {
      .hero-header h1 {
        font-size: 4.3rem;
      }
    }
    .hero-header p {
      max-width: 53%;
      margin: 0 auto;
      font-weight: 400;
      font-size: 1.2rem;
    }
    
    /* ---------- Flex Row for Product Cards ---------- */
    .flex-row {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 2rem 0;
      gap: 1.5rem;
      will-change: transform;
    }
    
    /* ---------- Product Card Styles ---------- */
    .product-card {
      position: relative;
      width: 30rem;
      height: 24rem;
      flex-shrink: 0;
      overflow: hidden;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    
    /* ---------- Image Wrapper for Tilt Effect ---------- */
    .image-wrapper {
      position: absolute;
      inset: 0;
      /* Apply an initial bottom-edge tilt */
      transform: rotateX(20deg);
      transform-origin: bottom center;
      transition: transform 0.3s ease-out;
    }
    .image-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: left top;
      transition: transform 0.3s ease;
    }
    /* Hover scale (applied to the image only) */
    .product-card:hover .image-wrapper img {
      transform: scale(1.05);
    }
    
    /* ---------- Overlay and Title ---------- */
    .overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0);
      transition: background 0.3s ease;
    }
    .product-card:hover .overlay {
      background: rgba(0, 0, 0, 0.8);
    }
    .title {
      position: absolute;
      bottom: 1rem;
      left: 1rem;
      color: #fff;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .product-card:hover .title {
      opacity: 1;
    }
  </style>
</head>
<body>
  <!-- Parallax Container with Background -->
  <section class="parallax-container">
    <div class="parallax-content">
      <!-- Header Section (Text remains unrotated) -->
      <div class="hero-header">
        <h1>Top Picks Of The Month</h1>
        <p>
          Whether you're looking to buy, sell, share, or simply be inspired, our top picks are your gateway to the best in AI.
        </p>
      </div>
      
      <!-- First Row of Product Cards -->
      <div class="flex-row" id="firstRow">
        <!-- Product Card: Moonbeam -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/moonbeam.png" alt="Moonbeam" />
          </div>
          <div class="overlay"></div>
          <div class="title">Moonbeam</div>
        </div>
        <!-- Product Card: Cursor -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/cursor.png" alt="Cursor" />
          </div>
          <div class="overlay"></div>
          <div class="title">Cursor</div>
        </div>
        <!-- Product Card: Rogue -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/rogue.png" alt="Rogue" />
          </div>
          <div class="overlay"></div>
          <div class="title">Rogue</div>
        </div>
        <!-- Product Card: Editorially -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/editorially.png" alt="Editorially" />
          </div>
          <div class="overlay"></div>
          <div class="title">Editorially</div>
        </div>
        <!-- Product Card: Editrix AI -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/editrix.png" alt="Editrix AI" />
          </div>
          <div class="overlay"></div>
          <div class="title">Editrix AI</div>
        </div>
      </div>
      
      <!-- Second Row of Product Cards -->
      <div class="flex-row" id="secondRow">
        <!-- Product Card: Pixel Perfect -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/pixelperfect.png" alt="Pixel Perfect" />
          </div>
          <div class="overlay"></div>
          <div class="title">Pixel Perfect</div>
        </div>
        <!-- Product Card: Algochurn -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/algochurn.png" alt="Algochurn" />
          </div>
          <div class="overlay"></div>
          <div class="title">Algochurn</div>
        </div>
        <!-- Product Card: Aceternity UI -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/aceternityui.png" alt="Aceternity UI" />
          </div>
          <div class="overlay"></div>
          <div class="title">Aceternity UI</div>
        </div>
        <!-- Product Card: Tailwind Master Kit -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/tailwindmasterkit.png" alt="Tailwind Master Kit" />
          </div>
          <div class="overlay"></div>
          <div class="title">Tailwind Master Kit</div>
        </div>
        <!-- Product Card: SmartBridge -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/smartbridge.png" alt="SmartBridge" />
          </div>
          <div class="overlay"></div>
          <div class="title">SmartBridge</div>
        </div>
      </div>
      
      <!-- Third Row of Product Cards -->
      <div class="flex-row" id="thirdRow">
        <!-- Product Card: Renderwork Studio -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/renderwork.png" alt="Renderwork Studio" />
          </div>
          <div class="overlay"></div>
          <div class="title">Renderwork Studio</div>
        </div>
        <!-- Product Card: Creme Digital -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/cremedigital.png" alt="Creme Digital" />
          </div>
          <div class="overlay"></div>
          <div class="title">Creme Digital</div>
        </div>
        <!-- Product Card: Golden Bells Academy -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/goldenbellsacademy.png" alt="Golden Bells Academy" />
          </div>
          <div class="overlay"></div>
          <div class="title">Golden Bells Academy</div>
        </div>
        <!-- Product Card: Invoker Labs -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/invoker.png" alt="Invoker Labs" />
          </div>
          <div class="overlay"></div>
          <div class="title">Invoker Labs</div>
        </div>
        <!-- Product Card: E Free Invoice -->
        <div class="product-card">
          <div class="image-wrapper">
            <img src="https://aceternity.com/images/products/thumbnails/new/efreeinvoice.png" alt="E Free Invoice" />
          </div>
          <div class="overlay"></div>
          <div class="title">E Free Invoice</div>
        </div>
      </div>
    </div>
  </section>
  
  <!-- JavaScript to Update the Tilt on Scroll -->
  <script>
    (function() {
      // Select all image wrappers to update their rotation
      const imageWrappers = document.querySelectorAll('.image-wrapper');
      const firstRow = document.getElementById('firstRow');
      const secondRow = document.getElementById('secondRow');
      const thirdRow = document.getElementById('thirdRow');
      const initialTilt = 20; // initial tilt in degrees
      
      function updateTilt() {
        // Determine scroll progress based on the container's position
        const container = document.querySelector('.parallax-container');
        const rect = container.getBoundingClientRect();
        const progress = Math.min(Math.max((window.innerHeight - rect.top) / (window.innerHeight + rect.height), 0), 1);
        
        // Calculate the current tilt: at progress=0 it's 20deg, at progress=1 it's 0deg
        const currentTilt = initialTilt * (1 - progress);
        imageWrappers.forEach(wrapper => {
          wrapper.style.transform = `rotateX(${currentTilt}deg)`;
        });
        
        // Optional: update horizontal translation for the rows
        firstRow.style.transform = `translateX(${progress * 1000}px)`;
        secondRow.style.transform = `translateX(${progress * -1000}px)`;
        thirdRow.style.transform = `translateX(${progress * 1000}px)`;
      }
      
      window.addEventListener('scroll', updateTilt);
      updateTilt(); // run on initial load
    })();
  </script>
</body>
</html>
