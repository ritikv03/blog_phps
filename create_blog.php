<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'blog_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = $_POST['author_name'];
    $content = $_POST['content'];
    $image_path = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir);
        }
        $target_file = $target_dir . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $stmt = $conn->prepare("INSERT INTO blogs (author_name, content, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $author_name, $content, $image_path);
    $stmt->execute();
    $stmt->close();

    header('Location: index.php');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Create a New Blog</h2>
        <form action="create_blog.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name:</label>
                <input type="text" class="form-control" name="author_name" placeholder="Enter author name" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Blog Content:</label>
                <textarea class="form-control" name="content" rows="5" placeholder="Write your blog content here" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image (Optional):</label>
                <input type="file" class="form-control" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
