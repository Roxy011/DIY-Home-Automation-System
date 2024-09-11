<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
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

$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['productId'];
$userId = $_SESSION['user_id'];

// Check if the user exists
$userCheckSql = "SELECT * FROM users WHERE id = '$userId'";
$userCheckResult = $conn->query($userCheckSql);
if ($userCheckResult->num_rows == 0) {
    die("User does not exist.");
}

// Check if the product exists
$productCheckSql = "SELECT * FROM products WHERE id = '$productId'";
$productCheckResult = $conn->query($productCheckSql);
if ($productCheckResult->num_rows == 0) {
    die("Product does not exist.");
}

$sql = "INSERT INTO cart (user_id, product_id) VALUES ('$userId', '$productId')";

if ($conn->query($sql) === TRUE) {
    echo "Product added to cart";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
