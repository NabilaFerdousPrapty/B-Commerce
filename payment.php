<?php
// Include the Stripe PHP library
require 'vendor/autoload.php';

// Set your secret key (you can find it in your Stripe Dashboard)
\Stripe\Stripe::setApiKey(''); // Replace with your actual secret key

// Get the JSON data from the incoming request
$input = json_decode(file_get_contents('php://input'), true);

// Check if payment_method_id and plan are set in the request
if (!isset($input['payment_method_id']) || !isset($input['plan'])) {
    // Return an error if payment_method_id or plan is missing
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

$payment_method_id = $input['payment_method_id'];
$plan = $input['plan']; // Optionally, handle the selected plan

// Determine the amount based on the selected plan
$amount = 0;

switch ($plan) {
    case 'free':
        $amount = 0; // Free plan, no charge
        break;
    case 'premium':
        $amount = 4000; // Premium plan $40, Stripe requires amount in cents
        break;
    case 'enterprise':
        $amount = 10000; // Enterprise plan $100, Stripe requires amount in cents
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid plan']);
        exit;
}

// Create the payment intent using Stripe API
try {
    // Create the PaymentIntent
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'payment_method' => $payment_method_id,
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    // Check if the payment was successful
    if ($paymentIntent->status == 'succeeded') {
        // Payment was successful, return success response
        echo json_encode(['success' => true, 'message' => 'Payment successful']);
    } else {
        // Payment failed, return error response
        echo json_encode(['success' => false, 'message' => 'Payment failed']);
    }
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle Stripe API error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    // Handle other errors
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}
