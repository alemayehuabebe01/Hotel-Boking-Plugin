<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Unique Hero Slider</title>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Outfit', sans-serif;
    }

    .villa-hero-slider {
      height: 100vh;
      width: 100vw;
      position: relative;
    }

    .villa-hero-slider .swiper-slide {
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .villa-hero-slider .swiper-slide::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3));
      z-index: 1;
    }

    .villa-hero-content {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      padding: 2rem 3rem;
      border-radius: 16px;
      text-align: center;
      color: #fff;
      max-width: 700px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
      animation: fadeUp 1.2s ease both;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(40px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .villa-hero-content h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .villa-hero-content p {
      font-size: 1.25rem;
      margin-bottom: 2rem;
      color: #ddd;
    }

    .villa-hero-btn {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      padding: 1rem 2.5rem;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      border-radius: 50px;
      text-decoration: none;
      box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: inline-block;
    }

    .villa-hero-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 32px rgba(16, 185, 129, 0.5);
    }

    /* Scoped navigation */
    .villa-hero-slider .villa-hero-next,
    .villa-hero-slider .villa-hero-prev {
      color: #fff;
      width: 44px;
      height: 44px;
    }

    .villa-hero-slider .villa-hero-pagination .swiper-pagination-bullet {
      background: #fff;
      opacity: 0.5;
    }

    .villa-hero-slider .villa-hero-pagination .swiper-pagination-bullet-active {
      background: #10b981;
      opacity: 1;
    }

    @media (max-width: 768px) {
      .villa-hero-content h1 {
        font-size: 2.2rem;
      }
      .villa-hero-content p {
        font-size: 1rem;
      }
      .villa-hero-content {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>

  <!-- Unique HERO SLIDER -->
  <div class="villa-hero-slider swiper">
    <div class="swiper-wrapper">

      <!-- Slide 1 -->
      <div class="swiper-slide" style="background-image: url('https://picsum.photos/id/1016/1600/900');">
        <div class="villa-hero-content">
          <h1>Escape to Paradise</h1>
          <p>Luxury villas in Italy’s most beautiful regions.</p>
          <a href="#villas" class="villa-hero-btn">Explore Villas</a>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="swiper-slide" style="background-image: url('https://picsum.photos/id/1015/1600/900');">
        <div class="villa-hero-content">
          <h1>Wake Up to Beauty</h1>
          <p>Mountain views, wine, and unforgettable stays.</p>
          <a href="#villas" class="villa-hero-btn">View Locations</a>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="swiper-slide" style="background-image: url('https://picsum.photos/id/1020/1600/900');">
        <div class="villa-hero-content">
          <h1>Your Private Getaway</h1>
          <p>Peace. Privacy. Pool included.</p>
          <a href="#villas" class="villa-hero-btn">Book Now</a>
        </div>
      </div>

    </div>

    <!-- Custom Navigation -->
    <div class="villa-hero-prev swiper-button-prev"></div>
    <div class="villa-hero-next swiper-button-next"></div>
    <div class="villa-hero-pagination swiper-pagination"></div>
  </div>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
  <script>
    new Swiper(".villa-hero-slider", {
      loop: true,
      effect: "fade",
      speed: 1000,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".villa-hero-next",
        prevEl: ".villa-hero-prev",
      },
      pagination: {
        el: ".villa-hero-pagination",
        clickable: true,
      },
    });
  </script>
</body>
</html>
