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
    <link rel="stylesheet" href="nav.css">
      <link rel="stylesheet" href="fontawesome\css\fontawesome.min.css">

    <link rel="stylesheet" href="fontawesome/js/logo.js">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

<!-- ... (previous HTML code) ... -->
    <nav class="navbar mx-0 w-100">
        <div class="container">
            <div class="logo">
                <a href="homepage.php"><img src="../user/nanan.png" alt="" srcset=""></a>
            </div>
            <ul class="nav-links">
                <li><a href="homepage.php">Home</a></li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    $total_items = get_cart_item_count($_SESSION['user_id']);
                    echo '<li><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart';
                    if ($total_items > 0) {
                        echo "<span class='badge badge-primary'>($total_items)</span>";
                    }
                    echo '</a></li>';
                } else {
                    echo '<li><a href="cart.php"><i class="fa fa-shopping-cart"></i>Cart</a></li>';
                }
                ?>
                <li><a href="profile.php">Profile</a></li>
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
