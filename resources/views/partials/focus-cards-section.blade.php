<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Unique Innovations Showcase</title>
  <style>
    /* ================= Global Styles ================= */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f8f8f8;
    }
    h2 {
      font-size: 36px;
      font-weight: bold;
      color: #000!important;
      margin-bottom: 30px;
    }
    /* ================= Focus Cards Section ================= */
    .focus-cards-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      padding: 40px 20px;
    }
    .focus-card {
      position: relative;
      overflow: hidden;
      width: 300px;
      height: 200px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, filter 0.3s ease;
      cursor: pointer;
      z-index: 1;
    }
    .focus-card:hover {
      transform: scale(1.05);
    }
    .focus-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .focus-card .card-title {
      position: absolute;
      bottom: 10px;
      left: 10px;
      color: #fff !important;
      background: rgba(0, 0, 0, 0.5);
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 16px;
      z-index: 2;
    }
    .focus-cards-container.focus-active .focus-card {
      filter: blur(3px);
    }
    .focus-cards-container.focus-active .focus-card.active {
      filter: none;
    }
    /* ================= Modal & Background Blur ================= */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.85);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .modal-overlay.active {
      display: flex;
      opacity: 1;
    }
    /* ================= Product Card Modal (Modern Style) ================= */
    .modal-card {
      background: linear-gradient(135deg, #ffffff, #f0f0f0);
      border: 4px solid #7e36f4;
      border-radius: 15px;
      max-width: 900px;
      width: 90%;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      display: flex;
      flex-wrap: wrap;
      overflow: hidden;
      animation: popIn 0.4s ease-out;
      position: relative;
    }
    @keyframes popIn {
      0% { transform: scale(0.8); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    /* Left side: Product image */
    .modal-card .card-img {
      flex: 1 1 50%;
      min-height: 300px;
      background: #000;
    }
    .modal-card .card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    /* Right side: Product details */
    .modal-card .card-body {
      flex: 1 1 50%;
      padding: 50px 30px; /* Increased padding to shift texts further down */
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .modal-card .product-info {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-top: 5px;
    }
    .modal-card .info-left {
      width: 48%;
    }
    .modal-card .info-right {
      width: 48%;
      text-align: right;
    }
    .modal-card .card-title {
      font-size: 20px;
      color: #333;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }
    .modal-card .profile-icon {
      display: inline-block;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: #ccc;
      text-align: center;
      line-height: 30px;
      margin-right: 5px;
    }
    .modal-card .price {
      font-size: 18px;
      color: #333;
      font-weight: bold;
    }
    .modal-card .units-sold {
      font-size: 14px;
      color: #777;
      margin-top: 1rem;
    }
    /* Random Description */
    .modal-card .description {
      margin: 15px 0;
      font-size: 15px;
      color: #555;
      line-height: 1.5;
    }
    /* Buttons Container */
    .modal-card .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    /* Add-to-Cart Button with Car Effect */
    .add-to-cart-btn {
      position: relative;
      overflow: hidden;
      border: none;
      border-radius: 5px;
      padding: 8px 12px;
      font-size: 14px;
      background: linear-gradient(45deg, #7e36f4, rgb(153, 104, 233));
      color: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .add-to-cart-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
    .add-to-cart-btn .cart-icon {
      display: inline-block;
      transform: translateX(0);
      opacity: 1;
      transition: transform 0.5s ease, opacity 0.5s ease;
    }
    .add-to-cart-btn .btn-text {
      display: inline-block;
      transition: transform 0.5s ease, opacity 0.5s ease;
      margin: 0 5px;
    }
    .add-to-cart-btn:focus{
      outline: none!important;
    }
    .add-to-cart-btn .speed-car {
      position: absolute;
      left: -30px;
      top: 50%;
      transform: translateY(-50%);
      opacity: 0;
    }
    .add-to-cart-btn.added .btn-text {
      transform: translateX(50px);
      opacity: 0;
    }
    .add-to-cart-btn.added .cart-icon {
      animation: cartSlideOutIn 0.7s forwards;
    }
    .add-to-cart-btn.added .speed-car {
      animation: speedCarFromLeft 0.7s forwards;
    }
    @keyframes cartSlideOutIn {
      0% { transform: translateX(0); opacity: 1; }
      40% { transform: translateX(50px); opacity: 0; }
      41% { transform: translateX(-50px); opacity: 0; }
      100% { transform: translateX(0); opacity: 1; }
    }
    @keyframes speedCarFromLeft {
      0% { left: -30px; opacity: 1; }
      50% { left: 50%; opacity: 1; }
      100% { left: 110%; opacity: 0; }
    }
    /* Favorite Button */
    .favorite-btn {
      border: none;
      background: none;
      cursor: pointer;
    }
    .favorite-btn .heart-icon {
      font-size: 20px;
      transition: transform 0.3s ease, color 0.3s ease;
    }
    .favorite-btn:hover .heart-icon {
      transform: translateY(-3px) scale(1.2);
    }
    .favorite-btn.favorited .heart-icon {
      transform: translateY(-5px) scale(1.4);
      color: red;
    }
    /* ================= Close Button ================= */
    .close-modal-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      padding: 10px;  /* Extra padding for spacing */
      background: transparent;
      border: none;
      cursor: pointer;
      transition: transform 0.2s ease;
      outline: none;
      z-index: 1100;
    }
    .close-modal-btn:hover {
      transform: scale(1.1);
    }
    .close-modal-btn svg {
      width: 28px;
      height: 28px;
      fill: red;  /* Cross icon in red */
    }
    /* Responsive */
    @media (max-width: 768px) {
      .modal-card {
        flex-direction: column;
      }
      .modal-card .card-img, 
      .modal-card .card-body {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>
  <!-- ================= Focus Cards Section ================= -->
  <section>
    <h2 class="title-header">New Arrivals</h2>
    <div id="focusCards" class="focus-cards-container">
      <!-- Focus cards will be injected here via JavaScript -->
    </div>
  </section>

  <!-- ================= Modal Overlay (Product Card Modal) ================= -->
  <div id="modalOverlay" class="modal-overlay">
    <div class="modal-card">
      <button class="close-modal-btn" id="closeModal" aria-label="Close">
        <!-- SVG Cross Icon -->
        <svg viewBox="0 0 24 24">
          <path d="M18.3 5.71a1 1 0 00-1.41 0L12 10.59 7.11 5.7A1 1 0 105.7 7.11L10.59 12l-4.89 4.89a1 1 0 101.41 1.41L12 13.41l4.89 4.89a1 1 0 001.41-1.41L13.41 12l4.89-4.89a1 1 0 000-1.4z"/>
        </svg>
      </button>
      <div class="card-img">
        <img src="" alt="Product Image" id="modalImg">
      </div>
      <div class="card-body">
        <div class="product-info">
          <div class="info-left">
            <h3 class="card-title" id="modalTitle">Gizmo Turbo</h3>
            <div style="display:flex; align-items:center; margin-top:1rem; font-size:14px;">
              <span class="profile-icon">
                <i class="dwg-user" style="font-size:12px; color:#fff;"></i>
              </span>
              <span id="modalAuthor">John Doe</span>
            </div>
          </div>
          <div class="info-right">
            <div class="price" id="modalPrice">$19.99</div>
            <div class="units-sold">
              Sold: <span style="color:#7e36f4;" id="modalSold">25</span>
            </div>
          </div>
        </div>
        <!-- Random description text -->
        <p class="description" id="modalDesc">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ac leo nunc. Vestibulum et mauris vel ante finibus maximus.
        </p>
        <div class="btn-group">
          <button class="add-to-cart-btn" id="modalCartBtn">
            <span class="cart-icon"><i class="fas fa-shopping-cart"></i></span>
            <span class="btn-text">Add to Cart</span>
            <span class="speed-car"><i class="fa-solid fa-car-side"></i></span>
          </button>
          <button class="favorite-btn" id="modalFavBtn">
            <span class="heart-icon">❤</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ================= JavaScript ================= -->
  <script>
    // Data for focus cards with new names, details, random descriptions
    const focusData = [
      {
        title: "Gizmo Turbo",
        image: "https://plus.unsplash.com/premium_photo-1661753668576-d7e14f27edf4?q=80&w=1470&auto=format&fit=crop",
        author: "John Doe",
        price: "$19.99",
        sold: 25,
        description: "Experience blazing speed with Gizmo Turbo—built for performance and style. Perfect for on-the-go enthusiasts."
      },
      {
        title: "Widget Supreme",
        image: "https://images.unsplash.com/photo-1588200908342-23b585c03e26?q=80&w=1470&auto=format&fit=crop",
        author: "Jane Smith",
        price: "$24.99",
        sold: 30,
        description: "Widget Supreme sets the standard in quality and innovation, offering a superior experience in everyday tech."
      },
      {
        title: "Mega Gadget",
        image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=1470&auto=format&fit=crop",
        author: "Alice Cooper",
        price: "$29.99",
        sold: 40,
        description: "Mega Gadget redefines versatility with cutting-edge features, perfect for those who demand more from their devices."
      },
      {
        title: "Quantum Widget",
        image: "https://images.unsplash.com/photo-1530435460869-d13625c69bbf?q=80&w=1470&auto=format&fit=crop",
        author: "Bob Martin",
        price: "$34.99",
        sold: 18,
        description: "Step into the future with Quantum Widget—designed to elevate your digital experience with its advanced technology."
      },
      {
        title: "Nano Tech",
        image: "https://images.unsplash.com/photo-1625662171891-9a3348f961f4?q=80&w=1470&auto=format&fit=crop",
        author: "Emily Davis",
        price: "$39.99",
        sold: 22,
        description: "Nano Tech combines precision and power in a compact design, ideal for tech-savvy individuals on the move."
      },
      {
        title: "Fusion Device",
        image: "https://plus.unsplash.com/premium_photo-1661582360225-60ba513153e3?q=80&w=1632&auto=format&fit=crop",
        author: "Chris Lee",
        price: "$44.99",
        sold: 35,
        description: "Fusion Device offers unmatched connectivity and performance, blending style with functionality effortlessly."
      },
      {
        title: "Vortex Gear",
        image: "https://images.unsplash.com/photo-1493723843671-1d655e66ac1c?q=80&w=1470&auto=format&fit=crop",
        author: "Samantha Ray",
        price: "$49.99",
        sold: 28,
        description: "Vortex Gear is engineered for dynamic performance and sleek design, a must-have for modern adventurers."
      },
      {
        title: "Alpha Module",
        image: "https://images.unsplash.com/photo-1612171709946-7fc1298a5a53?q=80&w=1526&auto=format&fit=crop",
        author: "Michael Chen",
        price: "$54.99",
        sold: 32,
        description: "Alpha Module stands at the forefront of innovation, delivering cutting-edge technology in a refined package."
      }
    ];

    // Render focus cards into container
    function renderFocusCards(data) {
      const container = document.getElementById('focusCards');
      data.forEach(item => {
        const card = document.createElement('div');
        card.classList.add('focus-card');
        card.dataset.title = item.title;
        card.dataset.image = item.image;
        card.dataset.author = item.author;
        card.dataset.price = item.price;
        card.dataset.sold = item.sold;
        card.dataset.description = item.description;
        
        const img = document.createElement('img');
        img.src = item.image;
        img.alt = item.title;
        
        const titleDiv = document.createElement('div');
        titleDiv.classList.add('card-title');
        titleDiv.textContent = item.title;
        
        card.appendChild(img);
        card.appendChild(titleDiv);
        container.appendChild(card);
      });
    }

    // Modal interactions
    function openModal(item) {
      const modalOverlay = document.getElementById('modalOverlay');
      document.getElementById('modalImg').src = item.image;
      document.getElementById('modalTitle').textContent = item.title;
      document.getElementById('modalAuthor').textContent = item.author;
      document.getElementById('modalPrice').textContent = item.price;
      document.getElementById('modalSold').textContent = item.sold;
      document.getElementById('modalDesc').textContent = item.description;
      modalOverlay.classList.add('active');
    }

    function closeModal() {
      document.getElementById('modalOverlay').classList.remove('active');
    }

    // Simulate add-to-cart animation on modal button click
    function handleCartClick(btn) {
      if(btn.classList.contains('final')) return;
      btn.classList.add('added');
      setTimeout(() => {
        btn.querySelector('.btn-text').textContent = 'Added!';
        btn.classList.remove('added');
        btn.classList.add('final');
      }, 700);
    }

    document.addEventListener('DOMContentLoaded', () => {
      renderFocusCards(focusData);
      
      const focusCards = document.querySelectorAll('.focus-card');
      const modalOverlay = document.getElementById('modalOverlay');
      const container = document.getElementById('focusCards');

      // Hover effects: blur siblings when one is active
      focusCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
          focusCards.forEach(c => c.classList.remove('active'));
          card.classList.add('active');
          container.classList.add('focus-active');
        });
      });
      container.addEventListener('mouseleave', () => {
        container.classList.remove('focus-active');
        focusCards.forEach(c => c.classList.remove('active'));
      });
      
      // Click on focus card to open modal with product card style
      focusCards.forEach(card => {
        card.addEventListener('click', () => {
          const item = {
            title: card.dataset.title,
            image: card.dataset.image,
            author: card.dataset.author,
            price: card.dataset.price,
            sold: card.dataset.sold,
            description: card.dataset.description
          };
          openModal(item);
        });
      });
      
      // Close modal events
      document.getElementById('closeModal').addEventListener('click', closeModal);
      modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) closeModal();
      });
      
      // Add-to-Cart button animation on modal card
      const modalCartBtn = document.getElementById('modalCartBtn');
      modalCartBtn.addEventListener('click', () => {
        handleCartClick(modalCartBtn);
      });
      
      // Favorite button toggle on modal card
      const modalFavBtn = document.getElementById('modalFavBtn');
      modalFavBtn.addEventListener('click', () => {
        modalFavBtn.classList.toggle('favorited');
      });
    });
  </script>
  <!-- Note: Include Font Awesome for icons if needed -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" /> -->
</body>
</html>
