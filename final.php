<?php
// Database connection (ensure this matches your database setup)
$servername = "localhost";
$username = "root";
$password = "nigga";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ravenbooks</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        .header {
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title {
            font-size: 1.5rem;
        }

        .nav-container {
            height: 100vh;
            background-color: #f8f9fa;
            padding: 20px;
            display: block;
        }

        .books-container {
            height: 100vh;
            overflow-y: auto;
            padding: 20px;
        }

        .book_scroll_container {
            display: flex;
            overflow-x: scroll;
            padding: 10px;
            gap: 15px;
        }

        /* Scrollbar Styles */
        .book_scroll_container::-webkit-scrollbar {
            height: 8px;
        }

        .book_scroll_container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 4px;
        }

        .book_scroll_container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .book {
            width: 180px;
            flex-shrink: 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
            overflow: hidden;
        }

        .book-cover-container {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
        }

        .book-cover-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }

        .book-author {
            font-size: 14px;
            color: #777;
        }

        .tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 5px;
            border-radius: 5px;
            font-size: 14px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #343a40;
            color: #fff;
            padding: 10px 20px;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
        }

        .dropdown-toggle::after {
            margin-left: 8px;
        }

        .dropdown-menu {
            z-index: 1050; /* Ensures dropdown appears on top of other elements */
        }

        .container.mt-5 {
            margin: 0 !important;
        }

        /* Hide sidebar on small screens and make it collapsible */
        @media (max-width: 767px) {
            .nav-container {
                display: none;
            }
            .nav-container.show {
                display: block;
            }
            .hamburger-menu {
                display: block;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="header-title">Ravenbooks</div>
        <div>
            <?php if (!isset($_SESSION['username'])): ?>
                <!-- Login Button if no session -->
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php else: ?>
                <!-- User Icon with Modal Trigger -->
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#userInfoModal">
                    <i class="fas fa-user-circle"></i> <!-- Font Awesome Icon -->
                </button>
            <?php endif; ?>
        </div>
    </header>

    <!-- Modal for User Info -->
    <div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                    <p><strong>Email:</strong> user@example.com</p>
                    <p><strong>Liked Books:</strong> 25</p>
                    <p><strong>Wishlist Items:</strong> 8</p>
                </div>
                <div class="modal-footer">
                    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar and Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar for larger screens -->
            <div class="col-md-3 col-lg-2 nav-container">
                <h4>Navigation</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-book-atlas"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="search.html" class="nav-link"><i class="fa-solid fa-house"></i> Browse</a>
                    </li>
                </ul>
            </div>

            <!-- Toggle Button for Mobile -->
            <button class="btn btn-primary hamburger-menu" onclick="toggleSidebar()">☰</button>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Tab Content (Search, Discover, Filter) goes here -->
            </div>
        </div>
    </div>

    <!-- Script for Toggling Sidebar -->
    <script>
        function toggleSidebar() {
            document.querySelector('.nav-container').classList.toggle('show');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>
