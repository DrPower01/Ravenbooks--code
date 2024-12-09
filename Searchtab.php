<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
</body>
</html>