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

$userId = $_SESSION['user_id'];

// Remove all items from the user's cart
$sql = "DELETE FROM cart WHERE user_id = '$userId'";

if ($conn->query($sql) === TRUE) {
    echo "Purchase successful! Your cart has been cleared.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase - Home Automation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Home Automation System</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="features.html">Features</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="ecommerce.html">Shop Routers</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Purchase Confirmation</h2>
        <p>Thank you for your purchase! Your order has been processed.</p>
    </main>
    <footer>
        <p>&copy; 2024 Home Automation System</p>
    </footer>
</body>
</html>
