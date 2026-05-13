<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "collage_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get category_id from URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Fetch all products for this category
$sql = "SELECT id, title, price, photo1, photo2, photo3, photo4, photo5, photo6 FROM products WHERE category_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

// Category names
$category_names = [
    1 => "Books 📚",
    2 => "Electronics 💻",
    3 => "Clothing 👕",
    4 => "Sports 🏀"
];
$category_title = $category_names[$category_id] ?? "Products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($category_title) ?></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body {
    background-color: #f8f9fa;
    font-family: "Poppins", sans-serif;
}
.container {
    margin-top: 80px;
}
.product-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
    background-color: #fff;
}
.product-card:hover {
    transform: scale(1.03);
}
.carousel-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
}
.product-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-top: 10px;
}
.price {
    color: #28a745;
    font-weight: bold;
    font-size: 1.1rem;
}
.btn-outline-primary {
    border-radius: 20px;
}
.back-btn {
    position: absolute;
    top: 20px;
    left: 20px;
}
</style>
</head>
<body>

<div class="container">
    <a href="homepagehtml.php" class="btn btn-secondary mb-3">⬅ Back to Home</a>
    <h2 class="text-center mb-5"><?= htmlspecialchars($category_title) ?></h2>

    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Collect all available photos
                $photos = [];
                for ($i = 1; $i <= 6; $i++) {
                    if (!empty($row["photo$i"])) {
                        $photos[] = $row["photo$i"];
                    }
                }
                if (empty($photos)) $photos[] = "uploads/default.png";

                // Unique carousel ID
                $carouselId = "carousel" . $row['id'];

                echo '
                <div class="col-md-4 mb-4">
                    <div class="product-card p-3">
                        <div id="'.$carouselId.'" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">';
                                foreach ($photos as $index => $photo) {
                                    $active = $index === 0 ? "active" : "";
                                    echo '<div class="carousel-item '.$active.'">
                                            <img src="'.htmlspecialchars($photo).'" alt="Product Image">
                                          </div>';
                                }
                echo '      </div>';
                if (count($photos) > 1) {
                    echo '
                        <a class="carousel-control-prev" href="#'.$carouselId.'" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#'.$carouselId.'" role="button" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>';
                }
                echo '  </div>
                        <div class="text-center mt-3">
                            <p class="product-title">'.htmlspecialchars($row['title']).'</p>
                            <p class="price">₹'.htmlspecialchars($row['price']).'</p>
                            <a href="productdetails.php?id='.htmlspecialchars($row['id']).'" class="btn btn-outline-primary btn-block">View Details</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center"><p>No products available in this category yet.</p></div>';
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>