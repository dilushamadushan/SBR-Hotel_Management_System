<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBR | Hotel Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src = "../assets/js/header.js"></script>
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg p-3 fixed-top">
            <div class="container">
                <a class="navbar logo fw-semibold fs-3" href="../index.php">Secret<span>Berry.</span></a>
                <div class="justify-content-center">
                    <ul class="navbar-nav" id="menuList">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../pages/about-us.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../pages/service.php">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../pages/event.php">Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../pages/blog.php">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold text-dark" href="../pages/contact.php">Contact</a>
                        </li>
                    </ul>
                </div>
                <a href="../pages/login.php" class="btn btn-primary fw-semibold loginBtn">Log In</a>
                <div class="menuIcon d-lg-none">
                        <i class="fa-solid fa-bars fs-3" onclick="toggleMenu()"></i>
                </div>
            </div>
            <div class = "hideMenu">
                <div id="mobileMenu" class="d-lg-none mobile-menu">
                    <ul class="navbar-nav flex-column text-center">
                        <li class="nav-item"><a class="nav-link fw-semibold" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="../pages/about-us.php">About</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="#">Event</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="../pages/blog.php">Blogs</a></li>
                        <li class="nav-item"><a class="nav-link fw-semibold" href="../pages/contact.php">Contact</a></li>
                    </ul>
                    <a href="../pages/login.php" class="btn btn-primary w-100 mt-2">Log In</a>
                </div>
            </div>
        </nav>
    </header>
