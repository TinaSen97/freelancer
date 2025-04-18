<!-- 3D CARD EXPERIENCE SECTION -->
<section class="three-d-card-section py-5">
  <style>
    .three-d-card-container {
      perspective: 1200px;
      margin: auto;
      width: 30rem;
    }
    .card-body {
      background: linear-gradient(135deg, #ffffff, #f2f2f2);
      border-radius: 1rem;
      padding: 2rem;
      transform-style: preserve-3d;
      transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      position: relative;
    }
    .three-d-card-container:hover .card-body {
      transform: rotateY(12deg) rotateX(8deg);
    }
    .card-item { position: relative; }
    .card-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #333;
      transform: translateZ(40px);
      margin-bottom: 0.5rem;
    }
    .card-description {
      font-size: 1rem;
      color: #555;
      transform: translateZ(50px);
      margin-bottom: 1rem;
    }
    .card-image {
      transform: translateZ(80px) rotateX(5deg);
      margin-bottom: 1.5rem;
      overflow: hidden;
      border-radius: 0.75rem;
    }
    .card-image img {
      width: 100%;
      transition: transform 0.3s ease, filter 0.3s ease;
    }
    .card-image img:hover {
      transform: scale(1.05);
      filter: brightness(1.05);
    }
    .card-actions {
      display: flex;
      justify-content: space-between;
    }
    .card-button {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 0.5rem;
      cursor: pointer;
      font-size: 0.9rem;
      transform: translateZ(20px);
      transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }
    .try-now { background: #7e36f4; color: #fff; }
    .sign-up { background: #333; color: #fff; }
    .card-button:hover {
      transform: translateZ(20px) translateY(-4px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
  </style>
  <div class="container">
    <h2 class="mb-4 text-center" style="font-weight: bold; color:black;">3D Card Experience</h2>
    <div class="three-d-card-container">
      <div class="card-body">
        <div class="card-item card-title">Elevate Your Experience</div>
        <div class="card-item card-description">Hover over this card to explore dynamic 3D effects that bring content to life.</div>
        <div class="card-item card-image">
          <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2560&auto=format&fit=crop" alt="3D Experience">
        </div>
        <div class="card-actions">
          <button class="card-item card-button try-now animated-btn">Discover</button>
          <button class="card-item card-button sign-up animated-btn">Get Started</button>
        </div>
      </div>
    </div>
  </div>
</section>
