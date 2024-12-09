<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your wishlist.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "nigga";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID
$user_id = intval($_SESSION['user_id']);

// Query to fetch wishlist items for the logged-in user
$sql = "SELECT b.id, b.title, b.authors, b.cover_url 
        FROM wishlists w 
        JOIN books b ON w.book_id = b.id 
        WHERE w.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlistBooks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlistBooks[] = $row;
    }
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist</title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .wishlist-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .wishlist-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .wishlist-header h1 {
            font-size: 36px;
            color: #333;
            margin: 0;
        }

        .wishlist-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .wishlist-item {
            flex: 1 1 calc(20% - 20px); /* Adjust width for responsive layout */
            max-width: calc(20% - 20px);
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wishlist-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .wishlist-item img {
            width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .wishlist-item a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
            font-size: 16px;
            font-weight: bold;
        }

        .wishlist-item a:hover {
            color: #007BFF;
        }

        .no-wishlist {
            text-align: center;
            font-size: 18px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1>Your Wishlist</h1>
        </div>
        <?php if (!empty($wishlistBooks)): ?>
            <ul class="wishlist-list">
                <?php foreach ($wishlistBooks as $book): ?>
                    <li class="wishlist-item">
                        <a href="book_details.php?id=<?php echo $book['id']; ?>">
                            <img src="<?php echo htmlspecialchars($book['cover_url']); ?>" alt="Book cover">
                            <?php echo htmlspecialchars($book['title']); ?><br>
                            <small><?php echo htmlspecialchars($book['authors']); ?></small>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-wishlist">Your wishlist is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
