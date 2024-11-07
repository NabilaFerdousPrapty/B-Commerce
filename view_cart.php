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
<style>
    .logo {
        width: 50px;
        height: 50px;
    }

    a {
        text-decoration: none;
        color: white;
    }
</style>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-info bg-gradient shadow-sm">
        <div class="container-fluid">
            <a href="/" class="">
                <img src="./images/logo.png" alt="Logo" class="logo " />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                                // Get total cart items count
                                $cart_query = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE user_id = $user_id";
                                $cart_result = mysqli_query($con, $cart_query);
                                $cart_row = mysqli_fetch_assoc($cart_result);
                                echo $cart_row['total_quantity'] ? $cart_row['total_quantity'] : 0;
                                ?>
                            </sup>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Content -->
    <div class="container mt-5 min-vh-100">
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

        <!-- Checkout Button -->
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button>
    </div>

    <!-- Modal for Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="checkout.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="credit_card">Credit Card</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-info text-white text-center p-3 mt-5">
        <p>&copy; 2024 My store. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>