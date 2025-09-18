<?php include_once('db_connect.php') ?>
<?php include_once('mailer.php') ?>
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
    <link rel="stylesheet" href="links/style.css">
</head>

<body>
    <header class="navbar navbar-expand-lg freshpick-header fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="index.php">
                <i class="bi bi-basket2-fill me-2"></i> FreshPick
            </a>

            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="servise.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                </ul>

                <div class="d-flex align-items-center header-icons">

                    <a href="cart.php" class="header-icon-link position-relative me-3">
                        <i class="bi bi-bag-check-fill fs-4"></i>
                        <span class="cart-badge">3</span>
                    </a>


                    <div class="dropdown profile-dropdown me-3">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="img/1.jpg" alt="User" width="38" height="38" class="rounded-circle border border-2">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg animate__animated animate__fadeInDown" aria-labelledby="dropdownUser">
                            <li class="dropdown-header text-center">
                                <h6 class="fw-bold mb-0">John Doe</h6>
                                <small class="text-muted">johndoe@email.com</small>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item" href="change_password.php"><i class="bi bi-key me-2"></i> Change Password</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-receipt me-2"></i> Orders</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                        </ul>
                    </div>


                    <a href="login.php" class="header-icon-link d-flex align-items-center ms-3">
                        <i class="bi bi-person-circle fs-4"></i> Account
                    </a>
                </div>
            </div>
        </div>
    </header>

    <?php
    if (isset($_COOKIE['success'])) {
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> <?php echo " " . $_COOKIE['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    if (isset($_COOKIE['error'])) {
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong><?php echo " " . $_COOKIE['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    ?>