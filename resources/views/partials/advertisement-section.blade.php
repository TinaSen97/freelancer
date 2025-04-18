<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Stacked Feedback & Promo</title>
  <style>
    /* ========== Global Styles ========== */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5; /* Light container background */
      color: #333;        /* Dark text for contrast on light background */
    }

    h2 {
      font-size: 36px;
      font-weight: bold;
      color: #7e36f4;
      text-align: center;
      margin: 40px 0;
    }

    /* ========== Stacked Feedback Section ========== */
    .stacked-feedback-wrapper {
      width: 60%;
      max-width: 1200px;
      margin: 0 auto 60px auto;
    }

    /* Container that holds all feedback slides */
    .stacked-feedback-container {
      position: relative;
      overflow: hidden;
      min-height: 300px;
    }

    /* Each "slide" is one feedback card */
    .stacked-feedback-card {
      display: flex;
      align-items: center;
      gap: 40px;
      background: #fff;       /* White card background for contrast */
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.5s ease;
    }
    .stacked-feedback-card.active {
      opacity: 1;
      pointer-events: all;
      position: relative;
    }

    /* Left side: stacked images */
    .stacked-images {
      position: relative;
      width: 220px; /* Adjust to taste */
      height: 220px;
      flex-shrink: 0;
    }
    .stacked-behind {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
      opacity: 0.8;
      filter: brightness(0.9);
      z-index: 1;
    }
    .stacked-behind-1 {
      transform: rotate(-8deg) translate(-10px, 15px);
    }
    .stacked-behind-2 {
      transform: rotate(10deg) translate(10px, 20px);
    }
    /* Main image on top */
    .stacked-main {
      position: relative;
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
      z-index: 2;
    }

    /* Right side: name, position, text, controls */
    .feedback-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .feedback-name {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 4px;
      color: #333; /* Dark text on white card */
    }
    .feedback-position {
      font-size: 14px;
      color: #777;
      margin-bottom: 20px;
    }
    .feedback-quote {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
      margin-bottom: 20px;
      max-width: 600px;
    }

    /* Controls */
    .feedback-controls {
      display: flex;
      justify-content: center; /* Center the navigation buttons */
      gap: 12px;
      align-items: center;
    }
    .nav-arrow {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #e0e0e0;
      border: none;
      color: #333;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s, transform 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .nav-arrow:hover {
      background: #ccc;
      transform: scale(1.1);
    }

  </style>
