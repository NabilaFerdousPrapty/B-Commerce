<?php
// Start the session
session_start();

// Include the database connection
include('./includes/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    // Delete the product from the cart
    $delete_query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    if (mysqli_query($con, $delete_query)) {
        // Redirect back to the cart page after deletion
        header('Location: view_cart.php');
        exit();
    } else {
        echo "Error removing item from cart: " . mysqli_error($con);
    }
}
?>
