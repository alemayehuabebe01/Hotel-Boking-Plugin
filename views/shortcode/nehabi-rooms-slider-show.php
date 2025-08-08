<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Villa Slider</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <!-- Swiper CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
  />
  <style>
    /* Your existing styles with minor tweaks */
    

    /* Remove .room-grid grid styles, replaced by Swiper */
    .swiper {
      
      margin: auto;
      padding-bottom: 40px; /* space for arrows */
    }

    .room-card {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      height: 100%;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
      width: 100%;
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
      cursor: pointer;
    }

    .btn:hover {
      background-color: #059669;
    }

    .details-link {
      font-size: 0.9rem;
      color: #4b5563;
      text-decoration: none;
      border-bottom: 1px dotted #4b5563;
      cursor: pointer;
    }

    .details-link:hover {
      color: #111827;
      border-color: #111827;
    }

    /* Swiper navigation buttons */
    .swiper-button-next,
    .swiper-button-prev {
      color: #10b981;
      top: auto;
      bottom: 0;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
      transition: background 0.3s;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
      background-color: #059669;
      color: white;
    }

    /* Responsive slides per view - controlled in JS */
  </style>
</head>
<body>

<!-- Swiper -->
<div class="swiper">
  <div class="swiper-wrapper">
    <!-- Slide 1 -->
     <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1015/400/250" alt="Villa Amalfi Sunlight" />
        </div>
        <div class="room-info">
          <h3>Villa Amalfi Sunlight</h3>
          <p class="room-description">
            Relax in style on the Amalfi Coast with breathtaking ocean views, outdoor pools, and pure elegance.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 6</div>
            <div><i class="fas fa-ruler-combined"></i> 150m²</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Sea view, Terrace, Espresso machine, <span class="highlight">Infinity Pool</span>, Free WiFi <br />
            <strong>View:</strong> Oceanfront <br />
            <strong>Bed Type:</strong> 2 King beds, 1 Sofa <br />
            <strong>Categories:</strong> Amalfi
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$780.00</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1015/400/250" alt="Villa Amalfi Sunlight" />
        </div>
        <div class="room-info">
          <h3>Villa Amalfi Sunlight</h3>
          <p class="room-description">
            Relax in style on the Amalfi Coast with breathtaking ocean views, outdoor pools, and pure elegance.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 6</div>
            <div><i class="fas fa-ruler-combined"></i> 150m²</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Sea view, Terrace, Espresso machine, <span class="highlight">Infinity Pool</span>, Free WiFi <br />
            <strong>View:</strong> Oceanfront <br />
            <strong>Bed Type:</strong> 2 King beds, 1 Sofa <br />
            <strong>Categories:</strong> Amalfi
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$780.00</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1015/400/250" alt="Villa Amalfi Sunlight" />
        </div>
        <div class="room-info">
          <h3>Villa Amalfi Sunlight</h3>
          <p class="room-description">
            Relax in style on the Amalfi Coast with breathtaking ocean views, outdoor pools, and pure elegance.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 6</div>
            <div><i class="fas fa-ruler-combined"></i> 150m²</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Sea view, Terrace, Espresso machine, <span class="highlight">Infinity Pool</span>, Free WiFi <br />
            <strong>View:</strong> Oceanfront <br />
            <strong>Bed Type:</strong> 2 King beds, 1 Sofa <br />
            <strong>Categories:</strong> Amalfi
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$780.00</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1016/400/250" alt="Villa Toscana Retreat" />
        </div>
        <div class="room-info">
          <h3>Villa Toscana Retreat</h3>
          <p class="room-description">
            Enjoy peace, vineyards, and rustic luxury in the heart of Tuscany. Private chef included!
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 10</div>
            <div><i class="fas fa-ruler-combined"></i> 250m²</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Vineyard view, Fire pit, Sauna, <span class="highlight">Chef Service</span>, Wine cellar <br />
            <strong>View:</strong> Hills, Olive groves <br />
            <strong>Bed Type:</strong> 4 King beds <br />
            <strong>Categories:</strong> Tuscany
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$1,200.00</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1019/400/250" alt="Villa Riviera Bliss" />
        </div>
        <div class="room-info">
          <h3>Villa Riviera Bliss</h3>
          <p class="room-description">
            Chic modern villa with private beach access, rooftop terrace, and stunning sunset views.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 5</div>
            <div><i class="fas fa-ruler-combined"></i> 120m²</div>
            <div><i class="fas fa-user"></i> 5</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Private beach, Rooftop bar, <span class="highlight">Smart Home</span>, WiFi, Air conditioning <br />
            <strong>View:</strong> Riviera Coastline <br />
            <strong>Bed Type:</strong> 2 Queen beds, 1 Sofa <br />
            <strong>Categories:</strong> French Riviera
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$499.99</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
          <img src="https://picsum.photos/id/1019/400/250" alt="Villa Riviera Bliss" />
        </div>
        <div class="room-info">
          <h3>Villa Riviera Bliss</h3>
          <p class="room-description">
            Chic modern villa with private beach access, rooftop terrace, and stunning sunset views.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 5</div>
            <div><i class="fas fa-ruler-combined"></i> 120m²</div>
            <div><i class="fas fa-user"></i> 5</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Private beach, Rooftop bar, <span class="highlight">Smart Home</span>, WiFi, Air conditioning <br />
            <strong>View:</strong> Riviera Coastline <br />
            <strong>Bed Type:</strong> 2 Queen beds, 1 Sofa <br />
            <strong>Categories:</strong> French Riviera
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$499.99</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <div class="swiper-slide">
      <div class="room-card">
        <div class="room-img-wrapper">
      <img src="https://picsum.photos/id/1019/400/250" alt="Villa Riviera Bliss" />
        </div>
        <div class="room-info">
          <h3>Villa Riviera Bliss</h3>
          <p class="room-description">
            Chic modern villa with private beach access, rooftop terrace, and stunning sunset views.
          </p>
          <div class="room-meta-grid">
            <div><i class="fas fa-users"></i> 5</div>
            <div><i class="fas fa-ruler-combined"></i> 120m²</div>
            <div><i class="fas fa-user"></i> 5</div>
          </div>
          <p class="room-amenities">
            <strong>Amenities:</strong> Private beach, Rooftop bar, <span class="highlight">Smart Home</span>, WiFi, Air conditioning <br />
            <strong>View:</strong> Riviera Coastline <br />
            <strong>Bed Type:</strong> 2 Queen beds, 1 Sofa <br />
            <strong>Categories:</strong> French Riviera
          </p>
          <div class="price-line">
            Prices start at: <strong class="price">$499.99</strong> for 3 nights (+taxes and fees)
          </div>
          <div class="room-buttons">
            <a href="#" class="btn">BOOK</a>
            <a href="#" class="details-link">View Details</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Arrows -->
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper(".swiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 4,
      },
    },
  });
</script>
</body>
</html>
