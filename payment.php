<?php
require 'vendor/autoload.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set Stripe API key
\Stripe\Stripe::setApiKey(''); // Replace with your secret key

// Set the correct header for JSON response
header('Content-Type: application/json');

// Get payment details from the request
$input = json_decode(file_get_contents('php://input'), true);
$paymentMethodId = $input['payment_method_id'] ?? null;
$amount = $input['amount'] ?? null; // Amount in cents

// Validate the input data
if (!$paymentMethodId || !$amount) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data']);
    exit();
}

try {
    // Create a PaymentIntent with amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'usd',
        'payment_method' => $paymentMethodId,
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    // Use a switch to handle different payment statuses
    switch ($paymentIntent->status) {
        case 'succeeded':
            echo json_encode(['success' => true, 'message' => 'Payment successful']);
            break;

        case 'requires_action':
            echo json_encode(['success' => false, 'message' => 'Payment requires additional action']);
            break;

        case 'requires_payment_method':
            echo json_encode(['success' => false, 'message' => 'Payment failed: Requires a valid payment method']);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Payment status unknown']);
            break;
    }
} catch (\Stripe\Exception\ApiErrorException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
