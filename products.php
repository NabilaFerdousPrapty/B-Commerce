<?php
// Start the session
session_start();

// Include the database connection file
include('./includes/connect.php');

// Include common functions
include('admin_area/functions/common_function.php');

// Initialize a variable for the toast message
$toastMessage = "";

// Check if a product ID is passed in the URL
if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];  // Ensure it's an integer for security

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $product_price = $row['product_price'];
    } else {
        $toastMessage = "Product not found."; // Set the toast message
    }
} else {
    $toastMessage = "No product selected."; // Set the toast message
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product_title ?? 'Product Details'); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom Styling */
        .product-img {
            max-width: 100%;
            height: auto;
        }

        .product-images {
            display: flex;
            gap: 10px;
        }

        .product-images img {
            max-width: 100px;
            height: auto;
            cursor: pointer;
        }

        .product-details {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
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

    <!-- Product Details -->
    <div class="container mt-4">
        <?php if ($toastMessage): ?>
            <!-- Toast Notification -->
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px;">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <?php echo htmlspecialchars($toastMessage); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($product_id) && isset($product_title)): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="./images/<?php echo htmlspecialchars($product_image1); ?>" class="product-img" alt="<?php echo htmlspecialchars($product_title); ?>">
                <div class="product-images mt-2">
                    <img src="./images/<?php echo htmlspecialchars($product_image2); ?>" alt="Image 2">
                    <img src="./images/<?php echo htmlspecialchars($product_image3); ?>" alt="Image 3">
                </div>
            </div>
            <div class="col-md-6">
                <h3><?php echo htmlspecialchars($product_title); ?></h3>
                <p><?php echo htmlspecialchars($product_description); ?></p>
                <p><strong>Price:</strong> <?php echo htmlspecialchars($product_price); ?>/-</p>
                <form action="cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-info text-center p-3 mt-4">
        <p>All rights reserved © 2024</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
