<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <meta name="description" content="Landing page.">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header -->
    <?php
    include 'phpscripts/header.php';
    ?>

<!-- HERO -->
<div class="hero">
    <div class="hero-text">
      <h1>Welcome to Chick-n-Byte!</h1>
      <p class="hero-subtext">Delicious food. Friendly service. <br> Order delivery or pick-up now.</p>
      <a href="menu.html"><button class="viewmenu">Order Now!</button></a>
    </div>
    <img src="images/sandwichscreen.jpg" alt="Main Image">
  </div>
  

  <!-- PROMO SECTION -->
   <div class="promo-section">
    <div class="promo-content">
        <div class="promo-image">
            <img src="images/spicy-sandwich2.jpg" alt="Spicy Chicken Sandwich">
        </div>
        <div class="promo-text">
            <h2>Try our newest menu item!</h2>
            <p>Meet your new favorite: the Spicy Chicken Sandwich. Bold flavor, crispy perfection, and just the right amount of heat.</p>
            <a href="order.html"><button class="order-now">Order Now</button></a>
        </div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="featured">
    <h2>Featured Bytes</h2>
    <h3>Try our most loved menu items!</h3>
    <div class="featured-items">
      <div class="featured-card">
        <p>Classic Chicken Sandwich</p>
        <img src="images/sandwich.jpg" alt="Chicken Sandwich">
      </div>
      <div class="featured-card">
        <p>Chicken Strips</p>
        <img src="images/strips.png" alt="Chicken Strips">
      </div>
      <div class="featured-card">
        <p>Waffle Fries</p>
        <img src="images/fries.jpg" alt="Waffle Fries">
      </div>
    </div>
  </div>

    <!-- Footer -->
    <?php
    include 'phpscripts/footer.php';
    ?>

</body>
</html>