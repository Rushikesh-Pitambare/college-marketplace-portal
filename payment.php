<?php
require __DIR__ . '/vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = "rzp_test_RGLsDtqFEgXAv3";
$keySecret = "N1yrqHNa3RJJ7DdBtodnr20m";

$api = new Api($keyId, $keySecret);

// Get JSON POST data
$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? null;
$amount = $data['amount'] ?? null;

if (!$product_id || !$amount) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Create Razorpay order
$order = $api->order->create([
    'receipt' => 'order_rcptid_' . $product_id,
    'amount' => $amount,
    'currency' => 'INR'
]);

header('Content-Type: application/json');
echo json_encode($order->toArray());
?>
