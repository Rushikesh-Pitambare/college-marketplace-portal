<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: sellproductpage.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = $_POST['price'] ?? 0;

// Basic server-side validation
if ($title === '' || $description === '' || $price === '') {
    $_SESSION['flash'] = "Please fill all required fields.";
    $_SESSION['flash_type'] = "error";
    header('Location: sellproductpage.php');
    exit;
}

// Upload settings
$targetDir = __DIR__ . '/uploads/';
$publicDir = 'uploads/'; // saved to DB for use in <img src="uploads/xxx">
$maxFileSize = 2 * 1024 * 1024; // 2 MB
$allowedExt = ['jpg','jpeg','png','gif'];

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// Helper to upload single file and return relative path or null
function handleFileUpload($fileKey, $targetDir, $publicDir, $maxFileSize, $allowedExt) {
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES[$fileKey];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if ($file['size'] > $maxFileSize) {
        return null;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // quick mime check + extension check
    $mimeAllowed = ['image/jpeg','image/png','image/gif'];
    if (!in_array($mime, $mimeAllowed) || !in_array($ext, $allowedExt)) {
        return null;
    }

    // make unique name
    $newName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $destination = $targetDir . $newName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return null;
    }

    // return relative path saved in DB
    return $publicDir . $newName;
}

// Process up to 6 photos
$photos = [];
for ($i = 1; $i <= 6; $i++) {
    $key = "photo{$i}";
    $path = handleFileUpload($key, $targetDir, $publicDir, $maxFileSize, $allowedExt);
    $photos[$i] = $path; // may be null
}

// Insert into database
$sql = "INSERT INTO products (title, description, price, photo1, photo2, photo3, photo4, photo5, photo6)
        VALUES (:title, :description, :price, :p1, :p2, :p3, :p4, :p5, :p6)";

$stmt = $conn->prepare($sql);

$params = [
    ':title' => $title,
    ':description' => $description,
    ':price' => $price,
    ':p1' => $photos[1],
    ':p2' => $photos[2],
    ':p3' => $photos[3],
    ':p4' => $photos[4],
    ':p5' => $photos[5],
    ':p6' => $photos[6],
];

try {
    $stmt->execute($params);
    $_SESSION['flash'] = "✅ Product posted successfully!";
    $_SESSION['flash_type'] = "success";
} catch (Exception $e) {
    // On DB error, consider cleaning up uploaded files (optional)
    $_SESSION['flash'] = "Error saving product: " . $e->getMessage();
    $_SESSION['flash_type'] = "error";
}

header('Location: sellproductpage.php');
exit;
