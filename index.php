<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome to My Blog</h1>
    </header>
    <main>
        <?php
        // Sample data for demonstration purposes
        $posts = [
            ['id' => 1, 'title' => 'First Blog Post', 'excerpt' => 'This is a short description of the first post.'],
            ['id' => 2, 'title' => 'Second Blog Post', 'excerpt' => 'This is a short description of the second post.'],
        ];

        foreach ($posts as $post) {
            echo "<div class='post'>";
            echo "<h2><a href='post.php?id=" . $post['id'] . "'>" . $post['title'] . "</a></h2>";
            echo "<p>" . $post['excerpt'] . "</p>";
            echo "</div>";
        }
        ?>
    </main>
    <footer>
        <p>&copy; 2024 My Blog</p>
    </footer>
</body>
</html>
