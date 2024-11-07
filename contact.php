<?php
// Start the session
session_start();

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Including connect file
include('./includes/connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert data into database
    $query = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    $result = mysqli_query($con, $query);

    if ($result) {
        $success_message = "Your message has been sent successfully!";
    } else {
        $error_message = "There was an error sending your message. Please try again later.";
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
            width: 100px;
            height: 100px;
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
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-info bg-gradient">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="/" class="">
                    <img src="./images/logo.png" alt="Logo" class="logo ">
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
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
        <!-- Contact Form Section -->
        <div class="container contact-form-container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <h3 class="text-center mb-4">Contact Us</h3>

                        <?php
                        if (isset($success_message)) {
                            echo "<div class='message success alert alert-success'>$success_message</div>";
                        }
                        if (isset($error_message)) {
                            echo "<div class='message error alert alert-danger'>$error_message</div>";
                        }
                        ?>

                        <form action="contact.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="name" class="fw-bold">Your Name</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="fw-bold">Your Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="subject" class="fw-bold">Subject</label>
                                <input type="text" class="form-control form-control-lg" id="subject" name="subject"
                                    required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="message" class="fw-bold">Your Message</label>
                                <textarea class="form-control form-control-lg" id="message" name="message" rows="5"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg btn-block btn-gradient">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .contact-form-container {
                margin-top: 50px;
                margin-bottom: 50px;
                background-color: #f1f1f1;
                padding: 30px;
                border-radius: 10px;
            }

            .contact-form {
                background-color: #ffffff;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            }

            .contact-form h3 {
                font-size: 2rem;
                font-weight: bold;
                color: #333;
            }

            .form-control {
                border-radius: 10px;
                padding: 15px;
                font-size: 1.1rem;
                box-shadow: none;
                width: 100%;
                /* Ensure the fields take full width */
            }

            .form-control:focus {
                border-color: #17a2b8;
                box-shadow: 0px 0px 5px rgba(0, 173, 255, 0.5);
            }

            .btn-gradient {
                background: linear-gradient(45deg, #00b4d8, #0077b6);
                color: white;
                font-weight: bold;
                padding: 15px;
                border: none;
                border-radius: 50px;
                transition: all 0.3s ease;
                width: 100%;
                /* Ensure button takes full width */
            }

            .btn-gradient:hover {
                background: linear-gradient(45deg, #0077b6, #00b4d8);
                transform: translateY(-5px);
                box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.3);
            }

            .alert {
                font-size: 1.2rem;
                font-weight: bold;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
            }

            .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
            }

            .message {
                margin-bottom: 20px;
            }
        </style>



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