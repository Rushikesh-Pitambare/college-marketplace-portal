<?php
$conn = new mysqli("localhost", "root", "", "collage_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT * FROM products WHERE title LIKE ? OR description LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%" . $query . "%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Results for "<?= htmlspecialchars($query) ?>"</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
body {
  background-color: #f4f4f4;
  font-family: Arial, sans-serif;
}
.container {
  margin-top: 30px;
}
.product-card {
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: 0.3s;
  background: #fff;
}
.product-card:hover {
  transform: scale(1.03);
}
.product-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
}
.product-card .card-body {
  padding: 15px;
  text-align: center;
}
.price {
  color: green;
  font-weight: bold;
  margin-top: 10px;
}
.view-btn {
  background-color: #007bff;
  border: none;
  color: #fff;
  padding: 8px 16px;
  border-radius: 5px;
  transition: 0.3s;
  text-decoration: none;
  display: inline-block;
  margin-top: 10px;
}
.view-btn:hover {
  background-color: #0056b3;
  text-decoration: none;
  color: #fff;
}
.back-btn {
  margin-bottom: 20px;
}
</style>
</head>
<body>

<div class="container">
  <a href="homepagehtml.php" class="btn btn-secondary back-btn">⬅ Back</a>
  <h2 class="text-center mb-4">Search Results for "<?= htmlspecialchars($query) ?>"</h2>

  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="product-card">
            <img src="<?= htmlspecialchars($row['photo1']) ?>" alt="Product Image">
            <div class="card-body">
              <h5><?= htmlspecialchars($row['title']) ?></h5>
              <div class="price">₹<?= number_format($row['price'], 2) ?></div>
              <a href="productdetails.php?id=<?= $row['id'] ?>" class="view-btn">View Details</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <p>No products found matching your search.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
