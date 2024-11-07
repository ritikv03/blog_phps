<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = $conn->real_escape_string($_POST['author_name']);
    $content = $conn->real_escape_string($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO blogs (author_name, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $author_name, $content);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error saving the blog. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create a New Blog</h2>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="author_name" class="form-label">Author Name</label>
                <input type="text" id="author_name" name="author_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Blog Content</label>
                <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
