<?php
session_start();
?>

<div class="header">
    <img src="../images/logo.png" alt="Logo">

    <div class = "buttons">
        <div class="sign-in">
                <a href="staff_dashboard.php">
                    <button>Dashboard</button>
                </a>     
        </div>

        <div class="sign-in">
                <form action="staff_scripts/staff_logout.php" method="POST">
                    <button type="submit">Sign Out</button>
                </form>
        </div>
    </div>
       
     
</div>
