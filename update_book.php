<?php
// Connexion à la base de données
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // ID du livre
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $publisher = $_POST['publisher'];
    $publishedDate = $_POST['publishedDate'];
    $description = $_POST['description'];
    $pageCount = $_POST['pageCount'];
    $categories = $_POST['categories'];
    $language = $_POST['language'];
    $isbn = $_POST['isbn'];
    $shelf = $_POST['shelf'];
    $faculte = $_POST['faculte'];

    $query = "UPDATE books SET 
                title = ?, authors = ?, publisher = ?, publishedDate = ?, 
                description = ?, pageCount = ?, categories = ?, 
                language = ?, isbn = ?, shelf = ?, faculte = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssssssssi', $title, $authors, $publisher, $publishedDate, $description, $pageCount, $categories, $language, $isbn, $shelf, $faculte, $id);

    if ($stmt->execute()) {
        echo "Mise à jour réussie";
    } else {
        http_response_code(500);
        echo "Erreur lors de la mise à jour";
    }

    $stmt->close();
    $conn->close();
}
?>
