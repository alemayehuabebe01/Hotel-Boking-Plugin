<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Villa Grid</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
     

    .room-grid {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      gap: 1.2rem;
      max-width: 1400px;
      margin: auto;
    }

    @media (min-width: 576px) {
      .room-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (min-width: 768px) {
      .room-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (min-width: 992px) {
      .room-grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .room-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 100%;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }

    .room-card:hover {
      transform: translateY(-4px);
    }

    .room-img-wrapper img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .room-info {
      padding: 1rem 1.2rem;
      display: flex;
      flex-direction: column;
      flex-grow: 1;
    }

    .room-info h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      color: #111827;
    }

    .room-description {
      font-size: 0.9rem;
      color: #4b5563;
      margin-bottom: 1rem;
    }

    .room-meta-grid {
      display: flex;
      justify-content: start;
      gap: 2rem;
      font-size: 0.9rem;
      color: #374151;
      border-top: 1px solid #e5e7eb;
      border-bottom: 1px solid #e5e7eb;
      padding: 0.6rem 0;
      margin-bottom: 1rem;
    }

    .room-meta-grid i {
      margin-right: 0.4rem;
      color: #6b7280;
    }

    .room-amenities {
      font-size: 0.85rem;
      color: #6b7280;
      margin-bottom: 1rem;
      line-height: 1.4;
    }

    .room-amenities .highlight {
      color: #10b981;
      font-weight: 500;
    }

    .price-line {
      font-size: 0.95rem;
      color: #374151;
      margin-bottom: 1rem;
    }

    .price-line .price {
      font-size: 1.1rem;
      color: #111827;
      font-weight: 700;
    }

    .room-buttons {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-top: auto;
    }

    .btn {
      background-color: #10b981;
      color: white;
      padding: 0.5rem 1.4rem;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
      transition: background 0.2s ease;
    }

    .btn:hover {
      background-color: #059669;
    }

    .details-link {
      font-size: 0.9rem;
      color: #4b5563;
      text-decoration: none;
      border-bottom: 1px dotted #4b5563;
    }

    .details-link:hover {
      color: #111827;
      border-color: #111827;
    }
  </style>
</head>
<body>

<div class="room-grid">


  <!-- Repeat this room-card 4x -->
   <?php
    $rooms_args = array(
        'post_type'      => 'nh_rooms',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $get_rooms = new WP_Query($rooms_args);

    if ( $get_rooms->have_posts() ) {
        while ( $get_rooms->have_posts() ) {
            $get_rooms->the_post();

            $room_id = get_the_ID();
            
            // Get linked accommodation ID from room meta
            $linked_accommodation_id = get_post_meta($room_id, '_selected_accommodation_type', true);

            // Pull accommodation details
            $accommodation_title = '';
            $accommodation_image = '';
            $accommodation_desc  = '';

            if ( $linked_accommodation_id ) {
                $accommodation_post = get_post($linked_accommodation_id);

                if ( $accommodation_post && $accommodation_post->post_type === 'accommodation' && $accommodation_post->post_status === 'publish' ) {
                    $accommodation_title = get_the_title($accommodation_post->ID);
                    $accommodation_image = get_the_post_thumbnail_url($accommodation_post->ID, 'large');
                    $accommodation_desc  = wp_trim_words($accommodation_post->post_content, 10, '...');
                    $accommodation_cappacity = get_post_meta($accommodation_post->ID, '_accommodation_capacity',true) ? : 'N/A';
                    $accommodation_size = get_post_meta($accommodation_post->ID, '_accommodation_size', true) ? : 'N/A';
                    $accommodation_childern = get_post_meta($accommodation_post->ID,'_accommodation_children',true) ? : 'N/A';
                    $accommodation_amenities = wp_get_post_terms(
                        $accommodation_post->ID,
                        'accommodation_amenity',
                        array('fields' => 'names')
                    );

                    $view = get_post_meta($accommodation_post->ID, '_accommodation_view', true) ? : 'N/A';
                    $bed_type = get_post_meta($accommodation_post->ID, '_accommodation_bed_type', true) ? : 'N/A';
                    $price = get_post_meta($accommodation_post->ID, '_accommodation_price', true) ? : 'N/A';

                }
            }

             
            ?>

            <div class="room-card">
                <!-- <div class="room-img-wrapper">
                    <img src="<?php echo esc_url($room_image ?: 'https://via.placeholder.com/400x250'); ?>" alt="<?php the_title_attribute(); ?>">
                </div> -->
                <div class="room-info">
               <?php if ( $accommodation_title ) : ?> 
                        <h3><?php echo esc_html($accommodation_title); ?></h3>
                        <?php if ( $accommodation_image ) : ?>
                            <img src="<?php echo esc_url($accommodation_image); ?>" alt="<?php echo esc_attr($accommodation_title); ?>" class="accommodation-img">
                        <?php endif; ?>
                        <?php if ( $accommodation_desc ) : ?>
                            <p class="accommodation-description"><?php echo esc_html($accommodation_desc); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- <p class="room-description"><?php the_content(); ?></p> -->
                    <div class="room-meta-grid">
                        <div><i class="fas fa-users"></i> <?php echo esc_html($accommodation_cappacity); ?></div>
                         <div><i class="fas fa-user"></i> <?php echo esc_html($accommodation_childern); ?></div>
                        <div><i class="fas fa-ruler-combined"></i> <?php echo esc_html($accommodation_size).' m²'; ?></div>
                    </div>
                    <p class="room-amenities">
                        <strong>Amenities:</strong> <?php echo esc_html( implode(', ', $accommodation_amenities) ); ?><br>
                        <strong>View:</strong> <?php echo esc_html($view); ?><br>
                        <strong>Bed Type:</strong> <?php echo esc_html($bed_type); ?>
                    </p>
                    <!-- <div class="price-line">
                        Prices start at: <strong class="price">$<?php echo esc_html($price); ?></strong> for <?php echo esc_html($nights); ?> nights (+taxes and fees)
                    </div> -->
                    <div class="room-buttons">
                        <a href="<?php echo esc_url('/book/' . $room_id); ?>" class="btn">BOOK</a>
                        <a href="<?php echo esc_url('/rooms/' . $room_id); ?>" class="details-link">View Details</a>
                    </div>
                </div>
            </div>

            <?php
        }
        wp_reset_postdata();
}
?>
   

   

</div>

</body>
</html>
