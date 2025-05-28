<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header -->
    <?php
    include 'phpscripts/header.php';
    ?>

    <!-- About Us Section -->
    <div class="about-section">
        <div class="about-container">
            <h1>About Us</h1>
            <p>Welcome to Chick-N-Byte, where our mission is to serve delicious, high-quality chicken sandwiches and meals that bring joy 
                to every customer. Founded in 1967 by Truett Cathy, Chick-N-Byte has grown to become one of the largest and
                most beloved fast-food chains in the United States. Our commitment to exceptional customer service, fresh ingredients,
                and a welcoming environment has made us a favorite among families, friends, and communities nationwide.</p>
            <p>At Chick-N-Byte, we pride ourselves on delivering high-quality meals made from the finest ingredients. From our
                signature chicken sandwiches to our famous waffle fries, everything we serve is crafted with care and passion. We
                are committed to providing an exceptional dining experience for our customers and giving back to the communities we
                serve.</p>
        </div>


    <!-- Our Values Section -->
    <div class="values-section">
        <h1>Our Values</h1>
         <div class="values-container">
            <div class="values-item">
                <img src="images/nuggets.png" alt="Quality Ingredients">
                <div class="values-text">
                    <h2>Quality Ingredients</h2>
                    <p>We believe in serving only the best, using high-quality, fresh ingredients in every meal we make.</p>
                </div>
            </div>
         </div>
        
         <div class="values-container">
            <div class="values-item">
                <img src="images/community.jpg" alt="Community">
                <div class="values-text">
                    <h2>Community</h2>
                    <p>We are deeply committed to giving back to the communities we serve and fostering positive relationships.</p>
                </div>
            </div>
         </div>

         <div class="values-container">
            <div class="values-item">
                <img src="images/service.jpg" alt="Excellent Service">
                <div class="values-text">
                    <h2>Excellent Service</h2>
                    <p>Our customers are our top priority. We strive to provide fast, friendly service with every order.</p>
                </div>
            </div>
         </div>
        </div>
    </div> 

    <!-- Footer -->
    <?php
    include 'phpscripts/footer.php';
    ?>

</body>
</html>
