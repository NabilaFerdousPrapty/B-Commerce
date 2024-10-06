<?php
// Start the session
session_start();

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
include('./includes/connect.php');

// Get the user's cart items
$user_id = $_SESSION['user_id'];
$query = "SELECT products.product_id, products.product_title, products.product_price, cart.quantity 
          FROM cart 
          JOIN products ON cart.product_id = products.product_id 
          WHERE cart.user_id = $user_id";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Your Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view_cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <sup>
                            <?php 
                            $cart_query = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = $user_id";
                            $cart_result = mysqli_query($con, $cart_query);
                            $cart_row = mysqli_fetch_assoc($cart_result);
                            echo $cart_row['total_quantity'] ? $cart_row['total_quantity'] : 0;
                            ?>
                        </sup>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Your Cart</h2>
    <?php
    // Check if the cart is empty
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>";
        echo "<tbody>";

        $total_price = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_price = $row['product_price'];
            $quantity = $row['quantity'];
            $total = $product_price * $quantity;
            $total_price += $total;

            echo "<tr>";
            echo "<td>$product_title</td>";
            echo "<td>$product_price/-</td>";
            echo "<td>$quantity</td>";
            echo "<td>$total/-</td>";
            echo "<td>
                    <form action='remove_cart.php' method='POST'>
                        <input type='hidden' name='product_id' value='$product_id'>
                        <button type='submit' class='btn btn-danger btn-sm'>Remove</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "<p class='fw-bold'>Total Price: $total_price/-</p>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center p-3 mt-5">
    <p>&copy; 2024 Your Shop. All rights reserved.</p>
</footer>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
