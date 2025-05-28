<?php
session_start();
require_once 'phpscripts/connect.php';

// Fetch menu items from the database
$query = "SELECT * FROM menu_items";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Chick-fil-A</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header -->
    <?php
    include 'phpscripts/header.php';
    ?>

    <!-- Display each menu item from database - creates a bordered container with all the information !-->
    <div class="content">
        <h1>Our Menu</h1>
        <div class="menu-items">
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="menu-item">
                    <img src="<?php echo $row['image_url']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
                    <p><strong>Calories:</strong> <?php echo $row['calories']; ?> kcal</p>
                    <p><strong>Ingredients:</strong> <?php echo htmlspecialchars($row['ingredients']); ?></p>
                        <form action="phpscripts/add_to_cart.php" method="POST">
                            <input type="hidden" name="menu_item_id" value="<?php echo $row['menu_item_id']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include 'phpscripts/footer.php';
    ?>

</body>
</html>