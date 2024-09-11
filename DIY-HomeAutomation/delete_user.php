<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_automation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = '$user_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error deleting user: " . $conn->error;
}

$conn->close();
?>
