<?php include_once('db_connect.php') ?>

<?php
session_start();

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM registration WHERE email = '$email' LIMIT 1";
    $data = mysqli_query($con, $sql);

    if ($data && mysqli_num_rows($data) > 0) {
        $user = mysqli_fetch_assoc($data);

        if ($user['status'] != 'Active') {
            $_SESSION['login_error'] = "Inactive Account";
            header("Location: login.php");
            exit;
        }

        if ($user['password'] === $password) {

            if ($user['role'] === 'user') {
                $_SESSION['user'] = $user['email'];
                header("Location: index.php");
            } else {
                $_SESSION['admin'] = $user['email'];
                header("Location: admin_dashboard.php");
            }
        } else {
            $_SESSION['login_error'] = "Invalid password!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['login_error'] = "Invalid email!";
        header("Location: login.php");
        exit;
    }
}

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

                        <?php if (isset($_SESSION['login_error'])): ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                echo $_SESSION['login_error'];
                                unset($_SESSION['login_error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Email Address" data-validation="required email">
                                <div class="error" id="emailError"></div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" data-validation="required strongPassword">
                                <div class="error" id="passwordError"></div>
                            </div>

                            <!-- Forgot Password -->
                            <div class="text-end mb-4">
                                <a href="forget_paasword.php" class="login-link">Forgot Password?</a>
                            </div>

                            <!-- Submit -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success w-100" name="login">Login</button>
                            </div>
                        </form>

                        <!-- Signup Link -->
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