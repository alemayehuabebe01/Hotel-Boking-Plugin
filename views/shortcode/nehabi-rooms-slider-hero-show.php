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

    <?php
    $args = array(
      'post_type'      => 'accommodation',
      'posts_per_page' => 5,
      'post_status'    => 'publish'
    );
    $rooms = new WP_Query($args);

    if ($rooms->have_posts()) :
      while ($rooms->have_posts()) : $rooms->the_post();
        $bg       = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $price    = get_post_meta(get_the_ID(), '_accommodation_price', true); // custom field key: room_price
        $location = get_post_meta(get_the_ID(), 'room_location', true); // custom field key: room_location
        ?>
        
        <div class="swiper-slide" style="background-image: url('<?php echo esc_url($bg); ?>');">
          <div class="villa-hero-content">
            
            <h2 style="color:white;"><?php the_title(); ?></h2>
            
            <?php if ($location): ?>
              <p><strong>📍 <?php echo esc_html($location); ?></strong></p>
            <?php endif; ?>
            
            <?php if ($price): ?>
              <p><strong>💰 <?php echo esc_html($price); ?></strong></p>
            <?php endif; ?>

            <!-- <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p> -->

            <a href="<?php the_permalink(); ?>" class="villa-hero-btn">View Details</a>
          </div>
        </div>
        
        <?php
      endwhile;
      wp_reset_postdata();
    else :
      ?>
      <div class="swiper-slide" style="background:#333;display:flex;align-items:center;justify-content:center;color:#fff;">
        <h2>No rooms available.</h2>
      </div>
    <?php endif; ?>

  </div>

  <!-- Navigation -->
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
