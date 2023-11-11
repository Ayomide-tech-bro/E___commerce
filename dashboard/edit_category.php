<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "commerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['edit_category'])) {
    $oldCategory = $_POST['old_category'];
    $newCategory = $_POST['new_category'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE category_tb SET category_name = ? WHERE category_name = ?");
    $stmt->bind_param("ss", $newCategory, $oldCategory);

    if ($stmt->execute()) {
        // Category successfully updated
        echo "<p class='message success'>Category '$oldCategory' has been updated to '$newCategory'.</p>";
    } else {
        // Error occurred during update
        echo "<p class='message error'>Error updating category: " . $conn->error . "</p>";
    }

    $stmt->close();
}

$categories = [];
$result = $conn->query("SELECT category_name FROM category_tb");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row["category_name"];
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Category</title>
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
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    select,
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
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
    <?php
    require_once('nav.php')
    ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h1 class="text-center">Edit Category</h1>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="old_category">Select Category to Edit:</label>
                    <select id="old_category" name="old_category" class="form-control">
                        <?php
                        foreach($categories as $category) {
                            echo "<option value='$category'>$category</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="new_category">New Category Name:</label>
                    <input type="text" id="new_category" name="new_category" class="form-control" required>
                </div>
                <button type="submit" name="edit_category" class="btn btn-primary btn-block">Edit Category</button>
            </form>
        </div>
    </div>

    <?php
    // PHP code (database connection, form handling, etc.) goes here
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
