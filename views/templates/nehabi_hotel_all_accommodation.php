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
        
        /* Container override for Astra compatibility */
        .ast-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }
        
        .hero-content {
            max-width: 800px;
            padding: 30px;
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 30px;
            font-weight: 300;
            line-height: 1.6;
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
        
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }
        
        .main-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .subtitle {
            color: var(--light-text);
            max-width: 600px;
            margin: 0 auto;
            font-size: 1.1rem;
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
            font-size: 1.4rem;
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
                padding: 0 15px;
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
    </style>
</head>
<body>
    <!-- Hero Section - Full Width -->
    <section class="hero-section">
        <div class="ast-container">
            <div class="hero-content">
                <h1 class="hero-title">Experience Unforgettable Luxury</h1>
                <p class="hero-subtitle">Discover our exclusive collection of premium accommodations, designed for those who appreciate the finer things in life.</p>
                
                <div class="hero-search">
                    <h3 class="search-title">Find Your Perfect Stay</h3>
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
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <div class="ast-container">
        <!-- WordPress Integration Help Section -->
        <div class="wp-integration">
            <h3>WordPress Integration</h3>
            <p>To integrate this with your WordPress site using the Astra theme, place this code in your template file between <code>get_header()</code> and <code>get_footer()</code> calls.</p>
            <p>Replace the static room data with a WordPress loop that queries your accommodation CPT.</p>
            
            <div class="code-snippet">
                // Example WordPress loop for accommodation CPT<br>
                &lt;?php<br>
                $args = array(<br>
                &nbsp;&nbsp;&nbsp;&nbsp;'post_type' =&gt; 'accommodation',<br>
                &nbsp;&nbsp;&nbsp;&nbsp;'posts_per_page' =&gt; 8<br>
                );<br>
                $accommodations = new WP_Query($args);<br>
                <br>
                if ($accommodations-&gt;have_posts()) :<br>
                &nbsp;&nbsp;&nbsp;&nbsp;while ($accommodations-&gt;have_posts()) : $accommodations-&gt;the_post();<br>
                ?&gt;<br>
                <br>
                &lt;!-- Room card template --&gt;<br>
                <br>
                &lt;?php<br>
                &nbsp;&nbsp;&nbsp;&nbsp;endwhile;<br>
                &nbsp;&nbsp;&nbsp;&nbsp;wp_reset_postdata();<br>
                endif;<br>
                ?&gt;
            </div>
        </div>

        <header class="header">
            <h1 class="main-title">Luxury Accommodations</h1>
            <p class="subtitle">Discover our exquisite collection of premium rooms and suites for your perfect stay</p>
        </header>
        
        <div class="filter-section">
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
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="results-count">Showing 8 accommodations</div>
            <div class="view-options">
                <button class="view-btn active"><i class="fas fa-th"></i> Grid</button>
                <button class="view-btn"><i class="fas fa-list"></i> List</button>
            </div>
        </div>
        
        <div class="room-grid">
            <div class="row">
                <!-- Room 1 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Luxury Suite">
                            <div class="room-badge">Popular</div>
                            <div class="room-price">$199/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Luxury Suite</h3>
                            <div class="room-meta">
                                <span class="room-type">Suite</span>
                                <span class="room-size">45 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.5)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 King Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 1 Bath</span>
                            </div>
                            <p class="room-description">Spacious suite with panoramic views, premium amenities, and a luxurious bathroom with jacuzzi.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 2 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Deluxe Room">
                            <div class="room-price">$149/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Deluxe Room</h3>
                            <div class="room-meta">
                                <span class="room-type">Standard</span>
                                <span class="room-size">32 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(4.0)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 Queen Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 1 Bath</span>
                            </div>
                            <p class="room-description">Comfortable and elegantly designed room with modern amenities and a relaxing atmosphere.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 3 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Family Room">
                            <div class="room-badge">Family</div>
                            <div class="room-price">$249/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Family Room</h3>
                            <div class="room-meta">
                                <span class="room-type">Family</span>
                                <span class="room-size">60 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(4.8)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 4 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 2 Queen Beds</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 2 Baths</span>
                            </div>
                            <p class="room-description">Perfect for families, featuring separate sleeping areas and extra space for relaxation.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 4 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Executive Suite">
                            <div class="room-badge">Business</div>
                            <div class="room-price">$299/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Executive Suite</h3>
                            <div class="room-meta">
                                <span class="room-type">Suite</span>
                                <span class="room-size">55 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.6)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 King Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 2 Baths</span>
                            </div>
                            <p class="room-description">Luxurious suite with separate living area, work space, and premium executive amenities.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 5 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Studio Apartment">
                            <div class="room-price">$179/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Studio Apartment</h3>
                            <div class="room-meta">
                                <span class="room-type">Studio</span>
                                <span class="room-size">40 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(4.2)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 Queen Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 1 Bath</span>
                            </div>
                            <p class="room-description">Compact and efficient space with kitchenette, perfect for extended stays.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 6 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Presidential Suite">
                            <div class="room-badge">Luxury</div>
                            <div class="room-price">$499/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Presidential Suite</h3>
                            <div class="room-meta">
                                <span class="room-type">Suite</span>
                                <span class="room-size">85 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>(4.9)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 3 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 King Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 2 Baths</span>
                            </div>
                            <p class="room-description">Our most luxurious offering with expansive space, premium furnishings, and exceptional service.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 7 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Ocean View Room">
                            <div class="room-badge">View</div>
                            <div class="room-price">$229/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Ocean View Room</h3>
                            <div class="room-meta">
                                <span class="room-type">Deluxe</span>
                                <span class="room-size">38 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(4.7)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 King Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 1 Bath</span>
                            </div>
                            <p class="room-description">Beautiful room with stunning ocean views, private balcony, and premium amenities.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
                
                <!-- Room 8 -->
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="https://images.unsplash.com/photo-1444201983204-c43cbd584d93?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Garden Suite">
                            <div class="room-price">$169/night</div>
                        </div>
                        <div class="room-details">
                            <h3 class="room-title">Garden Suite</h3>
                            <div class="room-meta">
                                <span class="room-type">Suite</span>
                                <span class="room-size">42 m²</span>
                            </div>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(4.1)</span>
                            </div>
                            <div class="room-features">
                                <span class="room-feature"><i class="fas fa-user-friends"></i> 2 Guests</span>
                                <span class="room-feature"><i class="fas fa-bed"></i> 1 Queen Bed</span>
                                <span class="room-feature"><i class="fas fa-bath"></i> 1 Bath</span>
                            </div>
                            <p class="room-description">Charming suite with direct access to the garden, perfect for nature lovers.</p>
                            <a href="#" class="btn-book">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>

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
</body>

</html>