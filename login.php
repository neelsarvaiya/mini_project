<?php
include_once('header.php');
?>

<style>
    body {
        background: linear-gradient(135deg, #f8fff6, #e6f9ee);
        font-family: 'Poppins', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 1.2rem;
        border: none;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .card-body h3 {
        background: linear-gradient(90deg, #28a745, #56d879);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }

    .text-muted {
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 0.8rem;
        padding: 12px 15px;
        border: 1px solid #d9e7dd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #56d879);
        border: none;
        border-radius: 50px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #4bd07b);
        transform: scale(1.03);
    }

    .btn-google {
        background: #fff;
        border: 1px solid #dcdcdc;
        border-radius: 50px;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .btn-google:hover {
        background: #f7f7f7;
        transform: scale(1.02);
        text-decoration: none;
    }

    .btn-google img {
        width: 20px;
        margin-right: 10px;
    }

    .login-link {
        color: #28a745;
        text-decoration: none;
        font-weight: 500;
    }

    .login-link:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-3">Login to Your Account</h3>
                        <p class="text-center text-muted mb-4">Enter your credentials to access your profile.</p>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Email Address" data-validation="required email">
                                <div class="error" id="emailError"></div>
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" data-validation="required strongPassword">
                                <div class="error" id="passwordError"></div>
                            </div>

                            <div class="text-end mb-4">
                                <a href="forget_password.php" class="login-link">Forgot Password?</a>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success w-100" name="login">Login</button>
                            </div>
                        </form>
                        <div class="or-divider text-center mb-3">
                            <span>OR</span>
                        </div>
                        <!-- Google Login Button -->
                        <a href="google_login.php" class="btn-google w-100 mb-3">
                            <img src="images/products/g-logo.png"
                                alt="Google"
                                style="width:20px; height:20px; margin-right:10px; vertical-align:middle;">
                            Login with Google
                        </a>

                        <style>
                            .or-divider {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: #999;
                                font-weight: 500;
                                position: relative;
                                text-transform: uppercase;
                            }

                            .or-divider::before,
                            .or-divider::after {
                                content: "";
                                flex: 1;
                                height: 1px;
                                background: #ddd;
                                margin: 0 10px;
                            }

                            .btn-google {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                background-color: #fff;
                                color: #444;
                                border: 1px solid #ddd;
                                font-weight: 500;
                                padding: 10px;
                                border-radius: 50px;
                                transition: 0.3s;
                                text-decoration: none;
                            }

                            .btn-google:hover {
                                background-color: #f7f7f7;
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                            }
                        </style>

                        <p class="text-center mt-4">
                            Don’t have an account?
                            <a href="register.php" class="login-link fw-bold">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>

<?php
// ** Existing Email/Password Login **
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM registration WHERE email = '$email'";
    $data = mysqli_query($con, $sql);

    if ($data && mysqli_num_rows($data) > 0) {
        $user = mysqli_fetch_assoc($data);

        if ($user['status'] == 'active') {
            if ($user['password'] == $password) {
                if ($user['role'] === 'user') {
                    $_SESSION['user'] = $user['email'];
                    echo "<script>window.location.href = 'index.php';</script>";
                } else {
                    $_SESSION['admin'] = $user['email'];
                    echo "<script>window.location.href = 'admin_dashboard.php';</script>";
                }
            } else {
                setcookie("error", "Incorrect Password...", time() + 2, "/");
                echo "<script>window.location.href = 'login.php';</script>";
            }
        } else {
            setcookie("error", "Your account is Inactive....", time() + 2, "/");
            echo "<script>window.location.href = 'login.php';</script>";
        }
    } else {
        setcookie("error", "Email is not verified", time() + 2, "/");
        echo "<script>window.location.href = 'login.php';</script>";
    }
}
?>