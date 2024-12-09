<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <script src="https://kit.fontawesome.com/02a370eee2.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            background: linear-gradient(to bottom, #f0f4f8, #d9e8ff);
        }

        header {
            background: linear-gradient(to right, #3a6186, #89253e);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        header h1 {
            font-size: 3.8rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        header p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            display: inline-block;
            text-decoration: none;
            background: #ff6f61;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 30px;
            font-size: 1.1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #ff4a36;
            transform: translateY(-2px);
        }

        .search-bar {
            margin-top: 4rem;
            text-align: center;
        }

        .search-bar input {
            padding: 1rem;
            width: 70%;
            max-width: 500px;
            border: 2px solid #ff6f61;
            border-radius: 50px;
            font-size: 1rem;
        }

        .search-bar button {
            padding: 1rem 2rem;
            background: #ff6f61;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            cursor: pointer;
            margin-left: -50px;
        }

        .search-bar button:hover {
            background: #bb1264;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem auto;
            max-width: 1200px;
            padding: 0 2rem;
        }

        .feature-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            text-align: center;
            transition: transform 0.4s;
        }

        .feature-box:hover {
            transform: translateY(-15px);
        }

        .feature-box img {
            width: 100px;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .feature-box h3 {
            margin-bottom: 1rem;
            color: #3a6186;
            font-size: 1.5rem;
        }

        .feature-box p {
            color: #666;
            line-height: 1.5;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 3rem;
        }

        footer a {
            color: #ff6f61;
            text-decoration: none;
        }

        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        nav ul {
            display: flex;
            list-style: none;
            justify-content: center;
        }

        nav ul li {
            margin: 0 1rem;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #3a6186;
        }

        /* Dropdown menu styles */
        .drop-down {
            position: absolute;
            top: 100%; /* Position juste en dessous du lien parent */
            left: 0;
            padding: 0.5rem 0;
            margin: 0;
            background: linear-gradient(to right, #dce1e6, #fce7e7);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            font-size: 12px;
            list-style: none;
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .drop-down li {
            padding: 0.5rem 1rem;
            white-space: nowrap;
        }

        .drop-down li i {
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        .drop-down li:hover {
            background: black;
            color: #fff;
            border-radius: 0.5rem;
        }

        /* Show dropdown on hover */
        .lieu:hover .drop-down {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .lieu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .lieu .dropdown-icon {
            margin-left: 0.5rem;
            font-size: 14px;
            transform: rotate(0deg);
            transition: transform 0.3s ease-in-out;
        }

        .lieu:hover .dropdown-icon {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="gr1.html">Home</a></li>
            <li><a href="features.html">Catalog</a></li>
            <li class="lieu">
                <a href="#">Lieu
                    <span class="material-icons dropdown-icon">
                        <i class="fa-solid fa-caret-down"></i>
                    </span>
                </a>
                <ul class="drop-down">
                    <li><i class="fa-solid fa-graduation-cap"></i> Université de Balbal</li>
                    <li><i class="fa-brands fa-squarespace"></i> Institut Nationale</li>
                    <li><i class="fa-solid fa-building-columns"></i> Archives Nationales</li>
                </ul>
            </li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>

    <header>
        <h1>Explore Infinite Knowledge</h1>
        <p>Your gateway to a world of books, stories, and learning.</p>
        <a href="features.html" class="btn-primary">Discover Now</a>
    </header>

    <section class="search-bar">
        <input type="text" placeholder="Search for books, genres, or authors...">
        <button>Search</button>
    </section>

    <section class="features" id="features">
        <div class="feature-box">
            <img src="i2.jpg" alt="Books">
            <h3>Extensive Library</h3>
            <p>Discover thousands of books across genres and languages.</p>
        </div>
        <div class="feature-box">
            <img src="i2.jpg" alt="Access">
            <h3>Seamless Access</h3>
            <p>Read your favorite books anytime, anywhere, on any device.</p>
        </div>
        <div class="feature-box">
            <img src="i2.jpg" alt="Community">
            <h3>Engage with Community</h3>
            <p>Join discussions, write reviews, and connect with book lovers.</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Online Library. All rights reserved. | <a href="#">Privacy Policy</a></p>
    </footer>

</body>
</html>