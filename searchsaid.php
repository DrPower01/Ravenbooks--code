<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "nigga";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupérer la requête de recherche
$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

if (!empty($query)) {
    $sql = "SELECT id, title FROM Books WHERE title LIKE '%$query%' LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li><a href='book_details.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></li>";
        }
    } else {
        echo "<li>Aucun résultat trouvé.</li>";
    }
} else {
    echo "<li>Veuillez entrer un terme de recherche.</li>";
}

$conn->close();
?>
