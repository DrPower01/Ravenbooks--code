<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the book ID from the URL
$book_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($book_id > 0) {
    // Query to get book details
    $sql = "SELECT * FROM Books WHERE id = " . intval($book_id);
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch book data
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit;
    }
} else {
    echo "Invalid book ID.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<style>
    /* General Body Styling */
/* General Body Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Main Content */
.main-content {
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

/* Book Detail Container */
.book-detail-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
}

/* Book Detail Header */
.book-detail-header {
    text-align: center;
    margin-bottom: 20px;
}

.book-detail-header h1 {
    font-size: 36px;
    color: #333;
    margin: 0;
}

/* Book Detail Body */
.book-detail-body {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start; /* Change this from space-between */
    gap: 20px; /* Add gap for spacing between image and text */
}

/* Book Image */
.book-detail-image img {
    width: 100%;
    max-width: 300px; /* Adjusted width */
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Book Information */
.book-detail-info {
    flex: 1;
    max-width: 600px;
    padding: 20px;
    margin-left: 10px; /* Reduced space between text and image */
}

.book-detail-info p {
    font-size: 18px;
    color: #555;
    margin-bottom: 10px;
}

.book-detail-info strong {
    color: #333;
}

/* Back Button */
.back-button {
    text-align: center;
    margin-top: 30px;
}

.back-button .btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    font-size: 18px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.back-button .btn:hover {
    background-color: #45a049;
}

</style>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Book Details</title>
</head>
<body>
    <div class="main-content">
        <div class="book-detail-container">
            <div class="book-detail-header">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
            </div>
            <div class="book-detail-body">
                <div class="book-detail-image">
                    <img src="<?php echo htmlspecialchars($book['cover_url']); ?>" alt="Book cover">
                </div>
                <div class="book-detail-info">
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['authors']); ?></p>
                    <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>
                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
                    <p><strong>Localisation:</strong> <?php echo htmlspecialchars($book['Faculte']); ?></p> <!-- Optional -->
                </div>
            </div>
            <div class="back-button">
                <a href="Home.php" class="btn">Back to Book List</a>
            </div>
        </div>
    </div>
</body>
</html>
