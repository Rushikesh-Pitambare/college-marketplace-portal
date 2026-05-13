<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collage_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get GET parameters safely
$payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;
$order_id   = isset($_GET['order_id']) ? $_GET['order_id'] : null;
$amount     = isset($_GET['amount']) ? intval($_GET['amount']) : 0;
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Validate
if (!$payment_id || !$order_id || !$amount || !$product_id) {
    die("Invalid payment details. Please check the URL.");
}

// Fetch product details
$product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
$product_name = $product['title'] ?? 'Unknown Product';

// Create payments table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(50) NOT NULL,
    payment_id VARCHAR(50) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    amount INT NOT NULL,
    created_at DATETIME NOT NULL
)");

// Insert payment record
$stmt = $conn->prepare("INSERT INTO payments (order_id, payment_id, product_name, amount, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->bind_param("sssi", $order_id, $payment_id, $product_name, $amount);
$stmt->execute();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt - College Marketplace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .receipt { max-width: 700px; margin: 50px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; }
        .receipt h2 { color: #28a745; }
        .receipt table { width: 100%; margin-top: 20px; }
        .receipt table th, .receipt table td { padding: 8px; text-align: left; }
        .btn-download { margin-top: 20px; }
    </style>
</head>
<body>
<div class="receipt">
    <h2 class="text-center">Payment Successful!</h2>
    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
    <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_id); ?></p>
    <p><strong>Date:</strong> <?php echo date("d-m-Y H:i:s"); ?></p>

    <h4>Product Details</h4>
    <table class="table table-bordered">
        <tr>
            <th>Product Name</th>
            <td><?php echo htmlspecialchars($product_name); ?></td>
        </tr>
        <tr>
            <th>Price</th>
            <td>₹<?php echo number_format($amount/100, 2); ?></td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>1</td>
        </tr>
    </table>

    <h4>Total Paid: ₹<?php echo number_format($amount/100, 2); ?></h4>

    <button onclick="window.print()" class="btn btn-primary btn-download">Download / Print Receipt</button>
</div>
</body>
</html>

<?php
$conn->close();
?>
