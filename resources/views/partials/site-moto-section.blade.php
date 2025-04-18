<!-- SITE MOTO SECTION -->
<section class="site-moto">
  <style>
    .site-moto {
      background-image: url('{{ asset("public/storage/settings/160517454011.jpg") }}');
      color: #fff;
      padding: 60px 0;
      text-align: center;
      position: relative;
    }
    .site-moto::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(180deg, rgba(19,19,19,0.4), rgba(0,0,0,0.7));
      z-index: 1;
    }
    .site-moto .container { position: relative; z-index: 2; }
    .site-moto h2 {
      font-size: 32px;
      margin-bottom: 20px;
      font-weight: bold;
      color: #fff!important;
    }
  </style>
  <div class="container" data-aos="zoom-in" data-aos-delay="100">
    <h2>Why Choose codemarket.ai - World's First AI Coding Script Marketplace?</h2>
    <p>Discover cutting-edge AI-powered coding scripts that empower developers worldwide to innovate and build smarter solutions faster than ever.</p>
  </div>
</section>
