<?php
// Dummy blog posts for demonstration
$posts = [
    1 => ['title' => 'First Blog Post', 'content' => 'This is the full content of the first blog post.'],
    2 => ['title' => 'Second Blog Post', 'content' => 'This is the full content of the second blog post.'],
];

$id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to 1 if no ID is provided
$post = $posts[$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1><?php echo $post['title']; ?></h1>
    </header>
    <main>
        <article>
            <p><?php echo $post['content']; ?></p>
        </article>
        <a href="index.php">Back to Home</a>
    </main>
    <footer>
        <p>&copy; 2024 My Blog</p>
    </footer>
</body>
</html>
