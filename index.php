<?php
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Including connect file
include('./includes/connect.php');

// Including common functions file
include('admin_area/functions/common_function.php');

function displayAllProduct()
{
    global $con;

    // SQL query to select all products
    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    // Check if there are products in the database
    if (mysqli_num_rows($result) > 0) {
        // Loop through each product and display it
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image = $row['product_image1'];
            $product_price = $row['product_price'];

            // HTML structure for displaying each product
            echo "
            <div class='col-md-4 col-sm-6'>
                <div class='card product-card'>
                    <img src='./images/$product_image' class='card-img-top product-img' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text mt-2'>Price: $product_price/-</p>
                        <form action='cart.php' method='post'>
                            <input type='hidden' name='product_id' value='$product_id'>
                            <input type='submit' name='add_to_cart' value='Add to Cart' class='btn btn-info'>
                            <a href='#' class='btn btn-secondary'>View More</a>
                        </form>
                    </div>
                </div>
            </div>
            ";
        }
    } else {
        echo "<p>No products available.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website using PHP and MySQL</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom Styling */
        .logo {
            width: 100px;
            height: auto;
            /* Maintain aspect ratio */
        }

        .footer-img {
            max-width: 100%;
            height: auto;
        }

        .product-card {
            margin-bottom: 20px;
        }

        .product-img {
            width: 100%;
            height: auto;
            max-height: 200px;
            /* Limit product image height */
            object-fit: cover;
            /* Maintain aspect ratio */
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .bg-info,
        .bg-secondary {
            color: white;
        }

        .navbar-toggler {
            border-color: white;
        }

        .navbar-toggler-icon {
            background-color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <!-- First Child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="./images/logo.png" alt="Logo" class="logo footer-img">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#">Total Price: 
                            <?php
                            if (isset($_SESSION['cart'])) {
                                $total_price = 0;
                                foreach ($_SESSION['cart'] as $item) {
                                    $total_price += $item['product_price'] * $item['quantity'];
                                }
                                echo $total_price;
                            } else {
                                echo 0;
                            }   
                            ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php echo count($_SESSION['cart'] ?? []); ?></sup></a>
                        </li>

                    </ul>
                    <form class="d-flex" action="search_product.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                    </form>
                </div>
            </div>
        </nav>
        <!-- Second Child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome, <?php echo $_SESSION['email']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome Guest</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Third Child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communication is at the heart of e-commerce and community</p>
        </div>
        <!-- Fourth Child -->
        <div class="row px-1">
            <div class="col-md-10">
                <!-- Products -->
                <div class="row">
                    <!-- Calling function to search and display products -->
                    <?php
                    if (isset($_GET['search_data_product'])) {
                        search_product();
                    } else {
                        displayAllProduct();
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-2 bg-secondary p-0">
                <!-- Brands to be displayed -->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="#" class="nav-link text-light">
                            <h4>Delivery Brands</h4>
                        </a>
                    </li>
                    <?php getbrands(); ?>
                </ul>

                <!-- Categories to be displayed -->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="#" class="nav-link text-light">
                            <h4>Categories</h4>
                        </a>
                    </li>
                    <?php getcategories(); ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>