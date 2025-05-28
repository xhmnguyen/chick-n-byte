<?php
$config = include(__DIR__ . '/../config/db_config.php');

$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$db = $config['db'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
