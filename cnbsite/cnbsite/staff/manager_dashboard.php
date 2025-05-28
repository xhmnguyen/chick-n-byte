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
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<body class="home-page">
  <!-- HEADER -->
    <?php 
    include 'staff_scripts/staff_header.php'; 
    ?>

  <!-- MAIN CONTENT -->
  <div class="staff-section">
    <h1>Manager Dashboard</h1>
    <p>Manage operations efficiently with the tools below.</p>

    <div class="staff-cards">
      <div class="staff-card">
        <h2>Create Employee Accounts</h2>
        <p>Create new employee accounts and manage their details.</p>
        <a href="create_employee.php"><button>Create New</button></a>
      </div>
      <div class="staff-card">
        <h2>View All Orders</h2>
        <p>View and manage all customer orders efficiently.</p>
        <a href="view_orders.php"><button>View All</button></a>
      </div>
      <div class="staff-card">
        <h2>Assign Deliveries</h2>
        <p>Assign deliveries to drivers and track their progress.</p>
        <a href="assign_orders.php"><button>Assign Orders</button></a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include '../phpscripts/footer.php'; ?>
    
</body>
</html>