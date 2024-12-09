<?php
// Connect to the database
$mysqli = new mysqli("localhost", "root", "nigga", "library");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Number of books per page, default is 25
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 25;

// Current page number, default is 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// categories filter
$categories_filter = isset($_GET['categories']) ? $_GET['categories'] : '';

// Fetch categoriess from the database
$categoriess_sql = "SELECT DISTINCT categories FROM Books ORDER BY categories ASC";
$categoriess_result = $mysqli->query($categoriess_sql);
$categoriess = [];
while ($row = $categoriess_result->fetch_assoc()) {
    $categoriess[] = $row['categories'];
}

// Modify SQL query for filters
$where_clause = "WHERE title LIKE '%" . $mysqli->real_escape_string($search_query) . "%'";
if (!empty($categories_filter)) {
    $where_clause .= " AND categories = '" . $mysqli->real_escape_string($categories_filter) . "'";
}

// Get total books count
$count_sql = "SELECT COUNT(id) AS total FROM Books $where_clause";
$result = $mysqli->query($count_sql);
$total_books = $result->fetch_assoc()['total'];

// Fetch books for the current page
$sql = "SELECT * FROM Books $where_clause LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);

// Store books in an array
$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

// Pagination logic
$total_pages = ceil($total_books / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Recherche par Genre</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Times New Roman", sans-serif;
        }

        .book-item {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .book-title {
            font-size: 22px;
            cursor: pointer;
            font-weight: normal;
            color: #333;
        }
        .book-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .book-cover {
            margin-bottom: 15px;
        }
        .responsive-cover {
            width: 100%;
            max-width: 350px;
            height: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }
        .book-details {
            text-align: left;
            color: #525151;
            margin-top: 10px;
        }
        .pagination, .items-per-page, .categories-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .pagination a, .items-per-page a, .categories-pagination a {
            margin: 5px;
            padding: 8px 12px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .pagination a.active, .categories-pagination a.active {
            background-color: rgb(27, 25, 25);
        }
        .pagination a:hover, .items-per-page a:hover, .categories-pagination a:hover {
            background-color: rgb(255, 88, 46);
        }
    </style>
</head>
<body>

    <h1 class="text-center mb-4">Bibliothèque - Recherche par Genre</h1>
    <div class="categories-pagination">
        <a href="?limit=<?php echo $limit; ?>&page=1" class="<?php echo (empty($categories_filter)) ? 'active' : ''; ?>">All</a>
        <?php foreach ($categoriess as $categories): ?>
            <a href="?categories=<?php echo urlencode($categories); ?>&limit=<?php echo $limit; ?>&page=1" 
               class="<?php echo ($categories == $categories_filter) ? 'active' : ''; ?>">
               <?php echo htmlspecialchars($categories); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if (count($books) > 0): ?>
        <?php foreach ($books as $book): ?>
            <details class="book-item">
                <summary class="book-title"><?php echo htmlspecialchars($book['title']); ?></summary>
                <div class="book-content">
                    <?php if (!empty($book['cover_url'])): ?>
                        <div class="book-cover">
                            <img src="<?php echo htmlspecialchars($book['cover_url']); ?>" alt="Book Cover" class="responsive-cover">
                        </div>
                    <?php else: ?>
                        <p>No cover available</p>
                    <?php endif; ?>
                    <div class="book-details">
                        <p><strong>Authors:</strong> <?php echo htmlspecialchars($book['authors']); ?></p>
                        <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>
                        <p><strong>Published Date:</strong> <?php echo htmlspecialchars($book['publishedDate']); ?></p>
                        <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                        <p><strong>categories:</strong> <?php echo htmlspecialchars($book['categories']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
                    </div>
                </div>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($search_query); ?>&categories=<?php echo htmlspecialchars($categories_filter); ?>" 
               class="<?php echo ($i == $page) ? 'active' : ''; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <div class="items-per-page">
        <label for="a">Books per page:</label>
        <a href="?limit=25&page=1&search=<?php echo htmlspecialchars($search_query); ?>&categories=<?php echo htmlspecialchars($categories_filter); ?>">25</a>
        <a href="?limit=50&page=1&search=<?php echo htmlspecialchars($search_query); ?>&categories=<?php echo htmlspecialchars($categories_filter); ?>">50</a>
        <a href="?limit=75&page=1&search=<?php echo htmlspecialchars($search_query); ?>&categories=<?php echo htmlspecialchars($categories_filter); ?>">75</a>
        <a href="?limit=100&page=1&search=<?php echo htmlspecialchars($search_query); ?>&categories=<?php echo htmlspecialchars($categories_filter); ?>">100</a>
    </div>
</body>
</html>
