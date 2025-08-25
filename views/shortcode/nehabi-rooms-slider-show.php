<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Room Slider</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .room-slider {
            padding: 40px 0;
            background: white;
        }
        
        .room-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .room-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .room-img {
            height: 250px;
            overflow: hidden;
            position: relative;
        }
        
        .room-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .room-card:hover .room-img img {
            transform: scale(1.05);
        }
        
        .room-price {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 700;
            color: #2c3e50;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .room-details {
            padding: 25px;
        }
        
        .room-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .room-features {
            margin: 15px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .room-feature {
            display: flex;
            align-items: center;
            margin-right: 15px;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .room-feature i {
            margin-right: 5px;
            color: #3498db;
        }
        
        .room-description {
            color: #7f8c8d;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .btn-book {
            background: #3498db;
            color: white;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-book:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
        
        .slider-controls {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
        }
        
        .slider-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .slider-btn:hover {
            background: #3498db;
            color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
        }
        
        .section-title h2 {
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .section-title p {
            color: #7f8c8d;
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .room-img {
                height: 200px;
            }
            
            .room-details {
                padding: 20px;
            }
            
            .room-features {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>

<section class="room-slider">
    <div class="container">
        <div class="section-title">
            <h2>Our Accommodations</h2>
            <p>Discover our selection of comfortable and stylish rooms for your perfect stay</p>
        </div>
        
        <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <!-- Room 1 -->
                <div id="roomsCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php
    $args = array(
      'post_type'      => 'accommodation',
      'posts_per_page' => -1, // load all accommodations
      'post_status'    => 'publish'
    );
    $rooms = new WP_Query($args);

    if ($rooms->have_posts()) :
      $i = 0; // counter for carousel items
      while ($rooms->have_posts()) : $rooms->the_post();

        // Fetch fields
        $thumb     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        $price     = get_post_meta(get_the_ID(), '_accommodation_price', true); 
        $child    = get_post_meta(get_the_ID(), '_accommodation_children', true);
        $capacity      = get_post_meta(get_the_ID(), '_accommodation_capacity', true);
        $size     = get_post_meta(get_the_ID(), '_accommodation_size', true);
        $excerpt   = get_the_excerpt();
        
        // Start a new carousel-item every 3 posts
        if ($i % 3 == 0) :
          echo '<div class="carousel-item ' . ($i == 0 ? 'active' : '') . '"><div class="row">';
        endif;
        ?>
        
        <div class="col-md-4 mb-4">
          <div class="room-card">
            <div class="room-img">
              <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title(); ?>">
              <?php if ($price): ?>
                <div class="room-price"><?php echo esc_html($price); ?>/night</div>
              <?php endif; ?>
            </div>
            <div class="room-details">
              <h3 class="room-title"><?php the_title(); ?></h3>
              <div class="room-features">
                <?php if ($child): ?>
                  <span class="room-feature"><i class="fas fa-child"></i> <?php echo esc_html($child); ?> childs</span>
                <?php endif; ?>
                <?php if ($capacity): ?>
                  <span class="room-feature"><i class="fas fa-user-friends"></i> <?php echo esc_html($capacity); ?> capacity</span>
                <?php endif; ?>
                <?php if ($size): ?>
                  <span class="room-feature"><i class="fas fa-ruler-combined"></i> <?php echo esc_html($size); ?> Baths</span>
                <?php endif; ?>
              </div>
              <p class="room-description"><?php echo wp_trim_words($excerpt, 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn-book">Book Now</a>
            </div>
          </div>
        </div>

        <?php
        // Close row and carousel-item after 3 posts
        if ($i % 3 == 2) :
          echo '</div></div>';
        endif;

        $i++;
      endwhile;

      // Close last group if not closed
      if ($i % 3 != 0) :
        echo '</div></div>';
      endif;

      wp_reset_postdata();
    else :
      echo '<div class="carousel-item active"><div class="row"><div class="col-12"><p>No accommodations found.</p></div></div></div>';
    endif;
    ?>
  </div>

  
</div>

            
            
            <div class="slider-controls">
                <div class="slider-btn" data-bs-target="#roomCarousel" data-bs-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="slider-btn" data-bs-target="#roomCarousel" data-bs-slide="next">
                    <i class="fas fa-chevron-right"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>