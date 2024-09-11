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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET username = '$newUsername', password = '$newPassword' WHERE id = '$userId'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $newUsername;
        echo "Profile updated successfully";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
} else {
    $sql = "SELECT username FROM users WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Home Automation System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Profile - Home Automation System</h1>
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
        <h2>Edit Profile</h2>
        <form method="POST" action="edit_profile.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Update Profile</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Home Automation System</p>
    </footer>
</body>
</html>
