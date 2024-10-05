<?php
session_start();
include('./includes/connect.php'); // Database connection
include('admin_area/functions/common_function.php'); // Common functions

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

// Fetch products recently added to the cart from session
$cart_products = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Success message
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Clear success message after displaying
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">Ecommerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Recently Added to Cart</h2>
        <div class="row">
            <?php if (empty($cart_products)): ?>
                <div class="col text-center">
                    <p>No products added to cart yet.</p>
                </div>
            <?php else: ?>
                <?php foreach ($cart_products as $product_id): ?>
                    <?php
                    // Fetch product details from the database
                    $product_query = "SELECT * FROM products WHERE product_id = '$product_id'";
                    $product_result = mysqli_query($con, $product_query);

                    // Check if the product exists
                    if ($product_result && mysqli_num_rows($product_result) > 0) {
                        $product = mysqli_fetch_assoc($product_result);
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="./images/<?php echo isset($product['product_image1']) ? htmlspecialchars($product['product_image1']) : 'placeholder.jpg'; ?>" class="card-img-top" alt="<?php echo isset($product['product_title']) ? htmlspecialchars($product['product_title']) : 'Product Image'; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo isset($product['product_title']) ? htmlspecialchars($product['product_title']) : 'No Title'; ?></h5>
                                <p class="card-text"><?php echo isset($product['product_description']) ? htmlspecialchars(substr($product['product_description'], 0, 100)) . '...' : 'No Description'; ?></p>
                                <p><strong>Price:</strong> <?php echo isset($product['product_price']) ? htmlspecialchars($product['product_price']) : '0'; ?>/-</p>
                                <a href="product_details.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                        echo '<div class="col text-center"><p>Product not found for ID: ' . htmlspecialchars($product_id) . '</p></div>';
                    }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Success Modal -->
    <?php if ($success_message): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
                <div class="modal-footer">
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Show success modal on load
        window.onload = function() {
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        }
    </script>
    <?php endif; ?>

    <footer class="bg-info text-center p-3 mt-4">
        <p>All rights reserved © 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
