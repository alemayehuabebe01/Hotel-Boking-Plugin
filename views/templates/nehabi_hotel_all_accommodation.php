<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Accommodations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --dark-text: #2c3e50;
            --light-text: #7f8c8d;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text);
            background-color: #f9fafb;
            padding-top: 0;
            margin: 0;
        }
        
        /* Override Astra theme styles that might conflict */
        .site-content #primary {
            width: 100%;
            max-width: 100%;
            padding: 0;
        }
        
        .ast-container {
            max-width: 1200px !important;
            padding: 0 20px !important;
            width: 100% !important;
        }
        
        /* Hide default page header if needed */
        .entry-header {
            display: none;
        }
        
        /* Hero Section - Full Width */
        .hero-section {
            height: 80vh;
            min-height: 600px;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1800&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            margin-bottom: 40px;
        }
        
        .hero-content {
            max-width: 800px;
            padding: 30px;
            position: center;
            z-index: 2;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            margin-top: 80px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 30px;
            font-weight: 300;
            line-height: 1.6;
            color: white;
        }
        
        .hero-search {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }
        
        .search-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .btn-hero {
            background: var(--accent-color);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
        }
        
        .btn-hero:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .custom_header {
            text-align: center;
            margin-bottom: 40px;
            margin-top:200px;
            padding: 20px;
        }
        
        .main-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 50px;
            color : white;
            margin-bottom: 15px;
        }
        
        .subtitle {
            color: var(--light-text);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.1rem;
            color:white;
        }
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }
        
        .filter-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .filter-group {
            margin-bottom: 20px;
        }
        
        .filter-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--primary-color);
        }
        
        .room-grid {
            padding: 20px 0 50px;
        }
        
        .room-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
            margin-bottom: 30px;
        }
        
        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
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
        
        .room-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--accent-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .room-price {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 700;
            color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .room-details {
            padding: 25px;
        }
        
        .room-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: var(--primary-color);
        }
        
        .room-features {
            margin: 15px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .room-feature {
            display: flex;
            align-items: center;
            color: var(--light-text);
            font-size: 0.95rem;
        }
        
        .room-feature i {
            margin-right: 5px;
            color: var(--secondary-color);
        }
        
        .room-description {
            color: var(--light-text);
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        .btn-book {
            background: var(--secondary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            border: none;
            width: 100%;
            text-align: center;
        }
        
        .btn-book:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .rating {
            color: #f39c12;
            margin-bottom: 10px;
        }
        
        .room-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }
        
        .room-type {
            color: var(--secondary-color);
            font-weight: 500;
        }
        
        .room-size {
            color: var(--light-text);
        }
        
        .filter-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover {
            background: var(--primary-color);
        }
        
        .results-count {
            font-size: 1.1rem;
            color: var(--light-text);
            margin-bottom: 20px;
        }
        
        .view-options {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .view-btn {
            background: white;
            border: 1px solid #ddd;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .view-btn.active {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .room-img {
                height: 220px;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 768px) {
            .room-grid {
                padding: 10px 0 30px;
            }
            
            .room-img {
                height: 200px;
            }
            
            .filter-section {
                padding: 20px;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .hero-section {
                min-height: 500px;
                height: 70vh;
            }
            
            .ast-container {
                padding: 0 15px !important;
            }
        }
        
        /* Custom range slider */
        .range-slider {
            width: 100%;
            margin-top: 10px;
        }
        
        .range-values {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            color: var(--light-text);
            font-size: 0.9rem;
        }
        
        /* Custom checkbox */
        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-20px) translateX(-50%);
            }
            60% {
                transform: translateY(-10px) translateX(-50%);
            }
        }
        
        /* WordPress Integration Helpers */
        .wp-integration {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            border-left: 4px solid var(--secondary-color);
        }
        
        .wp-integration h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .code-snippet {
            background: #2c3e50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            overflow-x: auto;
            margin: 15px 0;
        }
        
        /* Astra-specific adjustments */
        .ast-container::before, .ast-container::after {
            display: none;
        }
        
        /* Fix for Astra theme's default content wrapper */
        #primary {
            padding: 0 !important;
            margin: 0 !important;
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
// Astra theme hook before header
if (function_exists('astra_header_before')) {
    astra_header_before();
}
?>

<?php 
// Astra theme header
if (function_exists('astra_header')) {
    astra_header();
}
?>

<?php 
// Astra theme hook after header
if (function_exists('astra_header_after')) {
    astra_header_after();
}
?>

    <!-- Hero Section - Full Width -->
    <section class="hero-section">
        <div class="ast-container">

          <header class="custom_header">
            <h1 class="main-title">Luxury Rooms</h1>
            <p class="subtitle">Discover our exquisite collection of premium rooms and suites for your perfect stay</p>
        </header>


            <div class="hero-content">
                <h1 class="hero-title"> </h1>
                <p class="hero-subtitle"> </p>

               
                
                <!-- <div class="hero-search">
                    <h3 class="search-title"> </h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Check-In</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Check-Out</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Guests</label>
                            <select class="form-select">
                                <option>1 Guest</option>
                                <option>2 Guests</option>
                                <option>3 Guests</option>
                                <option>4+ Guests</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-hero">Check Availability</button>
                </div> -->
            </div>
        </div>
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <div class="ast-container">
        <!-- <header class="header">
             <h1 class="main-title">Luxury Rooms</h1>
            <p class="subtitle">Discover our exquisite collection of premium rooms and suites for your perfect stay</p> 
        </header> -->
        
        <!-- <div class="filter-section">
            <h3 class="filter-title">Find Your Perfect Room</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="filter-group">
                        <label class="filter-label">Room Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="type-suite" checked>
                            <label class="form-check-label" for="type-suite">Suites</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="type-standard" checked>
                            <label class="form-check-label" for="type-standard">Standard Rooms</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="type-family" checked>
                            <label class="form-check-label" for="type-family">Family Rooms</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-group">
                        <label class="filter-label">Price Range</label>
                        <input type="range" class="form-range range-slider" min="50" max="500" step="50" id="priceRange">
                        <div class="range-values">
                            <span>$50</span>
                            <span>$500</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-group">
                        <label class="filter-label">Guests</label>
                        <select class="form-select">
                            <option value="">Any</option>
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3+ Guests</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-group">
                        <label class="filter-label">Amenities</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="amenity-wifi" checked>
                            <label class="form-check-label" for="amenity-wifi">Wi-Fi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="amenity-pool">
                            <label class="form-check-label" for="amenity-pool">Pool</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="amenity-spa">
                            <label class="form-check-label" for="amenity-spa">Spa</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button class="filter-btn">Apply Filters</button>
            </div>
        </div> -->
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="results-count">Showing 8 rooms</div>
            <div class="view-options">
                <button class="view-btn active"><i class="fas fa-th"></i> Grid</button>
                <!-- <button class="view-btn"><i class="fas fa-list"></i> List</button> -->
            </div>
        </div>
        
        <?php

        // WP Query for Accommodations
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'accommodation',
            'posts_per_page' => 4,  
            'paged'          => $paged
        );
        $accommodations = new WP_Query($args);
        ?>

        <div class="room-grid">
            <div class="row">
                <?php if ($accommodations->have_posts()) : ?>
                    <?php while ($accommodations->have_posts()) : $accommodations->the_post(); ?>
                        <?php
                        // Get meta values
                        $badge     = get_post_meta(get_the_ID(), '_room_status', true);
                        $price     = get_post_meta(get_the_ID(), '_accommodation_price', true);
                        $room_type = get_post_meta(get_the_ID(), 'room_type', true);
                        $room_size = get_post_meta(get_the_ID(), '_accommodation_size', true);
                        //$rating    = get_post_meta(get_the_ID(), 'rating', true);
                        $guests    = get_post_meta(get_the_ID(), '_accommodation_capacity', true);
                        $beds      = get_post_meta(get_the_ID(), '_accommodation_children', true);
                        $baths     = get_post_meta(get_the_ID(), 'baths', true);
                        ?>
                        
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="room-card">
                                <div class="room-img">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium', ['class' => 'img-fluid']); ?>
                                    <?php else : ?>
                                        <img src="https://via.placeholder.com/600x400" alt="<?php the_title(); ?>">
                                    <?php endif; ?>

                                    <?php if ($badge) : ?>
                                        <div class="room-badge"><?php echo esc_html($badge); ?></div>
                                    <?php endif; ?>

                                    <?php if ($price) : ?>
                                        <div class="room-price">$<?php echo esc_html($price); ?>/night</div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="room-details">
                                    <h4 class="room-title"><?php the_title(); ?></h4>
                                    
                                    <div class="room-meta">
                                        <?php if ($room_type) : ?>
                                            <span class="room-type"><?php echo esc_html($room_type); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($room_size) : ?>
                                            <span class="room-size"><?php echo esc_html($room_size); ?> m²</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                     
                                    <div class="room-features">
                                        <?php if ($guests) : ?>
                                            <span><i class="fas fa-user-friends"></i> <?php echo esc_html($guests); ?> Guests</span>
                                        <?php endif; ?>
                                        
                                        <?php if ($beds) : ?>
                                            <span><i class="fas fa-child"></i> <?php echo esc_html($beds); ?></span>
                                        <?php endif; ?>
                                        
                                        <?php if ($baths) : ?>
                                            <span><i class="fas fa-bath"></i> <?php echo esc_html($baths); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <p class="room-description"><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="btn-book">
                                        <i class="fas fa-calendar-check"></i> Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No accommodations available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <?php
            echo paginate_links(array(
                'total'     => $accommodations->max_num_pages,
                'prev_text' => __('Previous'),
                'next_text' => __('Next'),
            ));
            ?>
        </nav>
        </div>
     </div>
  <?php wp_reset_postdata(); ?>

    <?php 
    // Astra theme hook before footer
        if (function_exists('astra_footer_before')) {
            astra_footer_before();
        }
    ?>

    <?php 
    // Astra theme footer
        if (function_exists('astra_footer')) {
            astra_footer();
        }
    ?>
    <?php 
    // Astra theme hook after footer
    if (function_exists('astra_footer_after')) {
        astra_footer_after();
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple view toggle functionality
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.textContent.includes('List')) {
                    document.querySelectorAll('.room-card').forEach(card => {
                        card.classList.add('list-view');
                    });
                } else {
                    document.querySelectorAll('.room-card').forEach(card => {
                        card.classList.remove('list-view');
                    });
                }
            });
        });
        
        // Price range slider value display
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.addEventListener('input', function() {
                const rangeValues = this.parentElement.querySelector('.range-values');
                if (rangeValues) {
                    rangeValues.firstElementChild.textContent = '$' + this.value;
                }
            });
        }
        
        // Smooth scroll for the hero section indicator
        document.querySelector('.scroll-indicator').addEventListener('click', function() {
            window.scrollTo({
                top: document.querySelector('.header').offsetTop,
                behavior: 'smooth'
            });
        });
    </script>
    <?php wp_footer(); ?>
</body>
</html>