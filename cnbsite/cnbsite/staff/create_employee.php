
<?php 
session_start();
if ($_SESSION['role'] !== 'manager') {
    header("Location: staff_login.php");
    exit();
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employees - Chick-n-Byte</title>
    <link rel="icon" href="images/logo.svg" type="image/x-icon">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="home-page">
    <!-- HEADER -->
    <?php 
    include 'staff_scripts/staff_header.php'; 
    ?>

  <!-- MAIN CONTENT -->
  <div class="staff-section">
    <h1>Create Employee Accounts</h1>
    <p>Fill out the form below to create a new employee account.</p>

    <?php if (isset($_GET['error'])): ?>
      <div class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php elseif (isset($_GET['success'])): ?>
      <div class="success-message"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <form action="staff_scripts/create_employee_handler.php" method="POST">
      <div class="form-group">
        <label for="username">Employee Username:</label>
        <input type="text" id="username" name="Username" required>
      </div>
      <div class="form-group">
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="delivery_driver">Delivery Driver</option>
            <option value="kitchen_staff">Kitchen Staff</option>
            <option value="manager">Manager</option>
        </select>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
        <button type="submit">Create Account</button>
    </form>
  </div>

    <!-- Footer -->
    <?php include '../phpscripts/footer.php'; ?>

</body>
</html>