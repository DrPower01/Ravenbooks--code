<?php
// Database connection (ensure this matches your database setup)
$servername = "localhost";
$username = "root";
$password = "nigga";
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
// Start the session
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Website with Sidebar</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper">
      <div class="sidebar-heading text-center py-4">RavenBooks</div>
      <div>
            <?php if (!isset($_SESSION['username'])): ?>
                <!-- Login Button if no session -->
                <a href="login.php" class="btn btn-primary">Login</a>
            <?php else: ?>
                <!-- User Icon with Modal Trigger -->
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#userInfoModal">
                    <i class="fas fa-user-circle"></i> <!-- Font Awesome Icon -->
                </button>
            <?php endif; ?>
        </div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-home"></i> <span class="d-none d-md-inline">Home</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-info-circle"></i> <span class="d-none d-md-inline">About</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-cogs"></i> <span class="d-none d-md-inline">Services</span>
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
          <i class="fas fa-phone-alt"></i> <span class="d-none d-md-inline">Contact</span>
        </a>
      </div>
    </div>
    <!-- Modal for User Info -->
    <div class="modal fade" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                    <p><strong>Email:</strong> user@example.com</p>
                    <p><strong>Liked Books:</strong> 25</p>
                    <p><strong>Wishlist Items:</strong> 8</p>
                </div>
                <div class="modal-footer">
                    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="btn btn-primary" id="menu-toggle">Toggle Sidebar</button>
      </nav>
    
      <!-- Tab Content -->
<div class="col-md-9 col-lg-10">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="true">
                Search
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="discover-tab" data-bs-toggle="tab" data-bs-target="#discover" type="button" role="tab" aria-controls="discover" aria-selected="false">
                Discover
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="filter-tab" data-bs-toggle="tab" data-bs-target="#filter" type="button" role="tab" aria-controls="filter" aria-selected="false">
                Filter
            </button>
        </li>
    </ul>
    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="search" role="tabpanel" aria-labelledby="search-tab">
            <?php include('Searchtab.php'); ?>
        </div>
        <div class="tab-pane fade" id="discover" role="tabpanel" aria-labelledby="discover-tab">
            <?php include('HomePart2.php'); ?>
        </div>
        <div class="tab-pane fade" id="filter" role="tabpanel" aria-labelledby="filter-tab">
            <!-- Nested Filter Tabs -->
            <ul class="nav nav-tabs" id="filterTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="filterOption1-tab" data-bs-toggle="tab" data-bs-target="#filterOption1" type="button" role="tab" aria-controls="filterOption1" aria-selected="true">
                        Alphabet
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="filterOption2-tab" data-bs-toggle="tab" data-bs-target="#filterOption2" type="button" role="tab" aria-controls="filterOption2" aria-selected="false">
                        Genre
                    </button>
                </li>
            </ul>
            <!-- Nested Tab Content -->
            <div class="tab-content" id="filterTabsContent">
                <div class="tab-pane fade show active" id="filterOption1" role="tabpanel" aria-labelledby="filterOption1-tab">
                    <?php include('testsaid.php'); ?>
                </div>
                <div class="tab-pane fade" id="filterOption2" role="tabpanel" aria-labelledby="filterOption2-tab">
                    <?php include('BrowseGenre.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Get the current active main tab and filter tab from localStorage, if available
    const activeTab = localStorage.getItem('activeTab');
    const activeFilterTab = localStorage.getItem('activeFilterTab');

    // Activate the main tab if it's stored in localStorage
    if (activeTab) {
        const mainTab = new bootstrap.Tab(document.querySelector(`#${activeTab}-tab`));
        mainTab.show();
    }

    // Activate the nested filter tab if it's stored in localStorage
    if (activeFilterTab) {
        const nestedTab = new bootstrap.Tab(document.querySelector(`#${activeFilterTab}-tab`));
        nestedTab.show();
    }

    // When any main tab is clicked, save its ID to localStorage
    document.querySelectorAll('.nav-link').forEach(tabButton => {
        tabButton.addEventListener('click', function () {
            const tabId = this.id.replace('-tab', ''); // Get main tab id (e.g., 'search')
            localStorage.setItem('activeTab', tabId); // Store the active main tab id
        });
    });

    // When any nested filter tab is clicked, save its ID to localStorage
    document.querySelectorAll('#filterTabs .nav-link').forEach(tabButton => {
        tabButton.addEventListener('click', function () {
            const tabId = this.id.replace('-tab', ''); // Get nested filter tab id (e.g., 'filterOption1')
            localStorage.setItem('activeFilterTab', tabId); // Store the active filter tab id
        });
    });
});


</script>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  <script>
    // Toggle the sidebar visibility
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar-wrapper');

    menuToggle.addEventListener('click', function() {
      sidebar.classList.toggle('toggled');
    });
  </script>

  <style>
    /* Sidebar styling */
    #wrapper {
      display: flex;
      height: 100vh;
      overflow-x: hidden;
    }
    #sidebar-wrapper {
    width: 250px;
    height: 100vh; /* Ensure the sidebar fills the entire height */
    position: fixed; /* Keep the sidebar fixed */
    top: 0;
    left: 0;
    transition: all 0.3s ease;
    overflow-y: auto; /* Allow scrolling if content overflows */
    }
    #sidebar-wrapper.toggled {
    width: 60px; /* Sidebar width when toggled */
    }
    .sidebar-heading {
      font-size: 1.5rem;
    }
    
    #page-content-wrapper {
    margin-left: 250px; /* Adjust the page content to not be hidden behind the sidebar */
    width: 100%;
    padding: 20px;
    }
    #page-content-wrapper.toggled {
    margin-left: 60px; /* Adjust the content when the sidebar is toggled */
    }

    /* Sidebar item icons only when toggled */
    #sidebar-wrapper.toggled .list-group-item span {
    display: none; /* Hide the text when sidebar is toggled */
    }

    #sidebar-wrapper.toggled .list-group-item i {
    margin-right: 0; /* Adjust icon position */
    }
    /* Sidebar item icons only when toggled */
    #sidebar-wrapper.toggled .list-group-item span {
      display: none; /* Hide the text when sidebar is toggled */
    }
    #sidebar-wrapper.toggled .list-group-item i {
      margin-right: 0; /* Adjust icon position */
    }
  </style>

</body>
</html>