</head>
<body>
  <!-- ========== Stacked Feedback Section ========== -->
  <section class="stacked-feedback-wrapper">
    <h2 class="title-header">Testimonials</h2>
    <div class="stacked-feedback-container">
      <!-- 1) Sarah Chen -->
      <div class="stacked-feedback-card active">
        <div class="stacked-images">
          <img
            src="https://images.unsplash.com/photo-1623582854588-d60de57fa33f?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 1"
            class="stacked-behind stacked-behind-1"
          />
          <img
            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 2"
            class="stacked-behind stacked-behind-2"
          />
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=3560&auto=format&fit=crop"
            alt="Sarah Chen"
            class="stacked-main"
          />
        </div>
        <div class="feedback-content">
          <div class="feedback-name">Sarah Chen</div>
          <div class="feedback-position">Product Manager at TechFlow</div>
          <div class="feedback-quote">
            The attention to detail and innovative features have completely
            transformed our workflow. This is exactly what we've been looking for.
          </div>
          <div class="feedback-controls">
            <button class="nav-arrow" data-dir="prev">&#8592;</button>
            <button class="nav-arrow" data-dir="next">&#8594;</button>
          </div>
        </div>
      </div>

      <!-- 2) Michael Rodriguez -->
      <div class="stacked-feedback-card">
        <div class="stacked-images">
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=3560&auto=format&fit=crop"
            alt="Behind 1"
            class="stacked-behind stacked-behind-1"
          />
          <img
            src="https://images.unsplash.com/photo-1623582854588-d60de57fa33f?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 2"
            class="stacked-behind stacked-behind-2"
          />
          <img
            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=3540&auto=format&fit=crop"
            alt="Michael Rodriguez"
            class="stacked-main"
          />
        </div>
        <div class="feedback-content">
          <div class="feedback-name">Michael Rodriguez</div>
          <div class="feedback-position">CTO at InnovateSphere</div>
          <div class="feedback-quote">
            Implementation was seamless and the results exceeded our expectations.
            The platform's flexibility is remarkable.
          </div>
          <div class="feedback-controls">
            <button class="nav-arrow" data-dir="prev">&#8592;</button>
            <button class="nav-arrow" data-dir="next">&#8594;</button>
          </div>
        </div>
      </div>

      <!-- 3) Emily Watson -->
      <div class="stacked-feedback-card">
        <div class="stacked-images">
          <img
            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 1"
            class="stacked-behind stacked-behind-1"
          />
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=3560&auto=format&fit=crop"
            alt="Behind 2"
            class="stacked-behind stacked-behind-2"
          />
          <img
            src="https://images.unsplash.com/photo-1623582854588-d60de57fa33f?q=80&w=3540&auto=format&fit=crop"
            alt="Emily Watson"
            class="stacked-main"
          />
        </div>
        <div class="feedback-content">
          <div class="feedback-name">Emily Watson</div>
          <div class="feedback-position">Operations Director at CloudScale</div>
          <div class="feedback-quote">
            This solution has significantly improved our team's productivity.
            The intuitive interface makes complex tasks simple.
          </div>
          <div class="feedback-controls">
            <button class="nav-arrow" data-dir="prev">&#8592;</button>
            <button class="nav-arrow" data-dir="next">&#8594;</button>
          </div>
        </div>
      </div>

      <!-- 4) James Kim -->
      <div class="stacked-feedback-card">
        <div class="stacked-images">
          <img
            src="https://images.unsplash.com/photo-1623582854588-d60de57fa33f?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 1"
            class="stacked-behind stacked-behind-1"
          />
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=3560&auto=format&fit=crop"
            alt="Behind 2"
            class="stacked-behind stacked-behind-2"
          />
          <img
            src="https://images.unsplash.com/photo-1636041293178-808a6762ab39?q=80&w=3464&auto=format&fit=crop"
            alt="James Kim"
            class="stacked-main"
          />
        </div>
        <div class="feedback-content">
          <div class="feedback-name">James Kim</div>
          <div class="feedback-position">Engineering Lead at DataPro</div>
          <div class="feedback-quote">
            Outstanding support and robust features. It's rare to find a product
            that delivers on all its promises.
          </div>
          <div class="feedback-controls">
            <button class="nav-arrow" data-dir="prev">&#8592;</button>
            <button class="nav-arrow" data-dir="next">&#8594;</button>
          </div>
        </div>
      </div>

      <!-- 5) Lisa Thompson -->
      <div class="stacked-feedback-card">
        <div class="stacked-images">
          <img
            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=3560&auto=format&fit=crop"
            alt="Behind 1"
            class="stacked-behind stacked-behind-1"
          />
          <img
            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=3540&auto=format&fit=crop"
            alt="Behind 2"
            class="stacked-behind stacked-behind-2"
          />
          <img
            src="https://images.unsplash.com/photo-1624561172888-ac93c696e10c?q=80&w=2592&auto=format&fit=crop"
            alt="Lisa Thompson"
            class="stacked-main"
          />
        </div>
        <div class="feedback-content">
          <div class="feedback-name">Lisa Thompson</div>
          <div class="feedback-position">VP of Technology at FutureNet</div>
          <div class="feedback-quote">
            The scalability and performance have been game-changing for our organization.
            Highly recommend to any growing business.
          </div>
          <div class="feedback-controls">
            <button class="nav-arrow" data-dir="prev">&#8592;</button>
            <button class="nav-arrow" data-dir="next">&#8594;</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  

  <script>
    const feedbackSlides = document.querySelectorAll(".stacked-feedback-card");
    let currentIndex = 0;

    // Attach event listeners to each pair of arrow buttons in each slide
    feedbackSlides.forEach((slide) => {
      const buttons = slide.querySelectorAll(".nav-arrow");
      const [prevBtn, nextBtn] = buttons;
      prevBtn.addEventListener("click", () => showSlide(currentIndex - 1));
      nextBtn.addEventListener("click", () => showSlide(currentIndex + 1));
    });

    function showSlide(newIndex) {
      feedbackSlides[currentIndex].classList.remove("active");
      currentIndex = (newIndex + feedbackSlides.length) % feedbackSlides.length;
      feedbackSlides[currentIndex].classList.add("active");
    }
  </script>
</body>
</html>
