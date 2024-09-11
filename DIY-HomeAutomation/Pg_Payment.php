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

// Retrieve cart items and total price
$sql = "SELECT products.id, products.name, products.price FROM cart INNER JOIN products ON cart.product_id = products.id WHERE cart.user_id = '$userId'";
$result = $conn->query($sql);

$cartItems = [];
$totalPrice = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $totalPrice += $row['price'];
    }
} else {
    echo "Your cart is empty.";
    exit();
}

// Simulate payment processing
$paymentSuccess = true;

if ($paymentSuccess) {
    // Insert order into orders table
    $sql = "INSERT INTO orders (user_id, total_price) VALUES ('$userId', '$totalPrice')";
    if ($conn->query($sql) === TRUE) {
        $orderId = $conn->insert_id;

        // Insert order details into order_items table
        foreach ($cartItems as $item) {
            $productId = $item['id'];
            $price = $item['price'];
            $sql = "INSERT INTO order_items (order_id, product_id, price) VALUES ('$orderId', '$productId', '$price')";
            $conn->query($sql);
        }

        // Clear the cart
        $sql = "DELETE FROM cart WHERE user_id = '$userId'";
        $conn->query($sql);

        echo "Payment successful! Your order has been placed.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Payment failed. Please try again.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Home Automation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Payment - Home Automation System</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="features.html">Features</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="ecommerce.html">Shop Routers</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">
                        <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Account'; ?>
                    </a>
                    <div class="dropdown-content">
                        <a href="edit_profile.php">Edit Profile</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Payment Status</h2>
        <p><?php echo $paymentSuccess ? "Your order has been placed successfully." : "Payment failed. Please try again."; ?></p>
    </main>
    <footer>
        <p>&copy; 2024 Home Automation System</p>
    </footer>
</body>
</html>
