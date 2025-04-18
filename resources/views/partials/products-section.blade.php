<!-- PRODUCTS SECTION -->
<style>
  /* ========== Products Section Styles ========== */
  .products-section {
    position: relative;
    perspective: 1000px;
    /* Optional if you want to keep 3D context */
  }

  .products-section .hover-block {
    position: absolute;
    background: rgba(128, 128, 128, 0.15);
    /* Light green tint */
    border-radius: 15px;
    transition: all 0.3s ease;
    pointer-events: none;
    z-index: 0;
    opacity: 0;
  }

  /* Card styles */
  .products-section .card {
    position: relative;
    z-index: 1;
    border: none;
    border-radius: 15px;
    overflow: hidden;
    background-color: #fff;
    transform: translateY(0px);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: auto;
    max-height: 95%;
  }

  .products-section .card.hovered {
    transform: translateY(-10px) scale(1.05);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
  }

  .products-section .card img {
    transition: transform 0.5s ease;
  }

  .products-section .card img:hover {
    transform: scale(1.05);
  }

  .products-section .card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .products-section .card-body {
    padding: 1rem 1.5rem;
  }

  .products-section .card-title {
    font-size: 16px;
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .products-section .product-info-left,
  .products-section .product-info-right {
    width: 48%;
  }

  .products-section .price {
    font-size: 16px;
    color: #333;
    font-weight: bold;
  }

  .products-section .units-sold {
    font-size: 13px;
    color: #777;
    margin-top: 1.2rem;
  }

  .products-section .btn-primary {
    background: linear-gradient(45deg, #7e36f4, rgb(153, 104, 233)) !important;
    border: none !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .products-section .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  }

  /* General animated button hover (applies to add-to-cart buttons, etc.) */
  .products-section .animated-btn {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .products-section .animated-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  }

  .products-section .profile-icon {
    display: inline-block;
    width: 30px;
    /* Increased width */
    height: 30px;
    /* Increased height */
    border-radius: 50%;
    background: #ccc;
    text-align: center;
    line-height: 30px;
    /* Match the new height */
    margin-right: 5px;
  }
  /* ========== Additional Styles for Button Animations ========== */
  /* --- Add to Cart Button Styles --- */
  .add-to-cart-btn {
    position: relative;
    overflow: hidden;
  }

  /* Cart icon initial state (static) */
  .add-to-cart-btn .cart-icon {
    display: inline-block;
    transform: translateX(0);
    opacity: 1;
    transition: transform 0.5s ease, opacity 0.5s ease;
  }

  /* Button text initial state */
  .add-to-cart-btn .btn-text {
    display: inline-block;
    transition: transform 0.5s ease, opacity 0.5s ease;
  }

  /* Car icon initial state: positioned off-screen on the left */
  .add-to-cart-btn .speed-car {
    position: absolute;
    left: -30px;
    /* off-screen left */
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
  }

  /* === On button click (.added class) === */
  /* Animate the button text out */
  .add-to-cart-btn.added .btn-text {
    transform: translateX(50px);
    opacity: 0;
  }

  /* Animate the cart icon: slide out to right then reappear from left */
  .add-to-cart-btn.added .cart-icon {
    animation: cartSlideOutIn 0.7s forwards;
  }

  /* Animate the car icon from left to right */
  .add-to-cart-btn.added .speed-car {
    animation: speedCarFromLeft 0.7s forwards;
  }

  /* === Final state (.final class) === */
  /* Reset the text position (its content is updated via JS) */
  .add-to-cart-btn.final .btn-text {
    transform: translateX(0);
    opacity: 1;
  }

  /* Ensure the cart icon is reset (it should already be at translateX(0) after animation) */
  .add-to-cart-btn.final .cart-icon {
    transform: translateX(0);
  }

  /* === Keyframes for cart icon sliding out and back in === */
  @keyframes cartSlideOutIn {
    0% {
      transform: translateX(0);
      opacity: 1;
    }

    40% {
      transform: translateX(50px);
      opacity: 0;
    }

    41% {
      transform: translateX(-50px);
      opacity: 0;
    }

    100% {
      transform: translateX(0);
      opacity: 1;
    }
  }

  /* === Keyframes for car icon sliding from left to right === */
  @keyframes speedCarFromLeft {
    0% {
      left: -30px;
      opacity: 1;
    }

    50% {
      left: 50%;
      opacity: 1;
    }

    100% {
      left: 110%;
      opacity: 0;
    }
  }

  /* -- Favorite Button --
     Only the heart icon should animate. We override the general animated-btn hover
     so that the button box stays static while the icon inside changes.
  */
  .favorite-btn {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
  }

  /* Override the general animated-btn hover for favorite buttons */
  .favorite-btn:hover {
    transform: none !important;
    box-shadow: none !important;
  }

  /* Default heart icon size and transition */
  .favorite-btn .dwg-heart {
    font-size: 20px;
    /* Larger default size */
    transition: transform 0.3s ease, color 0.3s ease;
  }

  /* On hover, only the heart icon elevates and scales up */
  .favorite-btn:hover .dwg-heart {
    transform: translateY(-3px) scale(1.2);
  }

  /* When clicked (favorited), the heart icon elevates further, enlarges more, and turns red */
  .favorite-btn.favorited .dwg-heart {
    transform: translateY(-5px) scale(1.4);
    color: red;
  }

  /* Ensure that when favorited, hovering does not change the icon state */
  .favorite-btn.favorited:hover .dwg-heart {
    transform: translateY(-5px) scale(1.4);
    color: red;
  }

  .new {
    margin-top: 1rem !important;
  }

  .favorite-btn:focus {
  outline: none!important;
  box-shadow: none!important;
}

.title-header{
  font-size:4rem; font-weight:1000; color:black;
}

</style>

<!-- ========== Products Section HTML ========== -->
<section class="products-section py-5">
  <div class="container">
    <h2 class="mb-4 text-center title-header">AI Product Listings</h2>

    <!-- The hover block element that moves behind the hovered card -->
    <div class="hover-block"></div>

    <div class="row">
      @for($i = 1; $i <= 8; $i++)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card product-card">
          <img class="card-img-top" src="{{ asset('public/assets/images/products/' . $i . '.jpg') }}" alt="Product {{ $i }}">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
              <div class="product-info-left">
                <h3 class="card-title">Product {{ $i }}</h3>
                <div class="d-flex align-items-center" style="font-size:14px;margin-top:1.3rem">
                  <span class="profile-icon">
                    <i class="dwg-user" style="font-size:12px; color:#fff;"></i>
                  </span>
                  <span>Author {{ $i }}</span>
                </div>
              </div>
              <div class="product-info-right text-right">
                <div class="price">
                  ${{ number_format(9.99 + $i, 2) }}
                </div>
                <div class="units-sold">
                  Units sold: <span style="color:#01c064;">{{ 10 + $i * 3 }}</span>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-3 new1">
              <!-- ========== Add to Cart Button ========== -->
              <button class="btn btn-primary btn-sm animated-btn add-to-cart-btn">
                <span class="cart-icon"><i class="fas fa-shopping-cart"></i></span>
                <span class="btn-text">Add to Cart</span>
                <span class="speed-car"><i class="fa-solid fa-car-side"></i></span>
              </button>

              <!-- ========== Favorite Button ========== -->
              <button class="btn btn-sm animated-btn favorite-btn">
                <i class="dwg-heart"></i>
              </button>
            </div>
          </div>
        </div>
    </div>
    @endfor
  </div>
  </div>
</section>

<!-- ========== JavaScript for Interactions ========== -->
<script>
  /* --- Hover Block and Card Effects --- */
  const productsSection = document.querySelector('.products-section');
  const hoverBlock = document.querySelector('.hover-block');

  function moveHoverBlock(card) {
    const containerRect = productsSection.getBoundingClientRect();
    const cardRect = card.getBoundingClientRect();
    const scaleFactor = 1.1;
    const newWidth = cardRect.width * scaleFactor;
    const newHeight = cardRect.height * scaleFactor;
    const newTop = cardRect.top - containerRect.top - (newHeight - cardRect.height) / 2;
    const newLeft = cardRect.left - containerRect.left - (newWidth - cardRect.width) / 2;
    hoverBlock.style.top = `${newTop}px`;
    hoverBlock.style.left = `${newLeft}px`;
    hoverBlock.style.width = `${newWidth}px`;
    hoverBlock.style.height = `${newHeight}px`;
    hoverBlock.style.opacity = '1';
  }

  function hideHoverBlock() {
    hoverBlock.style.opacity = '0';
  }

  document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.classList.add('hovered');
      moveHoverBlock(card);
    });
    card.addEventListener('mouseleave', () => {
      card.classList.remove('hovered');
    });
  });

  productsSection.addEventListener('mouseleave', hideHoverBlock);

  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      // Prevent re-triggering if already finalized.
      if (this.classList.contains('final')) return;

      // Add the .added class to trigger text, cart icon, and car icon animations.
      this.classList.add('added');

      // After the animation finishes...
      setTimeout(() => {
        // Update the button text to the final message.
        const textSpan = this.querySelector('.btn-text');
        textSpan.textContent = 'Added to Cart';

        // Remove the temporary animation state and set the final state.
        this.classList.remove('added');
        this.classList.add('final');
      }, 700); // duration should match the animation duration
    });
  });



  /* --- Favorite Button Animation --- */
  document.querySelectorAll('.favorite-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      this.classList.toggle('favorited');
    });
  });
</script>