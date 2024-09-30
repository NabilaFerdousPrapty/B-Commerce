<?php
// Start the session
session_start();

// Check if the cart session is set; if not, initialize it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialize an empty cart array in session
}

// Include the database connection
include('./includes/connect.php');

// Check if the form to add items to the cart has been submitted
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Check if the product already exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++; // Increase the quantity if the item is already in the cart
    } else {
        // Fetch the product details from the database
        $query = "SELECT * FROM products WHERE product_id = '$product_id'";
        $result = mysqli_query($con, $query);
        $product = mysqli_fetch_assoc($result);

        // Add the product to the cart with quantity set to 1
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product['product_id'],
            'product_title' => $product['product_title'],
            'product_price' => $product['product_price'],
            'product_image' => $product['product_image1'],
            'quantity' => 1,
        ];
    }

    // Redirect back to the cart page after adding the product
    header('Location: cart.php');
    exit();
}

// Function to display cart items
function displayCartItems() {
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
        return;
    }

    // Display cart items in a table format
    echo "<h3 class='text-center'>Items in Your Cart</h3>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Image</th><th>Title</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>";
    echo "<tbody>";

    // Loop through each item in the cart and display its details
    foreach ($_SESSION['cart'] as $item) {
        $total_price = $item['product_price'] * $item['quantity'];
        echo "<tr>
                <td><img src='./images/{$item['product_image']}' alt='{$item['product_title']}' style='width: 50px;'></td>
                <td>{$item['product_title']}</td>
                <td>{$item['product_price']} /-</td>
                <td>{$item['quantity']}</td>
                <td>$total_price /-</td>
                <td>
                    <form action='cart.php' method='post'>
                        <input type='hidden' name='product_id' value='{$item['product_id']}'>
                        <button type='submit' name='remove_from_cart' class='btn btn-danger btn-sm'>Remove</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

// Handle removing an item from the cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    // Remove the product from the cart
    unset($_SESSION['cart'][$product_id]);

    // Redirect back to the cart page
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php displayCartItems(); ?>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
