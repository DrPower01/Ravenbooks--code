<?php
// Database connection details
$host = "localhost";
$dbname = "library";
$username = "root";
$password = "nigga";

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// PMB API endpoint
$pmb_url = "https://ifdjibouti.bibli.fr/ws/connector_out.php?source_id=3"; // Replace with your PMB connector URL

// Pagination setup
$page = 1;
$pageSize = 50; // Number of books to fetch per request

do {
    // JSON-RPC request payload for fetching books
    $request = [
        "jsonrpc" => "2.0",
        "method" => "pmbesSearch_simpleSearch",
        "params" => [
            "searchType" => "title",
            "searchTerm" => "", // Empty term to fetch all books
            "page" => $page,
            "pageSize" => $pageSize,
        ],
        "id" => 1
    ];

    // Send the JSON-RPC request
    $ch = curl_init($pmb_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the API response
    $result = json_decode($response, true);

    if (isset($result['result']) && is_array($result['result'])) {
        $books = $result['result'];

        // Loop through each book and store it in the database
        foreach ($books as $book) {
            $sql = "INSERT INTO books (title, author, publisher, isbn, cover_image)
                    VALUES (:title, :author, :publisher, :isbn, :cover_image";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':title' => htmlspecialchars($book['title']),
                ':author' => htmlspecialchars($book['author']),
                ':publisher' => htmlspecialchars($book['publisher']),
                ':isbn' => htmlspecialchars($book['isbn']),
                ':cover_image' => htmlspecialchars($book['cover_image']),
                ':description' => htmlspecialchars($book['description']),
            ]);
        }

        echo "Stored " . count($books) . " books from page $page.\n";
    } elseif (isset($result['error'])) {
        echo "Error: " . $result['error']['message'] . "\n";
        break;
    } else {
        break;
    }

    $page++; // Increment the page number
} while (!empty($books));

echo "All books have been stored successfully!";
?>
