<?php
// Start the session
session_start();

// Include the database connection
include('./includes/connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your cart.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from the database for the logged-in user
$query = "SELECT * FROM cart_items WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);

// Function to display the cart items
function displayCartItems($result) {
    if (mysqli_num_rows($result) == 0) {
        echo "<p>Your cart is empty.</p>";
        return;
    }

    // Display cart items in a table format
    echo "<h3 class='text-center'>Items in Your Cart</h3>";
    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Image</th><th>Title</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>";
    echo "<tbody>";

    $grand_total = 0;
    // Loop through each cart item and display its details
    while ($item = mysqli_fetch_assoc($result)) {
        $total_price = $item['product_price'] * $item['quantity'];
        $grand_total += $total_price;

        echo "<tr>
                <td><img src='./images/{$item['product_image']}' alt='{$item['product_title']}' style='width: 50px;'></td>
                <td>{$item['product_title']}</td>
                <td>{$item['product_price']} /-</td>
                <td>{$item['quantity']}</td>
                <td>$total_price /-</td>
                <td>
                    <form action='view_cart.php' method='post'>
                        <input type='hidden' name='cart_item_id' value='{$item['id']}'>
                        <button type='submit' name='remove_from_cart' class='btn btn-danger btn-sm'>Remove</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "<tfoot>
            <tr>
                <td colspan='4' class='text-end'>Grand Total:</td>
                <td>$grand_total /-</td>
                <td></td>
            </tr>
          </tfoot>";
    echo "</table>";
}

// Handle removing an item from the cart
if (isset($_POST['remove_from_cart'])) {
    $cart_item_id = $_POST['cart_item_id'];

    // Remove the item from the cart
    $delete_query = "DELETE FROM cart_items WHERE id = '$cart_item_id'";
    mysqli_query($con, $delete_query);

    // Refresh the cart page to reflect changes
    header('Location: view_cart.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php displayCartItems($result); ?>
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
