<?php
session_start();

// Display cart items
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $cart = $_SESSION['cart'];
    echo "<h3>Your Cart</h3>";
    echo "<table class='table table-bordered'>";
    echo "<thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
          </thead>";
    echo "<tbody>";
    $total_price = 0;

    foreach ($cart as $item) {
        $product_title = $item['product_title'];
        $product_image = $item['product_image'];
        $product_price = $item['product_price'];
        $quantity = $item['quantity'];
        $total = $product_price * $quantity;
        $total_price += $total;

        echo "<tr>
                <td><img src='./images/$product_image' width='50' alt='$product_title'> $product_title</td>
                <td>$quantity</td>
                <td>$product_price/-</td>
                <td>$total/-</td>
                <td><a href='remove_cart.php?product_id={$item['product_id']}' class='btn btn-danger'>Remove</a></td>
              </tr>";
    }

    echo "<tr>
            <td colspan='3' align='right'>Total</td>
            <td colspan='2'>$total_price/-</td>
          </tr>";
    echo "</tbody></table>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>
