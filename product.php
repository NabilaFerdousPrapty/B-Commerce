<?php
// Start the session
session_start();

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Including connect file
include('./includes/connect.php');

// Including common functions file
include('admin_area/functions/common_function.php');

// Function to display all products
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
<!-- http://localhost/ECommerce/index.php -->

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
            height: 80px;
            /* Adjust the logo size */
            width: auto;
        }

        .footer-img {
            max-width: 100%;
            height: auto;
        }

        .product-card {
            margin-bottom: 20px;
        }

        .product-img {
            width: 80%;
            height: auto;
            max-height: 200px;
            object-fit: cover;

        }

        /* Main Navbar - Align Links to the Center */
        .navbar-nav {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-left: 0;
        }

        /* Adjust padding in the navbar for less spacing */
        .navbar-light .navbar-nav .nav-link {
            padding-left: 10px;
            padding-right: 10px;
        }

        /* Adjust logo size and make sure it looks good */
        .logo {
            height: 40px;
            /* Adjust the logo size */
            width: auto;
        }

        /* Search input and button */
        .form-control {
            width: 200px;
            /* Adjust search box width */
        }

        /* Second Navbar - Align links to the center */
        .navbar-dark .navbar-nav {
            justify-content: center;
            width: 100%;
        }

        /* Make the navbar more compact */
        .navbar {
            padding: 10px 0;
            /* Reduce vertical padding */
        }

        /* Navbar links when hovered */
        .nav-link:hover {
            color: #ff6347;
            /* Change link color on hover */
        }

        /* Navbar items active state */
        .nav-link.active {
            color: #fff;
            font-weight: bold;
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

        .rounded-image {
            max-width: 80%;
            /* Adjust as needed for your layout */
            border-radius: 15px;
            /* Rounded corners */
            margin: auto;
            /* Center align if not taking full width */
        }

        /* Adjust the caption text and button */
        .carousel-caption h5 {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .carousel-caption p {
            color: white;
        }

        .carousel-caption .btn-info {
            background-color: #17a2b8;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        /* Container */
        .container {
            padding: 50px 20px;
        }

        /* Title styling */
        .hidden-store-title {
            font-size: 2.5rem;
            /* Large font size */
            font-weight: 700;
            /* Bold */
            color: #333;
            /* Dark color for the title */
            text-transform: uppercase;
            /* Uppercase letters */
            letter-spacing: 2px;
            /* Spacing between letters */
            margin-bottom: 20px;
            /* Spacing below the title */
            position: relative;
            display: inline-block;
        }

        /* Underline effect */
        .hidden-store-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background-color: #ff6347;
            /* Bright color for underline */
            bottom: -5px;
            left: 25%;
        }

        /* Description text styling */
        .hidden-store-description {
            font-size: 1.2rem;
            /* Medium font size */
            color: #555;
            /* Lighter color for the description */
            font-style: italic;
            /* Italic style */
            max-width: 700px;
            /* Limiting the width for better readability */
            margin: 0 auto;
            /* Centering the paragraph */
            line-height: 1.6;
            /* Adding spacing between lines */
            letter-spacing: 1px;
        }

        /* Responsive design: Adjust font size for smaller screens */
        @media (max-width: 600px) {
            .hidden-store-title {
                font-size: 2rem;
                /* Smaller font size for mobile */
            }

            .hidden-store-description {
                font-size: 1rem;
                /* Adjust description size */
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <!-- First Child -->
        <!-- Main Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info bg-gradient">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="/" class="navbar-brand">
                    <img src="./images/logo.png" alt="Logo" class="logo footer-img">
                </a>

                <!-- Toggle Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/EcommerceWebsite">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product.php">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>

                        <!-- Display Total Price -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">Total Price:
                                <?php
                                if (isset($_SESSION['user_id'])) {
                                    $user_id = $_SESSION['user_id'];

                                    $query = "SELECT products.product_price, cart.quantity 
                                FROM cart 
                                JOIN products ON cart.product_id = products.product_id 
                                WHERE cart.user_id = $user_id";
                                    $result = mysqli_query($con, $query);

                                    $total_price = 0;
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $product_price = $row['product_price'];
                                            $quantity = $row['quantity'];
                                            $total_price += $product_price * $quantity;
                                        }
                                    }
                                    echo $total_price . ' Taka';
                                } else {
                                    echo '0 Taka';
                                }
                                ?>
                            </a>
                        </li>

                        <!-- Display Total Cart Items -->
                        <li class="nav-item">
                            <a class="nav-link" href="view_cart.php">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <sup>
                                    <?php
                                    if (isset($_SESSION['user_id'])) {
                                        $user_id = $_SESSION['user_id'];
                                        $query = "SELECT SUM(quantity) AS total_quantity 
                                  FROM cart 
                                  WHERE user_id = $user_id";
                                        $result = mysqli_query($con, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        $total_items = $row['total_quantity'] ? $row['total_quantity'] : 0;
                                        echo $total_items;
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </sup>
                            </a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <!-- Show User Icon if Logged In -->
                                <a class="nav-link" href="#" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="Welcome: <?php echo $_SESSION['email']; ?>">
                                    <i class="fa-solid fa-user"></i> <!-- User Icon -->
                                </a>


                            </li>
                            <li class="nav-item">
                                <!-- Logout Button -->
                                <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                            </li>

                        <?php else: ?>


                            <a class="nav-link btn btn-success"" href=" login.php">Login</>


                                <a class="nav-link btn btn-danger" href="register.php">Register</a>

                            <?php endif; ?>
                    </ul>

                    <!-- Authentication & User Info -->



                </div>

                <!-- Search Form -->
                <form class="d-flex" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                </form>
            </div>
        </nav>



        <!-- Third Child -->
        <div class="bg-light">
            <div class="container text-center">
                <h3 class="hidden-store-title">
                    Our Products
                </h3>
                <p class="hidden-store-description">
                    Check out our latest products and find the best deals on everything you need for your home.
                </p>
            </div>

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
    <script>
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>