<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "commerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['edit_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category_name'];
    $product_price = $_POST['product_price'];
    $former_price = $_POST['former_price'];
    $product_discount = $_POST['product_discount'];
    $stock_quantity = $_POST['stock_quantity'];
    $product_description = $_POST['product_description'];
    $product_image = $_POST['product_image']; // Note: This should be handled with care for security reasons.

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE product_tb SET 
                            product_name = ?, 
                            category_name = ?, 
                            product_price = ?, 
                            former_price = ?, 
                            product_discount = ?, 
                            stock_quantity = ?, 
                            product_description = ?, 
                            product_image = ? 
                            WHERE product_id = ?");
    $stmt->bind_param("ssdddisss", $product_name, $category_name, $product_price, $former_price, $product_discount, $stock_quantity, $product_description, $product_image, $product_id);

    if ($stmt->execute()) {
        // Product details successfully updated
        echo "<p class='message success'>Product details updated.</p>";
    } else {
        // Error occurred during update
        echo "<p class='message error'>Error updating product details: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Retrieve product details from the database
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null; // Assuming product_id is passed as a GET parameter
if($product_id !== null){
    $result = $conn->query("SELECT * FROM products WHERE product_id = $product_id");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $product_name = $row["product_name"];
        $category_name = $row["category_name"];
        $product_price = $row["product_price"];
        $former_price = $row["former_price"];
        $product_discount = $row["product_discount"];
        $stock_quantity = $row["stock_quantity"];
        $product_description = $row["product_description"];
        $product_image = $row["product_image"];
    } else {
        echo "<p class='message error'>Product not found.</p>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        textarea {
            resize: none;
        }

        .btn-save {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .btn-save:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #28a745;
            color: #fff;
        }

        .error {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <form action="" method="post">
        <h1 class="mb-4">Edit Product</h1>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" class="form-control" value="<?php echo $product_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="category_name">Category Name:</label>
            <input type="text" id="category_name" name="category_name" class="form-control" value="<?php echo $category_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="product_price">Product Price:</label>
            <input type="number" step="0.01" id="product_price" name="product_price" class="form-control" value="<?php echo $product_price; ?>" required>
        </div>
        <div class="form-group">
            <label for="former_price">Former Price:</label>
            <input type="number" step="0.01" id="former_price" name="former_price" class="form-control" value="<?php echo $former_price; ?>" required>
        </div>
        <div class="form-group">
            <label for="product_discount">Product Discount:</label>
            <input type="number" step="0.01" id="product_discount" name="product_discount" class="form-control" value="<?php echo $product_discount; ?>" required>
        </div>
        <div class="form-group">
            <label for="stock_quantity">Stock Quantity:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="<?php echo $stock_quantity; ?>" required>
        </div>
        <div class="form-group">
            <label for="product_description">Product Description:</label>
            <textarea id="product_description" name="product_description" class="form-control" rows="4" required><?php echo $product_description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="product_image">Product Image URL:</label>
            <input type="text" id="product_image" name="product_image" class="form-control" value="<?php echo $product_image; ?>" required>
        </div>
        <button type="submit" name="edit_product" class="btn btn-save btn-block">Save Changes</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
