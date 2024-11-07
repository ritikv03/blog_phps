<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'blog_db'); // Replace with your MySQL credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blogs from the database
$result = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");

// Get logged-in user's name from session or other means
$loggedInUser = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; // Assuming session stores user name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogVault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg bg-dark-purple w-100">
        <div class="container-fluid">
            <span class="navbar-text text-highlight">"Your daily dose of insightful blogging"</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a id="authLink" class="nav-link" href="login.php">Login</a> <!-- Login link by default -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container flex-grow-1">
        <main class="my-4 d-flex justify-content-between align-items-center">
            <h1>Welcome to BlogVault</h1>
            <button id="createBlogBtn" class="btn btn-primary" style="display:none;">Create Blog</button> <!-- Hidden by default -->
        </main>
        
        <!-- Blog Content Section -->
        <div class="row">
            <?php while ($blog = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Author: <?php echo htmlspecialchars($blog['author_name']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>

                            <!-- Display Image if Available -->
                            <?php if (!empty($blog['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['image_path']); ?>" alt="Blog Image" class="img-fluid mb-3">
                            <?php endif; ?>

                            <small class="text-muted">Published on: <?php echo $blog['created_at']; ?></small>

                            <!-- Delete Button for Logged-in User's Blogs -->
                            <?php if ($blog['author_name'] == $loggedInUser): ?>
                                <form method="POST" action="delete_blog.php" style="display:inline;">
                                    <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm mt-3">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="bg-dark-purple text-white text-center py-3 mt-auto">
        <p>&copy; 2024 BlogVault. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if user is logged in from localStorage
        const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

        if (isLoggedIn) {
            document.getElementById('createBlogBtn').style.display = 'block'; // Show Create Blog button if logged in
            document.getElementById('authLink').textContent = 'Logout'; // Change Login to Logout
            document.getElementById('authLink').href = '#'; // Remove login link for logout

            // Add logout functionality
            document.getElementById('authLink').addEventListener('click', function() {
                localStorage.removeItem('isLoggedIn'); // Clear login status
                window.location.reload(); // Reload to reflect the login button
            });
        }

        // Handle Create Blog button click
        document.getElementById('createBlogBtn').addEventListener('click', function() {
            if (isLoggedIn) {
                window.location.href = 'create_blog.php'; // Redirect to create blog page
            } else {
                let toastElement = document.createElement('div');
                toastElement.className = 'toast align-items-center text-bg-danger border-0 position-fixed bottom-0 end-0 p-3';
                toastElement.setAttribute('role', 'alert');
                toastElement.setAttribute('aria-live', 'assertive');
                toastElement.setAttribute('aria-atomic', 'true');
                toastElement.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            User is not logged in.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                document.body.appendChild(toastElement);
                let toast = new bootstrap.Toast(toastElement);
                toast.show();
            }
        });
    </script>

<?php $conn->close(); ?>
</body>
</html>
