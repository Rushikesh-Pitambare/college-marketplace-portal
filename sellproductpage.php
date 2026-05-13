<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "collage_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id']; // match the select name

    // Uploads directory
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $photos = [];
    for ($i = 1; $i <= 6; $i++) {
        $photoField = "photo" . $i;
        if (isset($_FILES[$photoField]) && !empty($_FILES[$photoField]['name'])) {
            $filename = time() . "_" . basename($_FILES[$photoField]["name"]);
            $target_file = $target_dir . $filename;
            move_uploaded_file($_FILES[$photoField]["tmp_name"], $target_file);
            $photos[$i] = $target_file;
        } else {
            $photos[$i] = null;
        }
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO products 
        (category_id, title, description, price, photo1, photo2, photo3, photo4, photo5, photo6)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters: category_id=int, title=str, description=str, price=double, photo1-6=str
    $stmt->bind_param(
        "issdssssss", 
        $category_id, $title, $description, $price, 
        $photos[1], $photos[2], $photos[3], $photos[4], $photos[5], $photos[6]
    );

    if ($stmt->execute()) {
        echo "<script>alert('✅ Product posted successfully!'); window.location.href='homepagehtml.php';</script>";
    } else {
        echo "<script>alert('❌ Error posting product: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Your Product</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="sellproductcss.css">
</head>
<body>
  <div class="post-container">
    <h2 style="text-align:center;">POST YOUR PRODUCT</h2>
    <p><a href="categorypage.html">Change the Category</a></p>

    <form method="POST" enctype="multipart/form-data">

      <p class="section-title">INCLUDE PRODUCT DETAILS</p>
      <div class="form-group">
          <label for="category_id">Select Category:</label>
          <select name="category_id" id="category_id" class="form-control" required>
              <option value="">-- Choose a Category --</option>
              <option value="1">📚 Books</option>
              <option value="2">💻 Electronics</option>
              <option value="3">👕 Clothing</option>
              <option value="4">🏀 Sports</option>
          </select>
      </div>

      <label for="title">Title of Product</label>
      <input type="text" id="title" name="title" placeholder="Mention key features of your item" required>

      <label for="description">Description</label>
      <textarea id="description" name="description" placeholder="Include condition, features and reason for selling" required></textarea>

      <p class="section-title">SET A PRICE</p>
      <input type="number" id="price" name="price" step="0.01" placeholder="Price" required>

      <p class="section-title">UPLOAD UP TO 6 PHOTOS</p>
      <div class="photo-upload-section">
        <?php for ($i = 1; $i <= 6; $i++): ?>
          <div class="photo-box">
            <label>Add Photo</label>
            <input type="file" name="photo<?= $i ?>" accept="image/*">
          </div>
        <?php endfor; ?>
      </div>

      <p style="color:red; font-size:13px;">This field is mandatory</p>
      <div class="d-flex flex-row justify-content-center">
        <button type="submit" class="post-btn">Post now</button>
      </div>

    </form>
  </div>
</body>
</html>
