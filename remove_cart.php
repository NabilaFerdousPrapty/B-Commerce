<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];

        // Remove the item from the cart
        unset($cart[$product_id]);

        // Update the cart session
        $_SESSION['cart'] = $cart;
    }

    header('Location: view_cart.php');
    exit();
}
?>
