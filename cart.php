<?php
session_start();

// If "Add to Cart" is pressed
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Check if the cart session already exists
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
    } else {
        $cart = array();
    }

    // Check if the product is already in the cart
    if (array_key_exists($product_id, $cart)) {
        // If it is, increase the quantity by 1
        $cart[$product_id]['quantity'] += 1;
    } else {
        // Fetch product details from the database
        include('./includes/connect.php');
        $query = "SELECT * FROM products WHERE product_id = $product_id";
        $result = mysqli_query($con, $query);
        $product = mysqli_fetch_assoc($result);

        // Add the product to the cart session with quantity 1
        $cart[$product_id] = array(
            'product_id' => $product['product_id'],
            'product_title' => $product['product_title'],
            'product_price' => $product['product_price'],
            'product_image' => $product['product_image1'],
            'quantity' => 1
        );
    }

    // Update the cart session
    $_SESSION['cart'] = $cart;
      $_SESSION['success_message'] = "Product added to cart successfully!";

    // Redirect back to the products page or show cart
    header('Location: products.php');
    exit();
}
