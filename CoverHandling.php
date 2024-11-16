<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Book Details</title>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body>
    <div class="main-content">
        <div class="book-detail-container">
            <div class="book-detail-header">
                <h1><?php echo htmlspecialchars($book['title']); ?></h1>
            </div>
            <div class="book-detail-body">
                <div class="book-detail-image">
                    <?php
                    // Define the default cover image URL
                    $default_cover_url = 'path/to/your/default-cover.jpg';

                    // Check if cover_url is null or empty
                    $cover_url = !empty($book['cover_url']) ? htmlspecialchars($book['cover_url']) : $default_cover_url;
                    ?>
                    <img src="<?php echo $cover_url; ?>" alt="Book cover">
                </div>
                <div class="book-detail-info">
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['authors']); ?></p>
                    <p><strong>Publisher:</strong> <?php echo htmlspecialchars($book['publisher']); ?></p>
                    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($book['description']); ?></p>
                    <p><strong>Localisation:</strong> <?php echo htmlspecialchars($book['Faculte']); ?></p>
                </div>
            </div>
            <div class="back-button">
                <a href="Home.php" class="btn">Back to Book List</a>
            </div>
        </div>
    </div>
</body>
</html>
