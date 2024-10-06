<?php
// Start the session
session_start();

// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If "Add to Cart" is pressed
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id']; // Assuming you have user login and user_id is stored in the session
    $quantity = 1; // Default quantity for the product
    
    // Include the database connection
    include('./includes/connect.php');
    
    // Check if the product is already in the cart for this user
    $query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // If the product is already in the cart, update the quantity
        $row = mysqli_fetch_assoc($result);
        $new_quantity = $row['quantity'] + 1;

        $update_query = "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($con, $update_query);
    } else {
        // If the product is not in the cart, insert it
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
        mysqli_query($con, $insert_query);
    }

    // Show success message and redirect back to the index page
    $_SESSION['success_message'] = "Product added to cart successfully!";
    header('Location: index.php');
    exit();
}
