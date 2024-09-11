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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Home Automation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Cart - Home Automation System</h1>
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
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo '$' . number_format($item['price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td>Total</td>
                    <td><?php echo '$' . number_format($totalPrice, 2); ?></td>
                </tr>
            </tbody>
        </table>
        <form method="POST" action="Pg_Payment.php">
            <button type="submit">Purchase</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Home Automation System</p>
    </footer>
</body>
</html>
