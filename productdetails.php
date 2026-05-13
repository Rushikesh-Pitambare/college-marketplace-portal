<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collage_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Get product ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    die("Invalid product ID");
}

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
if ($result->num_rows == 0) die("Product not found");

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['title']); ?> - College Marketplace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-image { width: 100%; max-height: 500px; object-fit: contain; }
        .thumbnail { width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent; }
        .thumbnail.selected { border-color: #007bff; }
        .price { font-size: 28px; color: #ff3f6c; font-weight: bold; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">College Marketplace</a>
</nav>

<div class="container my-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <img id="mainImage" src="<?php echo htmlspecialchars($product['photo1']); ?>" class="product-image mb-3">
            <div class="d-flex">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    $photoKey = "photo$i";
                    if (!empty($product[$photoKey])) {
                        echo '<img src="' . htmlspecialchars($product[$photoKey]) . '" class="thumbnail mr-2" onclick="changeImage(this)">';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product['title']); ?></h2>
            <p class="price">₹<?php echo htmlspecialchars($product['price']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

            <div class="mt-4">
                <button class="btn btn-primary btn-lg mr-2" onclick="buyNow(<?php echo $product['id']; ?>, <?php echo $product['price']; ?>, '<?php echo addslashes($product['title']); ?>')">Buy Now</button>
                <a href="#" class="btn btn-outline-secondary btn-lg"><i class="fas fa-heart"></i> Chat with Seller</a>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
function changeImage(element) {
    document.getElementById('mainImage').src = element.src;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('selected'));
    element.classList.add('selected');
}

function buyNow(productId, price, productName) {
    var amountInPaise = price * 100;

    fetch('payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, amount: amountInPaise })
    })
    .then(response => response.json())
    .then(order => {
        if(order.error) {
            alert(order.error);
            return;
        }

        var options = {
            "key": "rzp_test_RGLsDtqFEgXAv3",
            "amount": order.amount,
            "currency": order.currency,
            "name": "College Marketplace",
            "description": productName,
            "order_id": order.id,
            "handler": function (response){
                // Redirect automatically to success.php with all parameters
                var params = new URLSearchParams({
                    payment_id: response.razorpay_payment_id,
                    order_id: order.id,
                    amount: order.amount,
                    product_id: productId
                });
                window.location.href = "success.php?" + params.toString();
            },
            "prefill": { "name": "", "email": "" },
            "theme": { "color": "#ff3f6c" }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    })
    .catch(err => { console.error(err); alert("Error creating order. Please try again."); });
}
</script>

</body>
</html>

<?php $conn->close(); ?>
