<?php
// Connect to the database
$mysqli = new mysqli("localhost", "root", "", "library");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Number of books per page, default is 25
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 25;

// Current page number, default is 1
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Search functionality and alphabet filter
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$alphabet_filter = isset($_GET['alpha']) ? $_GET['alpha'] : '';

// Modify SQL query if an alphabet filter is selected
$where_clause = "WHERE title LIKE '%$search_query%'";
if (!empty($alphabet_filter)) {
    $where_clause = "WHERE title LIKE '$alphabet_filter%'";
}

// Get total books count
$count_sql = "SELECT COUNT(id) AS total FROM Books $where_clause";
$result = $mysqli->query($count_sql);
$total_books = $result->fetch_assoc()['total'];

// Fetch books for the current page, search term, and alphabet filter
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
    <title>Book List</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        list-style: none;
        font-family: "Times New Roman", sans-serif;
    }
    .nav {
        width: 800px;
        background: white;
        display: flex;
    }
    .left {
        width: 250px;
        padding: 0 20px;
    }
    .left .img_holder {
        text-align: center;
        padding: 20px 0;
        margin-top: 20px;
        border: 2px solid rgb(243, 243, 243);
        border-radius: 15px;
        background-color: #f9f9f9;
        padding: 10px;
    }
    .left .img_holder img {
        width: 130px;
        border-radius: 30px;
    }
    .menu .li_wrap {
        display: flex;
        align-items: center;
        width: 100%;
        margin-bottom: 15px;
        transition: background-color 0.3s;
    }
    .menu .li_wrap:hover .icon {
        background-color: rgb(255, 88, 46);
        color: white;
    }
    .menu .li_wrap:hover .text {
        font-weight: bold;
        color: rgb(27, 25, 25);
    }
    .right {
        width: calc(100% - 250px);
    }
    .search-container {
        width: 100%;
        max-width: 800px;
        margin-left: 40px;
        padding: 20px;
    }
    .search-bar {
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 7px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
        margin-bottom: 20px;
    }
    .search-input {
        flex-grow: 2;
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
    }
    .search-button {
        padding: 10px 20px;
        border: none;
        background-color: #333;
        color: white;
        font-size: 14px;
        border-radius: 4px;
        margin-left: 10px;
        cursor: pointer;
    }
    .search-button:active {
        background-color: rgb(236, 236, 236);
        color: black;
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
    .pagination, .items-per-page, .alphabet-pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .pagination a, .items-per-page a, .alphabet-pagination a {
        margin: 5px;
        padding: 8px 12px;
        background-color: #333;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }
    .pagination a.active, .alphabet-pagination a.active {
        background-color: rgb(27, 25, 25);
    }
    .pagination a:hover, .items-per-page a:hover, .alphabet-pagination a:hover {
        background-color: rgb(255, 88, 46);
    }
    </style>
</head>
<body>
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search for books..." autocomplete="off">
        <button class="search-button">Search</button>
    </div>

    <h2>Book List</h2>
    <div class="alphabet-pagination">
        <?php foreach (range('A', 'Z') as $letter): ?>
            <a href="?alpha=<?php echo $letter; ?>&limit=<?php echo $limit; ?>&page=1" 
               class="<?php echo ($letter == $alphabet_filter) ? 'active' : ''; ?>">
               <?php echo $letter; ?>
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
                        <p><strong>Lieux</strong> <?php echo htmlspecialchars($book['Faculte']); ?></p>
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
            <a href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($search_query); ?>&alpha=<?php echo htmlspecialchars($alphabet_filter); ?>" 
               class="<?php echo ($i == $page) ? 'active' : ''; ?>">
               <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <div class="items-per-page">
        <label for="a">Books per page:</label>
        <a href="?limit=25&page=1&search=<?php echo htmlspecialchars($search_query); ?>&alpha=<?php echo htmlspecialchars($alphabet_filter); ?>">25</a>
        <a href="?limit=50&page=1&search=<?php echo htmlspecialchars($search_query); ?>&alpha=<?php echo htmlspecialchars($alphabet_filter); ?>">50</a>
        <a href="?limit=75&page=1&search=<?php echo htmlspecialchars($search_query); ?>&alpha=<?php echo htmlspecialchars($alphabet_filter); ?>">75</a>
        <a href="?limit=100&page=1&search=<?php echo htmlspecialchars($search_query); ?>&alpha=<?php echo htmlspecialchars($alphabet_filter); ?>">100</a>
    </div>
</body>
</html>
