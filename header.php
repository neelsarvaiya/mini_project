<?php
session_start();
ob_start();

include_once('db_connect.php');
include_once('mailer.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshPick</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="links/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="links/bootstrap.bundle.min.js"></script>
    <script src="links/jquery-3.7.1.js"></script>
    <script src="links/validate.js"></script>
    <link href="links/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <style>
        :root {
            --theme-light-green: #d0e7d8;
            --theme-green: #37a847;
            --theme-green-darker: #2f8f3c;
            --theme-light-green: #d0e7d8;
            --star-color: #ffc107;
            --theme-light-green-bg: #f0f8f2;
            --text-dark: #2c3e50;
            --text-light: #555;
            --border-color: #eee;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .freshpick-header {
            background-color: var(--theme-green-darker);
            padding: 0.75rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .freshpick-header .navbar-brand,
        .freshpick-header .nav-link,
        .freshpick-header .header-icon-link {
            color: white;
        }


        .navbar-nav .nav-item {
            padding: 0 10px;
        }

        .freshpick-header .nav-link:hover,
        .freshpick-header .nav-link.active {
            color: var(--theme-light-green);
            font-weight: 500;
        }

        .header-icon-link {
            position: relative;
            color: white;
            transition: transform 0.2s ease;
        }

        .header-icon-link:hover {
            transform: scale(1.1);
            color: white;
        }

        .dropdown-item {
            transition: color 0.3s ease, transform 0.1s ease;
        }

        .dropdown-item:hover {
            color: var(--theme-green-darker);
            font-weight: 700;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: white;
            color: var(--theme-green);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--theme-green);
        }

        .auth-buttons .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: var(--theme-light-green);
            border-color: var(--theme-light-green);
            color: var(--theme-green);
        }

        .btn-login:hover {
            background-color: #bfe3ca;
            border-color: #bfe3ca;
            color: var(--theme-green);
        }

        .btn-signup {
            background-color: var(--theme-green);
            border-color: var(--theme-green-darker);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-signup:hover {
            background-color: var(--theme-green);
            border-color: var(--theme-green-darker);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 991.98px) {
            .freshpick-header .navbar-collapse {
                background-color: rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                margin-top: 1rem;
                padding: 2rem;
            }

            .header-icons {
                margin-top: 1rem;
                justify-content: center;
            }

            .navbar-toggler {
                border: none;
            }

            .navbar-toggler:focus {
                box-shadow: none;
            }
    </style>


    <!-- product -->

    <style>
        /* product */

        .error {
            color: red;
            margin-top: 3px;
            font-weight: 500;
        }

        .product-sec {
            padding: 80px 0;
        }

        .product-sec .title {
            font-weight: 700;
            color: var(--theme-green-darker);
        }

        .product-sec .subtitle {
            color: var(--text-light);
            max-width: 600px;
        }

        /* --- Product Card Styling --- */
        .product-card {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 15px;
            overflow: hidden;
            margin-left: 10px;
            position: relative;
            text-align: center;
            transition: all 0.4s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Image Container */
        .product-image {
            padding: 1rem;
            background-color: var(--theme-light-green-bg);
        }

        .product-image img {
            max-width: 100%;
            height: 200px;
            object-fit: contain;
        }

        /* Discount Badge */
        .discount-badge {
            position: absolute;
            top: 7px;
            left: 7px;
            background-color: var(--theme-green);
            color: white;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        /* --- ✨ ACTION ICONS HOVER ANIMATION --- */
        .product-actions {
            position: absolute;
            top: 15px;
            right: -60px;
            /* Initially hidden outside the card */
            opacity: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            /* Smooth, bouncy transition */
            z-index: 3;
        }

        .product-card:hover .product-actions {
            right: 15px;
            /* Slides into view */
            opacity: 1;
            /* Fades in */
        }

        .action-btn {
            background-color: var(--theme-green);
            color: #ffffff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background-color: var(--theme-green-darker);
            color: white;
            transform: scale(1.1);
        }

        /* Product Info Text */

        .product-info-new {
            background-color: #ffffff;
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
            border-radius: 0 0 15px 15px;
            /* Assuming this is at the bottom of a card */
            max-width: 350px;
            /* For demonstration */
            width: 100%;
        }

        .top-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .product-info-new .category {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-info-new .stock-status {
            background-color: var(--theme-light-green-bg);
            color: var(--theme-green);
            padding: 3px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 50px;
        }

        .product-info-new .title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .product-info-new .title:hover {
            color: var(--theme-green);
        }

        .product-info-new .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .product-info-new .rating .stars {
            color: var(--star-color);
        }

        .product-info-new .rating .review-count {
            color: var(--text-light);
        }

        .product-info-new .price-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-info-new .prices {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .product-info-new .new-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--theme-green);
        }

        .product-info-new .old-price {
            font-size: 1rem;
            color: var(--text-light);
            text-decoration: line-through;
        }

        .product-info-new .save-badge {
            background-color: var(--theme-green);
            color: white;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: 5px;
        }
    </style>


    <!-- Seasonal Offers Section  -->
    <style>
        .seasonal-offers-sec {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .seasonal-offers-sec .title {
            font-weight: 800;
            color: var(--text-dark);
        }

        .seasonal-offers-sec .subtitle {
            color: var(--text-light);
            max-width: 600px;
        }

        /* --- NEW: Split Offer Card Styling --- */
        .offer-card {
            display: flex;
            border-radius: 15px;
            overflow: hidden;
            background-color: var(--theme-green);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            min-height: 280px;
        }

        .offer-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(55, 168, 71, 0.15);
        }

        /* Image half of the card */
        .offer-image {
            width: 45%;
            background-size: cover;
            background-position: center;
            transition: transform 0.4s ease;
        }

        .offer-card:hover .offer-image {
            transform: scale(1.05);
            /* Zoom effect on hover */
        }

        /* Content half of the card */
        .offer-content {
            width: 55%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .offer-content h4 {
            font-weight: 700;
            font-size: 1.75rem;
            line-height: 1.3;
            color: #ffffff;
        }

        .offer-content .btn {
            font-weight: 600;
            padding: 8px 24px;
            border-radius: 50px;
            background-color: #ffffff;
            color: #2f8f3c;
            border: none;
            transition: all 0.3s ease;
        }

        .offer-content .btn:hover {
            transform: scale(1.05);
            color: #ffffff;
            background-color: #2f8f3c;
            /* Darker green */
        }

        /* Responsive: Stack layout on smaller screens */
        @media (max-width: 767.98px) {
            .offer-card {
                flex-direction: column;
                /* Stack image and text vertically */
                min-height: 450px;
            }

            .offer-image,
            .offer-content {
                width: 100%;
            }

            .offer-image {
                height: 200px;
            }

            .offer-content {
                text-align: center;
                align-items: center;
            }
        }
    </style>

    <!-- footer style -->
    <style>
        :root {
            --theme-light-green: #d0e7d8;
            --theme-green: #37a847;
        }

        .freshpick-footer {
            background-color: var(--theme-green);
            color: #e0e0e0;
        }

        /* Footer Headings */
        .freshpick-footer h3,
        .freshpick-footer h5 {
            color: #ffffff;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.15);
            display: inline-block;
        }

        .freshpick-footer h3 i {
            color: var(--theme-light-green);
        }

        /* Footer Links */
        .freshpick-footer a {
            color: var(--theme-light-green);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .freshpick-footer .list-unstyled li {
            margin-bottom: 0.75rem;
        }

        .freshpick-footer .list-unstyled a:hover {
            color: #ffffff;
            padding-left: 5px;
            /* Adds a subtle shift on hover */
        }

        /* Social Media Icons */
        .social-icons a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 1.1rem;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: #ffffff;
            color: var(--theme-green);
            transform: translateY(-4px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Contact Info List */
        .freshpick-footer .col-md-3 ul li {
            display: flex;
            align-items: start;
        }

        .freshpick-footer .col-md-3 ul i {
            margin-top: 5px;
            color: var(--theme-light-green);
        }

        /* Copyright Section */
        .freshpick-footer .border-top {
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        @media (max-width: 767.98px) {

            .freshpick-footer .col-md-4,
            .freshpick-footer .col-md-2,
            .freshpick-footer .col-md-3 {
                text-align: center;
            }

            .freshpick-footer .col-md-3 ul,
            .freshpick-footer .col-md-2 ul {
                /* Allows the list to be centered as a block, while keeping text left-aligned */
                display: inline-block;
                text-align: left;
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>

</head>

<body>


    <header class="navbar navbar-expand-lg freshpick-header">
        <div class="container">
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="index.php">
                <i class="bi bi-basket2-fill me-2"></i> FreshPick
            </a>

            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="servise.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                </ul>

                <div class="d-flex align-items-center justify-content-center header-icons">

                    <a href="cart.php" class="header-icon-link me-3">
                        <i class="bi bi-cart fs-4"></i>
                        <span class="cart-badge">3</span>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>

                        <div class="dropdown profile-dropdown me-3">
                            <!-- <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="img/profile_pictures/68cab6cdad205_Screenshot 2025-07-01 143502.png" alt="User"
                                    width="38" height="38" class="rounded-circle border border-2">
                            </a> -->
                            <a href="#"
                                class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle px-3 rounded"
                                id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left: 10px; padding: 1px 0; background-color: var(--theme-light-green)">

                                <img src="img/profile_pictures/68cab6cdad205_Screenshot 2025-07-01 143502.png" alt="User"width="38" height="38" class="rounded-circle border border-2 me-2">
                                <span class="fw-semibold">John Doe</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg animate__animated animate__fadeInDown"
                                aria-labelledby="dropdownUser">
                                <li class="dropdown-header text-center">
                                    <h6 class="fw-bold mb-0"></h6>
                                    <small class="text-muted"></small>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item mb-2" href="profile.php"><i class="bi bi-person me-2"></i> My
                                        Profile</a></li>
                                <li><a class="dropdown-item mb-2" href="change_password.php"><i class="bi bi-key me-2"></i>
                                        Change Password</a></li>
                                <li><a class="dropdown-item mb-2" href="wishlist.php"><i class="bi bi-heart me-2"></i>
                                        Wishlist</a></li>
                                <li><a class="dropdown-item mb-2" href="#"><i class="bi bi-receipt me-2"></i> Orders</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i
                                            class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="auth-buttons d-flex">
                            <a href="login.php" class="btn btn-login me-2">Log in</a>
                            <a href="register.php" class="btn btn-signup">Sign up</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </header>



    <?php
    if (isset($_COOKIE['success'])) {
        ?>
        <div class="alert alert-success alert-dismissible mt-5 fade show" role="alert">
            <strong>Success!</strong> <?php echo " " . $_COOKIE['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
    if (isset($_COOKIE['error'])) {
        ?>
        <div class="alert alert-danger alert-dismissible mt-5 fade show" role="alert">
            <strong>Error!</strong><?php echo " " . $_COOKIE['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
    ?>