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

        .accordion-button {
            background-color: #0077b6;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .accordion-button:not(.collapsed) {
            background-color: #00b4d8;
            color: white;
        }

        .accordion-button:hover {
            background-color: #00b4d8;
            color: white;
        }

        .accordion-body {
            font-size: 1.1rem;
            color: #555;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 2px solid #ddd;
            border-radius: 10px;
        }

        .accordion-item {
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .accordion-item:last-child {
            margin-bottom: 0;
        }

        .accordion-header {
            background-color: #fff;
            border-bottom: 2px solid #ddd;
        }

        .accordion-body a {
            color: #0077b6;
            text-decoration: none;
            font-weight: bold;
        }

        .accordion-body a:hover {
            text-decoration: underline;
        }

        .container h2 {
            font-size: 2.2rem;
            color: #333;
            font-weight: bold;
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

        <div class="py-5">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://i.ibb.co/ZfMqgBX/smiling-young-two-girls-sitting-floor-shopping-bags-gift-open-pizza-turquoise-wall.jpg"
                            class="d-block w-100 rounded-image" alt="Shopping image 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Shop the Latest Trends</h5>
                            <p>Discover our newest collection!</p>
                            <a href="#" class="btn btn-info">Shop Now</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://img.freepik.com/premium-photo/portrait-two-excited-young-woman-hand-holding-shopping-bag-isolated-blue-wall_231208-11826.jpg"
                            class="d-block w-100 rounded-image" alt="Shopping image 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Exciting Offers</h5>
                            <p>Get the best deals on your favorite items.</p>
                            <a href="#" class="btn btn-info">Explore Offers</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://img.freepik.com/premium-photo/portrait-nice-cute-girls-embracing-holding-hands-carrying-new-cool-purchase-isolated-yellow-wall_231208-11816.jpg"
                            class="d-block w-100 rounded-image" alt="Shopping image 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>New Arrivals</h5>
                            <p>Fresh styles and trending looks.</p>
                            <a href="#" class="btn btn-info">See New Arrivals</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <!-- Third Child -->
        <div class="bg-light">
            <div class="container text-center">
                <h3 class="hidden-store-title">
                    Welcome to Our Store
                </h3>
                <p class="hidden-store-description">
                    We offer a wide range of products to suit your needs. From food to fashion, we have it all!
                </p>
                <a href="product.php" class="btn btn-primary mt-3">Explore Our Products</a>
            </div>

        </div>
        <!-- Fourth Child -->
        <div class="bg-white py-8">
            <div class="container px-6 py-8 mx-auto">
                <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">Pricing Plan</h1>

                <p class="max-w-2xl mx-auto mt-4 text-center text-gray-500 xl:mt-6">
                    Choose the plan that works best for you. Whether you're just starting out or looking to scale your
                    business, we have a plan that fits your needs.
                </p>

                <div class="row mt-6">
                    <!-- Free Plan -->
                    <div class="col-md-4 mb-4">
                        <div class="card border border-gray-200 rounded-lg shadow-sm text-center">
                            <div class="card-body">
                                <p class="font-medium text-gray-500 text-uppercase">Free</p>
                                <h2 class="card-title text-4xl font-semibold text-gray-800">$0</h2>
                                <p class="font-medium text-gray-500">Life time</p>
                                <button class="btn btn-primary w-100 mt-4" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal" data-plan="free">Start Now</button>
                            </div>
                        </div>
                    </div>

                    <!-- Premium Plan -->
                    <div class="col-md-4 mb-4">
                        <div class="card text-white bg-primary rounded-lg text-center">
                            <div class="card-body">
                                <p class="font-medium text-uppercase">Premium</p>
                                <h2 class="card-title text-5xl font-bold">$40</h2>
                                <p class="font-medium">Per month</p>
                                <button class="btn btn-light w-100 mt-4" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal" data-plan="premium">Start Now</button>
                            </div>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="col-md-4 mb-4">
                        <div class="card border border-gray-200 rounded-lg shadow-sm text-center">
                            <div class="card-body">
                                <p class="font-medium text-gray-500 text-uppercase">Enterprise</p>
                                <h2 class="card-title text-4xl font-semibold text-gray-800">$100</h2>
                                <p class="font-medium text-gray-500">Life time</p>
                                <button class="btn btn-primary w-100 mt-4" data-bs-toggle="modal"
                                    data-bs-target="#paymentModal" data-plan="enterprise">Start Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Payment Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="payment-form">
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Card details</label>
                                <div id="card-element"></div>
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <div class="mb-3">
                                <label for="plan" class="form-label">Selected Plan: </label>
                                <span id="selected-plan"></span>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Include Stripe.js -->
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // Initialize Stripe
            var stripe = Stripe(
                'pk_test_51PMqy0RvxQOIzmuHOlsUy1frX456WLEKO7kRSWYqp2CptvO4xaxGSI9lFKN9FYtJ7GTVx1s4b5HDTncWr9hPJYZC00vamyHu4S'
            ); // Replace with your actual public key
            var elements = stripe.elements();

            // Create an instance of the card Element
            var card = elements.create('card');
            card.mount('#card-element');

            // Show selected plan in the modal when button is clicked
            var selectedPlanElement = document.getElementById('selected-plan');
            var planButtons = document.querySelectorAll('[data-plan]');

            planButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var plan = button.getAttribute('data-plan');
                    selectedPlanElement.textContent = plan.charAt(0).toUpperCase() + plan.slice(1) +
                        ' Plan';
                });
            });


            var paymentForm = document.getElementById('payment-form');
            paymentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Get the payment method
                stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                }).then(function(result) {
                    if (result.error) {
                        // Handle error here
                        alert(result.error.message);
                    } else {
                        // Send the payment method id to your server for further processing
                        // You'll need to handle the payment on the server side with your backend
                        var paymentMethodId = result.paymentMethod.id;

                        // Example of sending payment method to server
                        // Send the payment method id to your server for further processing
                        fetch('/payment.php', {
                                method: 'POST',
                                body: JSON.stringify({
                                    payment_method_id: paymentMethodId,
                                    plan: plan // Send the selected plan if necessary
                                }),
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Check if payment was successful and show corresponding alert
                                let alertHTML = '';
                                if (data.success) {
                                    // Show success alert using Bootstrap
                                    alertHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Payment Successful!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                                } else {
                                    // Show error alert using Bootstrap
                                    alertHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${data.message || 'Payment failed. Please try again.'}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
                                }
                                // Insert the alert at the beginning of the page (or wherever you prefer)
                                document.body.insertAdjacentHTML('afterbegin', alertHTML);
                            })
                            .catch(error => {
                                // Show error alert using Bootstrap if there is a problem with the fetch request
                                const errorAlertHTML = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error: ${error.message || 'Something went wrong with the payment request.'}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
                                // Insert the alert at the beginning of the page (or wherever you prefer)
                                document.body.insertAdjacentHTML('afterbegin', errorAlertHTML);
                            });

                    }
                });
            });
        </script>


        <div class="container my-5">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>

            <div class="accordion" id="accordionFAQ">
                <!-- FAQ 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            What services do you offer?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionFAQ">
                        <div class="accordion-body">
                            We offer a wide range of services, including web development, mobile application
                            development, UI/UX design, and software consulting. Our focus is to provide tailored
                            solutions to help businesses succeed online.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How can I get in touch with you?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionFAQ">
                        <div class="accordion-body">
                            You can contact us via our <a href="contact.php" class="text-decoration-none">Contact Us</a>
                            page, where you'll find a contact form to send us a message. Alternatively, you can reach us
                            through our social media profiles or via email.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What is the estimated timeline for project delivery?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionFAQ">
                        <div class="accordion-body">
                            The timeline for delivery depends on the scope and complexity of the project. Typically, for
                            a standard website or mobile application, it takes 4 to 6 weeks. We provide a detaileto
                            timeline and milestones once we understand the project requirements.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Do you provide ongoing support after the project is completed?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#accordionFAQ">
                        <div class="accordion-body">
                            Yes, we offer ongoing support and maintenance services after the completion of your project.
                            We can assist with updates, bug fixes, and any new features that you may require.
                        </div>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Can you work with an existing website or app?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                        data-bs-parent="#accordionFAQ">
                        <div class="accordion-body">
                            Absolutely! We can work with your existing website or app to improve its design,
                            functionality, and performance. Whether you need a redesign, feature updates, or bug fixes,
                            we are here to help.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include './footer.php' ?>


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