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

// Function to fetch book cover from Open Library API
function fetchBookCoverFromOpenLibrary($isbn) {
    // Open Library API URL for fetching book data
    $url = "https://openlibrary.org/api/books?bibkeys=ISBN:" . urlencode($isbn) . "&format=json&jscmd=data";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null; // In case of an error, return null
    }

    $data = json_decode($response, true);
    $key = "ISBN:" . urlencode($isbn);

    if (isset($data[$key]['cover']['large'])) {
        return $data[$key]['cover']['large']; // Return the large cover URL
    }
    return null; // Return null if no cover is found
}

// Query to select books that need updating (i.e., where cover_url is null or empty)
$sql = "SELECT id, isbn, cover_url FROM Books WHERE cover_url IS NULL OR cover_url = ''";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each book that needs a cover update
    while ($row = $result->fetch_assoc()) {
        $book_id = $row['id'];
        $isbn = $row['isbn'];

        // Fetch the cover URL from the Open Library API
        $cover_url = fetchBookCoverFromOpenLibrary($isbn);

        if ($cover_url) {
            // Update the cover_url in the database
            $updateSql = "UPDATE Books SET cover_url = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("si", $cover_url, $book_id);

            if ($stmt->execute()) {
                echo "Updated cover for book ID: $book_id<br>";
            } else {
                echo "Failed to update cover for book ID: $book_id<br>";
            }

            $stmt->close();
        } else {
            echo "No cover found for ISBN: $isbn (Book ID: $book_id)<br>";
        }
    }
} else {
    echo "No books need updating.<br>";
}

$conn->close();
?>
