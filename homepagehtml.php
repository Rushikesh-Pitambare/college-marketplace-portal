<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collage_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch first 6 products
$sql = "SELECT id, title, price, photo1 FROM products LIMIT 6";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="homepagecss.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">College Market</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#categories">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="#sell">Sell</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
      </ul>
      <a href="sellproductpage.php" class="btn btn-outline-light mr-2">Sell Product </a>
      <a href="index.php" class="btn btn-warning">Log out</a>
    </div>
  </nav>

  <section class="hero d-flex align-items-center text-center">
    <div class="container">
      <h1 class="text-white">Buy & Sell Items in Your College</h1>
      <p class="text-light">Find books, electronics, and more from your college community.</p>
      <form class="form-inline justify-content-center mt-4" action="search.php" method="GET">
  <input type="text" name="q" class="form-control form-control-lg mr-2" placeholder="Search items..." required>
  <button type="submit" class="btn btn-primary btn-lg">Search</button>
</form>

    </div>
  </section>

  <section class="categories py-5" id="categories">
    <div class="container text-center">
      <h2 class="mb-4">Categories</h2>
      <div class="row">
        <div class="col-6 col-md-3 mb-4">
          <a href="viewproducts.php?category_id=1" class="text-decoration-none text-dark">
          <div class="category-card p-4">
            <i class="fas fa-book fa-2x mb-2"></i>
            <h6>Books</h6>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
          <a href="viewproducts.php?category_id=2" class="text-decoration-none text-dark">
          <div class="category-card p-4">
            <i class="fas fa-laptop fa-2x mb-2"></i>
            <h6>Electronics</h6>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
          <a href="viewproducts.php?category_id=3" class="text-decoration-none text-dark">
          <div class="category-card p-4">
            <i class="fas fa-tshirt fa-2x mb-2"></i>
            <h6>Clothing</h6>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4">
          <a href="viewproducts.php?category_id=4" class="text-decoration-none text-dark">
          <div class="category-card p-4">
            <i class="fas fa-bicycle fa-2x mb-2"></i>
            <h6>Sports</h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="featured py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-4">Featured Listings</h2>
      <div class="row">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $photo1 = !empty($row['photo1']) ? $row['photo1'] : 'uploads/default.png';
            echo '
              <div class="col-md-4 mb-4">
                <div class="card shadow-sm m-4">
                  <img src="' . htmlspecialchars($photo1) . '" class="card-img-top" alt="' . htmlspecialchars($row['title']) . '">
                  <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>
                    <p class="card-text">₹' . htmlspecialchars($row['price']) . '</p>
                    <a href="productdetails.php?id=' . $row['id'] . '" class="btn btn-outline-primary btn-block">View Details</a>
                  </div>
                </div>
              </div>
            ';
          }
        } else {
          echo '<p class="text-center">No products available yet.</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <section class="cta py-5 text-white text-center" id="sell">
    <div class="container">
      <h2>Have something to sell?</h2>
      <p>Post your listing today and reach your college community.</p>
      <a href="sellproductpage.php" class="btn btn-warning btn-lg">Sell Your Item</a>
    </div>
  </section>

  <footer class="bg-dark text-light py-4">
    <div class="container text-center">
      <p>&copy; 2025 College Marketplace Portal. All Rights Reserved.</p>
    </div>
  </footer>
</body>

</html>

<?php $conn->close(); ?>
