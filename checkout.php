<?php
// Start the session
session_start();

// Include the database connection
include('./includes/connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Make sure the 'name' and 'address' fields are set
    if (isset($_POST['name']) && isset($_POST['address'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $payment_method = $_POST['payment_method'];

        // Get the user's cart details
        $user_id = $_SESSION['user_id'];
        $cart_query = "SELECT cart.product_id, cart.quantity, products.product_title, products.product_price, products.product_description 
                      FROM cart 
                      JOIN products ON cart.product_id = products.product_id 
                      WHERE cart.user_id = $user_id";
        $cart_result = mysqli_query($con, $cart_query);

        // Initialize the total amount
        $total_amount = 0;
        $product_details = [];

        // Process each cart item
        while ($cart_item = mysqli_fetch_assoc($cart_result)) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $product_title = $cart_item['product_title'];
            $product_price = $cart_item['product_price'];
            $product_description = $cart_item['product_description'];

            // Calculate total for each product
            $total_for_product = $product_price * $quantity;
            $total_amount += $total_for_product;

            // Store product details for display
            $product_details[] = [
                'product_title' => $product_title,
                'quantity' => $quantity,
                'product_price' => $product_price,
                'total' => $total_for_product,
                'product_description' => $product_description
            ];
        }

        // Calculate approximate delivery date (for simplicity, let's assume 5-7 days)
        $delivery_date = date('Y-m-d', strtotime('+5 days')); // Minimum delivery date
        $max_delivery_date = date('Y-m-d', strtotime('+7 days')); // Maximum delivery date

        // Empty the cart by deleting all items in the user's cart
        $delete_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
        mysqli_query($con, $delete_cart_query);

        // Start of HTML design structure
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Order Summary</title>
            <!-- Include Bootstrap CSS for better design -->
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
            <style>
                body {
                    background-color: #f8f9fa;
                    font-family: Arial, sans-serif;
                    padding: 30px;
                }
                .order-summary {
                    background-color: white;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }
                .order-summary h2, .order-summary h3 {
                    color: #333;
                }
                .table th, .table td {
                    text-align: center;
                    vertical-align: middle;
                }
                .table th {
                    background-color: #007bff;
                    color: white;
                }
                .table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .total-amount {
                    font-size: 1.2em;
                    font-weight: bold;
                    color: #d9534f;
                }
                .delivery-dates {
                    color: #5bc0de;
                }
            </style>
        </head>
        <body>

        <div class='container'>
            <div class='order-summary'>
                <h2>Order Summary</h2>
                <p><strong>Full Name:</strong> $name</p>
                <p><strong>Shipping Address:</strong> $address</p>
                <p><strong>Payment Method:</strong> $payment_method</p>
                <p class='total-amount'><strong>Total Amount:</strong> $total_amount/-</p>
                <p class='delivery-dates'><strong>Approximate Delivery Date:</strong> $delivery_date to $max_delivery_date</p>
                <hr>

                <h3>Products in Your Order</h3>
                <table class='table table-bordered table-striped'>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>";

        foreach ($product_details as $product) {
            echo "<tr>";
            echo "<td>{$product['product_title']}</td>";
            echo "<td>{$product['product_price']}/-</td>";
            echo "<td>{$product['quantity']}</td>";
            echo "<td>{$product['total']}/-</td>";
            echo "<td>{$product['product_description']}</td>";
            echo "</tr>";
        }

        echo "</tbody>
                </table>
                <button class='btn btn-primary' onclick='window.location.href=\"index.php\"'>Go to Home</button>
            </div>
        </div>

        <!-- Include Bootstrap JS -->
        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js'></script>
        </body>
        </html>";
    } else {
        // If the required fields are not set, show an error message
        echo "Please provide both your name and address.";
    }
} else {
    // If the form was not submitted via POST, redirect back to the cart page
    header("Location: view_cart.php");
    exit();
}
