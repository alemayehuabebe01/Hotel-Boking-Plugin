<?php
/**
 * Template for Single Accommodation (Room)
 */
get_header(); 

?>

<!-- Add Bootstrap CDN links in the template -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid px-0">

    <?php while ( have_posts() ) : the_post(); ?>
    
        <!-- Hero Section with Image Gallery -->
        <div class="row g-0">
            <div class="col-lg-8">
                <div class="ratio ratio-16x9 bg-dark">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail('full', ['class' => 'img-fluid w-100 h-100 object-fit-cover']); ?>
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-secondary text-white">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-4 bg-light d-flex align-items-center">
                <div class="p-4 p-lg-5 w-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="fw-bold mb-2"><?php the_title(); ?></h1>
                            <div class="d-flex align-items-center mb-3">
                                <div class="text-warning me-2">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="bi bi-star-fill"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-muted">5.0 (24 reviews)</span>
                            </div>
                        </div>
                         
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        <span>
                            <?php
                            // Get the terms for the 'accommodation_category' taxonomy
                            $terms = get_the_terms(get_the_ID(), 'accommodation_category');
                            if ($terms && !is_wp_error($terms)) {
                                // Just output the first term name (or loop if multiple)
                                echo esc_html($terms[0]->name);
                            } else {
                                echo 'No category assigned';
                            }
                            ?>
                        </span>
                    </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            <span>Max <?php echo esc_html(get_post_meta(get_the_ID(), '_accommodation_capacity', true)); ?> guests</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-layout-wtf text-primary me-2"></i>
                            <span><?php echo esc_html(get_post_meta(get_the_ID(), '_accommodation_size', true)); ?> sqm</span>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-3 shadow-sm mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Price</h4>
                            <h5 class="text-primary fw-bold mb-0">
                                <?php echo esc_html(get_post_meta(get_the_ID(), '_accommodation_price', true)); ?> ETB 
                                <small class="text-muted fs-6 fw-light">/ night</small>
                            </h5>
                        </div>
                        <a href="#booking-form" class="btn btn-primary w-100 py-3 fw-bold">
                            <i class="bi bi-calendar-check me-2"></i> Book Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="container py-5">
            <div class="row">
                <!-- Left Content -->
                <div class="col-lg-8 pe-lg-5">
                    <!-- Amenities -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Amenities</h3>
                            <div class="row g-3">
                                <?php 
                                 $accommodation_amenities = wp_get_post_terms(
                                        get_the_ID(),
                                        'accommodation_amenity',
                                        array('fields' => 'names')
                                    );
                                if ($accommodation_amenities) : 
                                    foreach ($accommodation_amenities as $amenity) :
                                ?>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        <span><?php echo esc_html($amenity); ?></span>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Description</h3>
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <!-- Gallery -->
                    <!-- Gallery -->
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Gallery</h3>
                            <div class="row g-3">
                                <?php 
                                $gallery_ids = get_post_meta(get_the_ID(), '_photo_gallery_ids', true);
                                $gallery_ids = is_array($gallery_ids) ? $gallery_ids : [];

                                if (!empty($gallery_ids)) :
                                    // Show only first 4 images for preview
                                    foreach (array_slice($gallery_ids, 0, 4) as $id) :
                                        $img_url = wp_get_attachment_image_url($id, 'large'); // Change size as needed
                                        if ($img_url) :
                                ?>
                                    <div class="col-md-6">
                                        <img src="<?php echo esc_url($img_url); ?>" 
                                            class="img-fluid rounded-3 w-100 h-100 object-fit-cover" 
                                            style="height: 200px;" 
                                            alt="<?php echo esc_attr(get_the_title($id)); ?>">
                                    </div>
                                <?php 
                                        endif;
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Reviews -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="mb-4">Guest Reviews</h3>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fw-bold me-2">5.0</span>
                                    <div class="text-warning me-2">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <i class="bi bi-star-fill"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-muted">24 reviews</span>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress mb-1" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <div class="border-top pt-4">
                                <div class="d-flex mb-4">
                                    <img src="https://randomuser.me/api/portraits/women/43.jpg" class="rounded-circle me-3" width="50" height="50" alt="User">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="fw-bold mb-0 me-2">Sarah Johnson</h6>
                                            <div class="text-warning">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <i class="bi bi-star-fill fs-6"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <small class="text-muted">Stayed on March 15, 2023</small>
                                        <p class="mt-2 mb-0">Beautiful room with amazing views. The service was exceptional and the amenities were top-notch.</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle me-3" width="50" height="50" alt="User">
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="fw-bold mb-0 me-2">Michael Chen</h6>
                                            <div class="text-warning">
                                                <?php for ($i = 0; $i < 5; $i++): ?>
                                                    <i class="bi bi-star-fill fs-6"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <small class="text-muted">Stayed on February 28, 2023</small>
                                        <p class="mt-2 mb-0">Perfect location and very comfortable bed. Would definitely stay here again on my next visit.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              
                
                <!-- Right Sidebar - Booking Form -->
               <div class="col-lg-4">

               <!-- check the availablity of the room -->

              <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center">Check Availability</h3>

                    <form id="availability-check-form">
                        <input type="hidden" name="action" value="check_accommodation_availability">
                        <input type="hidden" name="accommodation_id" value="<?php echo esc_attr(get_the_ID()); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Check-in</label>
                            <input type="date" name="checkin" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Check-out</label>
                            <input type="date" name="checkout" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-search"></i> Check Availability
                        </button>
                    </form>

                    <div id="availability-result" class="mt-3"></div>
                </div>
            </div>







                    <div id="booking-form" class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h3 class="mb-4 text-center">Reserve Your Stay</h3>

                            <?php
                            $accommodation_id = get_the_ID();
                            $price_per_night  = (float) get_post_meta($accommodation_id, '_accommodation_price', true);
                            $rooms_left       = (int) get_post_meta($accommodation_id, '_accommodation_count', true);
                            $room_status      = strtolower((string) get_post_meta($accommodation_id, '_room_status', true));
                            $available        = ($rooms_left > 0 && $room_status !== 'booked');

                            $today    = date('Y-m-d');
                            $tomorrow = date('Y-m-d', strtotime('+1 day'));
                            ?>

                            <?php if ($available): ?>
                                <form method="post" action="">
                                    <?php wp_nonce_field('wishu_booking_nonce', 'wishu_booking_nonce_field'); ?>
                                    <input type="hidden" name="accommodation_id" value="<?php echo esc_attr($accommodation_id); ?>">
                                    <input type="hidden" name="start_booking" value="1">
                                    <input type="hidden" id="price_per_night" value="<?php echo esc_attr($price_per_night); ?>">

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Check-in</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar"></i></span>
                                            <input type="date" name="checkin" id="checkin" class="form-control" min="<?php echo esc_attr($today); ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Check-out</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-calendar"></i></span>
                                            <input type="date" name="checkout" id="checkout" class="form-control" min="<?php echo esc_attr($tomorrow); ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Guests</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-people"></i></span>
                                            <select name="guests" class="form-select" required>
                                                <option value="1">1 Guest</option>
                                                <option value="2">2 Guests</option>
                                                <option value="3">3 Guests</option>
                                                <option value="4">4 Guests</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                            <input type="text" name="fullname" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Phone</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-telephone"></i></span>
                                            <input type="tel" name="phone" class="form-control">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Special Requests</label>
                                        <textarea name="requests" rows="3" class="form-control" placeholder="Any special requirements..."></textarea>
                                    </div>

                                    <!-- Total Price Display -->
                                    <div class="mb-4">
                                        <h5>Total: <span id="total_price">0</span> ETB</h5>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                                        Confirm Booking
                                    </button>
                                </form>

                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-shield-lock me-1"></i> Your information is secure
                                    </small>
                                </div>

                                <!-- JS for instant total price calculation -->
                                <script>
                                    const checkin = document.getElementById('checkin');
                                    const checkout = document.getElementById('checkout');
                                    const totalPriceEl = document.getElementById('total_price');
                                    const pricePerNight = parseFloat(document.getElementById('price_per_night').value);

                                    function calculateTotal() {
                                        const start = new Date(checkin.value);
                                        const end = new Date(checkout.value);
                                        if (start && end && end > start) {
                                            const timeDiff = end - start;
                                            const nights = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                                            totalPriceEl.textContent = (nights * pricePerNight).toLocaleString();
                                        } else {
                                            totalPriceEl.textContent = 0;
                                        }
                                    }

                                    checkin.addEventListener('change', calculateTotal);
                                    checkout.addEventListener('change', calculateTotal);
                                </script>
                            <?php else: ?>
                                <div class="alert alert-warning text-center">
                                    This accommodation is currently unavailable.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        
        <!-- Recommended Rooms -->
        <div class="bg-light py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">You may also like</h2>
                    <a href="#" class="btn btn-outline-primary">View All</a>
                </div>
                
                <div class="row g-4">
                    <?php
                    $recommended_rooms = new WP_Query(array(
                        'post_type' => 'accommodation',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand'
                    ));
                    
                    if ($recommended_rooms->have_posts()) :
                        while ($recommended_rooms->have_posts()) : $recommended_rooms->the_post();
                    ?>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="position-relative">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" class="card-img-top" style="height: 220px; object-fit: cover;" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                                <span class="badge bg-primary position-absolute top-0 end-0 m-3">
                                    <?php echo esc_html(get_post_meta(get_the_ID(), 'accommodation_type', true)); ?>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="card-title mb-0"><?php the_title(); ?></h5>
                                    <div class="text-warning">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <i class="bi bi-star-fill fs-6"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="text-muted mb-3"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="text-primary mb-0">
                                        <?php echo esc_html(get_post_meta(get_the_ID(), 'price', true)); ?> ETB 
                                        <small class="text-muted fs-6">/ night</small>
                                    </h5>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
        
    <?php endwhile; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('availability-check-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const resultDiv = document.getElementById('availability-result');
    resultDiv.innerHTML = '<div class="text-center text-muted">Checking...</div>';

    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.available) {
            resultDiv.innerHTML = '<div class="alert alert-success">Available! You can proceed to book.</div>';
        } else {
            resultDiv.innerHTML = '<div class="alert alert-danger">Sorry, these dates are unavailable.</div>';
        }
    })
    .catch(err => {
        resultDiv.innerHTML = '<div class="alert alert-warning">Error checking availability. Please try again.</div>';
    });
});
</script>

<?php get_footer(); ?>