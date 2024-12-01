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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ravenbooks</title>
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


    </style>
</head>
<body>

    <!-- Header -->
    
    <header class="header">
        <div class="header-title">Ravenbooks</div>
        <div>
            <?php if (!isset($_SESSION['user_name'])): ?>
                <!-- Login Button if no session -->
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php else: ?>
                <!-- Dropdown Menu if session exists -->
                <div class="dropdown">
                    <button
                        class="btn btn-primary dropdown-toggle"
                        type="button"
                        id="userMenu"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?= htmlspecialchars($_SESSION['user_name']) ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-thumbs-up like-icon"></i> Liked Books</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-heart"></i> Wishlist</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>

            <?php endif; ?>
    </header>
    
    </header>

    <div class="container mt-5">
        <div class="row">
            <!-- Left Navigation -->
            <div class="col-md-3 col-lg-2 nav-container">
                <h4>Navigation</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fa-solid fa-book-atlas"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="search.html" class="nav-link"><i class="fa-solid fa-house"></i> Browse</a>
                    </li>
                    <!-- Dropdown for Université de Balballa -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="balballaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-graduation-cap"></i> Université de Balballa
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="balballaDropdown">
                            <li><a class="dropdown-item" href="#">Balballa Library 1</a></li>
                            <li><a class="dropdown-item" href="#">Balballa Library 2</a></li>
                        </ul>
                    </li>
                    <!-- Dropdown for Libraries -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="librariesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-landmark"></i> Libraries
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="librariesDropdown">
                            <li><a class="dropdown-item" href="#">Institut Français</a></li>
                            <li><a class="dropdown-item" href="#">American Corn</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div class="col-md-9 col-lg-10">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="true">
                            Search
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="discover-tab" data-bs-toggle="tab" data-bs-target="#discover" type="button" role="tab" aria-controls="discover" aria-selected="false">
                            Discover
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="filter-tab" data-bs-toggle="tab" data-bs-target="#filter" type="button" role="tab" aria-controls="filter" aria-selected="false">
                            Filter
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="myTabContent">
                    <!-- Search Tab -->
                    <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
                    <style>
                        .search-container {
                            max-width: 600px;
                            margin: 50px auto;
                            position: relative;
                        }

                        .search-results {
                            position: absolute;
                            top: 100%;
                            left: 0;
                            width: 100%;
                            background-color: #fff;
                            border: 1px solid #ddd;
                            border-radius: 0.375rem;
                            max-height: 300px;
                            overflow-y: auto;
                            z-index: 1000;
                        }

                        .search-results li {
                            display: flex;
                            align-items: center;
                            padding: 10px;
                            border-bottom: 1px solid #f0f0f0;
                            cursor: pointer;
                        }

                        .search-results li img {
                            width: 50px;
                            height: 50px;
                            margin-right: 10px;
                            border-radius: 0.375rem;
                            object-fit: cover;
                        }

                        .search-results li:hover {
                            background-color: #f8f9fa;
                        }

                        .search-results li:last-child {
                            border-bottom: none;
                        }

                        .no-results {
                            padding: 10px;
                            color: #6c757d;
                            text-align: center;
                        }
                    </style>
                <body>
                    <div class="container">
                        <div class="search-container">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search books by title, author, or ISBN..."
                                id="searchBox"
                            />
                            <ul class="list-group search-results" id="searchResults"></ul>
                        </div>
                    </div>

                    <!-- Bootstrap JS and dependencies -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

                    <script>
                        document.getElementById('searchBox').addEventListener('input', function () {
                            const query = this.value.trim();
                            const resultsContainer = document.getElementById('searchResults');

                            // Clear previous results if query is empty
                            if (query === '') {
                                resultsContainer.innerHTML = '';
                                return;
                            }

                            // Perform AJAX request
                            fetch(`search.php?query=${encodeURIComponent(query)}`)
                                .then((response) => response.json())
                                .then((data) => {
                                    resultsContainer.innerHTML = '';

                                    if (data.length === 0) {
                                        resultsContainer.innerHTML =
                                            '<li class="list-group-item no-results">No books found</li>';
                                        return;
                                    }

                                    // Populate results
                                    data.forEach((book) => {
                                        const li = document.createElement('li');
                                        li.className = 'list-group-item d-flex align-items-center';
                                        li.innerHTML = `
                                            <img src="${book.cover_url}" alt="${book.title}">
                                            <div>
                                                <strong>${book.title}</strong><br>
                                                <span class="text-muted">${book.authors}</span>
                                            </div>
                                        `;
                                        li.addEventListener('click', () => {
                                            window.location.href = `book_details.php?id=${book.id}`;
                                        });
                                        resultsContainer.appendChild(li);
                                    });
                                })
                                .catch((error) => {
                                    console.error('Error fetching data:', error);
                                });
                        });
                    </script>
                    </div>

                    <!-- Discover Tab -->
                    <div class="tab-pane fade" id="discover" role="tabpanel" aria-labelledby="discover-tab">
                    <style>
                        .book_scroll_container {
                            display: flex;
                            overflow-x: scroll;
                            padding: 10px;
                            gap: 15px;
                        }

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

                        .nav-container {
                            height: 100vh;
                            background-color: #f8f9fa;
                            padding: 20px;
                        }

                        .books-container {
                            height: 100vh;
                            overflow-y: auto;
                            padding: 20px;
                        }

                    </style>
                    <p>Most viewed:</p>
                        <div class="book_scroll_container">
                                <?php
                                // Recommended books query
                                $sql1 = "SELECT Books.id, Books.title, Books.authors, Books.publisher, Books.cover_url, Books.description, Books.Faculte, COUNT(views) AS view_count
                                            FROM Books
                                            ORDER BY view_count DESC
                                            LIMIT 10";
                                $result1 = $conn->query($sql1);

                                if ($result1->num_rows > 0) {
                                    while ($row = $result1->fetch_assoc()) {
                                        echo '<div class="book">';
                                        echo '<a href="book_details.php?id=' . htmlspecialchars($row["id"]) . '" class="book-link">';
                                        echo '<div class="book-cover-container">';
                                        if (!empty($row["cover_url"])) {
                                            echo '<img src="' . htmlspecialchars($row["cover_url"]) . '" alt="Book cover" onerror="this.onerror=null; this.src=\'placeholder_icon.png\';" loading="lazy">';
                                        } else {
                                            echo '<img src="placeholder_icon.png" alt="No cover available">';
                                        }
                                        echo '<div class="tag">' . htmlspecialchars($row["Faculte"]) . '</div>';
                                        echo '</div>';
                                        echo '<div class="book-title">' . htmlspecialchars($row["title"]) . '</div>';
                                        echo '<div class="book-author">by ' . htmlspecialchars($row["authors"]) . '</div>';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No recommended books found.</p>';
                                }
                                ?>
                            </div><br><br>
                                <p>Lastest:</p>
                            <div class="book_scroll_container">
                                <?php
                                // Newest books query
                                $sql2 = "SELECT * FROM Books ORDER BY id DESC LIMIT 10";
                                $result2 = $conn->query($sql2);

                                if ($result2->num_rows > 0) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo '<div class="book">';
                                        echo '<a href="book_details.php?id=' . htmlspecialchars($row["id"]) . '" class="book-link">';
                                        echo '<div class="book-cover-container">';
                                        if (!empty($row["cover_url"])) {
                                            echo '<img src="' . htmlspecialchars($row["cover_url"]) . '" alt="Book cover" onerror="this.onerror=null; this.src=\'placeholder_icon.png\';">';
                                        } else {
                                            echo '<img src="placeholder_icon.png" alt="No cover available">';
                                        }
                                        echo '<div class="tag">' . htmlspecialchars($row["Faculte"]) . '</div>';
                                        echo '</div>';
                                        echo '<div class="book-title">' . htmlspecialchars($row["title"]) . '</div>';
                                        echo '<div class="book-author">by ' . htmlspecialchars($row["authors"]) . '</div>';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No newest books found.</p>';
                                }
                                ?></div>
                            </div>
                    </div>

                    <!-- Filter Tab -->
                    <div class="tab-pane fade" id="filter" role="tabpanel" aria-labelledby="filter-tab">
                        <!-- Your Filter Tab Content Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>