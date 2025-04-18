<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>3D Experience Section</title>
  <style>
    /* ========== Global Reset & Basic Styles ========== */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
    }
    /* ========== Main Section Styles ========== */
    .three-d-experience-section {
      background: #000; /* Dark background */
      color: #fff;
      padding: 60px 20px;
    }
    .three-d-experience-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 40px;
    }
    /* Left Column (Info) */
    .three-d-experience-info {
      flex: 1;
      max-width: 500px;
    }
    /* Profile Row: Separate profile info & blockchain-label */
    .profile-row {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .profile-info {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    .profile-name {
      font-size: 0.9rem;
      font-weight: bold;
      background: #333;
      padding: 0.4rem 0.7rem;
      border-radius: 4px;
    }
    .blockchain-label {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
      font-weight: bold;
      background: #333;
      padding: 0.4rem 0.7rem;
      border-radius: 4px;
    }
    .blockchain-label img {
      width: 20px;
      height: 20px;
      object-fit: cover;
    }
    /* Heading (Product Name) */
    .main-heading {
      font-size: 3rem;      /* Larger font size */
      font-weight: 700;
      margin-bottom: 1rem;
      color: #fff;          /* White text */
      line-height: 1.2;
    }
    /* Price Info */
    .buy-now-text {
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }
    .discounted-price {
      font-size: 1.5rem;
      margin-right: 10px;
      display: inline-block;
    }
    .original-price {
      font-size: 1rem;
      color: #888;
      text-decoration: line-through;
      display: inline-block;
    }
    /* Button */
    .buy-button {
      margin-top: 1.5rem;
      background: #fff;
      color: #000;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .buy-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(255,255,255,0.2);
    }
    /* Right Column (Image) */
    .three-d-experience-visual {
      flex: 1;
      width: 600px;
    }
    .three-d-experience-visual img {
      width: 100%;
      height: auto;
      display: block;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <!-- 3D Experience Section -->
  <section class="three-d-experience-section">
    <div class="three-d-experience-container">
      <!-- Left Column (Info) -->
      <div class="three-d-experience-info">
        <!-- Profile Row with separate profile info & blockchain label -->
        <div class="profile-row">
          <div class="profile-info">
            <img
              src="https://ui8-crypter-2.herokuapp.com/img/content/artists/artist-1.jpg"
              alt="User Profile"
              class="profile-pic"
            />
            <span class="profile-name">@JaneCrypto</span>
          </div>
          <span class="blockchain-label">
            <img
              src="https://bernardmarr.com/img/What%20Is%20Blockchain%20A%20Super%20Simple%20Guide%20Anyone%20Can%20Understand.png"
              alt="Blockchain Icon"
            />
            Blockchain
          </span>
        </div>
        <!-- Product Name: Two lines, large and white -->
        <h1 class="main-heading">Ultra Flexi<br>Dynamo</h1>
        <!-- Price Info -->
        <p class="buy-now-text">Buy now at discounted price</p>
        <div>
          <span class="discounted-price">$10.99</span>
          <span class="original-price">$99</span>
        </div>
        <!-- Button -->
        <button class="buy-button">Buy Now</button>
      </div>
      <!-- Right Column (Image) -->
      <div class="three-d-experience-visual">
        <img
          src="https://img.freepik.com/free-psd/various-web-printable-templates-with-screen_23-2148450117.jpg"
          alt="3D Experience Visual"
        />
      </div>
    </div>
  </section>
</body>
</html>
