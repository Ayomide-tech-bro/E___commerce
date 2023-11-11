<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
</head>
<body>
    <?php 
    session_start();
    $user = $_SESSION['user_type'];
    function get_cart_item_count($user_id) {
    // Connect to your database (replace with your actual connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "commerce_db";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you have a table named cart_tb with a column named quantity
    $sql = "SELECT SUM(quantity) AS total_items FROM cart_tb WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_items'];
    } else {
        return 0;
    }

    $conn->close();
}
?>

    <nav class="navbar mx-0 w-100">
        <div class="container">
            <div class="logo">E-commerce</div>

            <!-- Search Bar -->
            <div class="search-bar">
                <form action="search_results.php" method="get">
                    <input type="text" name="query" placeholder="Search products...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <li><a href="products.php">Products</a></li>

                <!-- Cart with Product Count -->
                <?php
                if (isset($_SESSION['user_id'])) {
                    $total_items = get_cart_item_count($_SESSION['user_id']);
                    echo '<li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart';
                    if ($total_items > 0) {
                        echo "<span class='badge badge-primary'>$total_items</span>";
                    }
                    echo '</a></li>';
                } else {
                    echo '<li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart</a></li>';
                }
                ?>

                <li><a href="profile.php">Profile</a></li>
                <li><a href="checkout.php">Checkout</a></li>
                <?php 
                if ($user == 'admin') echo'<li><a href="admin_board.php">Admin</a></li>';
                ?>
            </ul>
            <div class="user-actions">
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<a href="../user/login.php">Logout</a>';
                } 
                // else {
                //     echo '<a href="../user/login.php">Login</a>';
                // }
                ?>
            </div>
        </div>
    </nav>

    <!-- Rest of your HTML content goes here -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
