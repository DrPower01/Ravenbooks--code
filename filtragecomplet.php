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