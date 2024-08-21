<?php
session_start();

// Database configuration
include ("../db.php");

// Fetch all promotions
$promotions_sql = "SELECT * FROM promotions";
$promotions_result = mysqli_query($conn, $promotions_sql);

if (!$promotions_result) {
  die("Error fetching promotions: " . mysqli_error($conn));
}

// Fetch featured menu items
$featured_items_query = "
    SELECT name, description, image 
    FROM menu_item 
    WHERE is_featured = 1";
$featured_items_result = mysqli_query($conn, $featured_items_query);

if (!$featured_items_result) {
  die("Error fetching featured items: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/footer.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/carousel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../Styles/index.css" />
  <title>The Gallery Café</title>
</head>

<body>
  <header>
    <!-- header section -->
    <?php include('../components/header.php') ?>

    <!-- Hero Section -->
    <section class="hero">
      <div class="text-container">
        <div class="boder">
          <h1>The Gallery Café</h1>
          <img src="../Assets/icons/logo.png" alt="">
          <p>Where art meets food. Enjoy a delightful experience.</p>
          <a href="./reservation.php" class="btn">Make a Reservation</a>
        </div>
      </div>
    </section>
  </header>

  <!-- carousel-section -->
  <section class="carouselContainer">
    <div id="controls" class="controls">
      <button id="left" style="padding: 10px; font-size: 40px;">
        < </button>
          <button id="right" style="padding: 10px; font-size: 40px;">
            >
          </button>
      </div>
      <div id="carousel">

      </div>


  </section>

  <!-- Introduction/About Section -->
  <section class="feature-about">
    <div class="feature-box">
      <div class="feature-icon">
        <img src="../Assets/icons/healthcare.png" alt="Icon 1" />
      </div>

      <h3>TOUCHING HEARTS SINCE 1998</h3>
      <p>
        Satisfying the taste buds of sri lankan customers since 1998 have grown into a huge variety of cuisines to
        extend our loyalty back towards our customers.
      </p>

    </div>
    <div class="feature-box">
      <div class="feature-icon">
        <img src="../Assets/icons/dinner-date.png" alt="Icon 2" />
      </div>
      <h3>EXCEPTIONAL DINING EXPERIENCE</h3>
      <p>
        At The Gallery Café, the satisfaction of our guests is our highest priority. We ensure a memorable dining
        experience with top-notch service, exquisite cuisine, and a comfortable atmosphere, all while adhering to the
        highest standards of hygiene and safety.
      </p>

    </div>
    <div class="feature-box">
      <div class="feature-icon">
        <img src="../Assets/icons/dining.png" alt="Icon 3" />
      </div>
      <h3>Café CLEANSTAY</h3>
      <p>
        At The Gallery Café, we blend the love for art and food. Enjoy our
        carefully curated menu and the artistic ambiance. Our café is a
        perfect place for art enthusiasts and food lovers to relax and enjoy.
      </p>
    </div>
  </section>


  <!-- Promotions and Events Section -->
  <section class="promotions-events">
    <h2>Special Promotions & Events</h2>
    <div class="promotions-events-container">
      <?php while ($promotion = mysqli_fetch_assoc($promotions_result)) { ?>
        <div class="event">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($promotion['image']); ?>"
            alt="<?php echo htmlspecialchars($promotion['name']); ?>" />
          <div class="event-details">
            <h3><?php echo htmlspecialchars($promotion['name']); ?></h3>
            <p><?php echo htmlspecialchars($promotion['description']); ?></p>
            <button class="btn">Learn More</button>
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Featured Menu Items Section -->
  <section class="featured-menu">
    <h2>Featured Menu Items</h2>
    <div class="menu-grid">

      <?php while ($item = mysqli_fetch_assoc($featured_items_result)): ?>

        <div class="menu-item">
          <?php if (!empty($item['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>"
              alt="<?php echo htmlspecialchars($item['name']); ?>" />
          <?php endif; ?>

          <h3><?php echo htmlspecialchars($item['name']); ?></h3>
          <p><?php echo htmlspecialchars($item['description']); ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

  <!-- Gallery Section -->
  <section class="gallery">
    <h2>Our Gallery</h2>
    <div class="gallery-grid">
      <img src="../Assets/coffee-shop4.jpg" alt="Gallery Image 1" />
      <img src="../Assets/coffee-shop-dark.jpg" alt="Gallery Image 2" />
      <img src="../Assets/coffee.jpg" alt="Gallery Image 3" />
      <img src="../Assets/coffee-shop2.jpg" alt="Gallery Image 4" />
    </div>
    <div class="load-more">
      <span class="arrow">▼</span>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial-grid">
      <div class="testimonial-item">
        <p>
          "Amazing atmosphere and delicious food. A perfect place to unwind
          and enjoy art!"
        </p>
        <h3>- Shubman Gill</h3>
      </div>
      <div class="testimonial-item">
        <p>
          "The Gallery Café offers a unique dining experience with its
          artistic décor and exquisite dishes."
        </p>
        <h3>- Dhananjaya De silva </h3>
      </div>
      <div class="testimonial-item">
        <p>
          "I love the blend of art and food here. The sushi platter is my
          favorite."
        </p>
        <h3>- Smrithi Mandhana</h3>
      </div>
    </div>
  </section>

  <!-- Newsletter Signup Section -->
  <section class="newsletter">
    <h2>Stay Updated</h2>
    <p>
      Subscribe to our newsletter to receive the latest news and special
      offers.
    </p>
    <form action="#">
      <input type="email" placeholder="Enter your email" required />
      <button type="submit">Subscribe</button>
    </form>
  </section>

  <!-- footer-section -->
<?php include('../components/footer.php'); ?>


  <script src="../Scripts/index.js"></script>
</body>

</html>