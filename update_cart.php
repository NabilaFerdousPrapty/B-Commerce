<?php
session_start();

if (isset($_POST['product_id']) && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action == 'decrement') {
        // Check if the cart is set
        if (isset($_SESSION['cart']) && array_key_exists($product_id, $_SESSION['cart'])) {
            // Decrement the quantity
            if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                $_SESSION['cart'][$product_id]['quantity']--;
            } else {
                // Optionally remove the item from the cart if quantity is 1
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }

    // Redirect back to the cart page
    header('Location: view_cart.php');
    exit();
}
?>
