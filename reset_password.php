<?php include 'header.php';

if (!isset($_SESSION['forgot_email'])) {
    setcookie('error', 'No email found for resetting password.', time() + 5, '/');
?>
    <script>
        window.location.href = 'forget_password.php';
    </script>
<?php
}

?>

<style>
    .reset-card {
        max-width: 450px;
        margin: 80px auto;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        background: #ffffff;
        overflow: hidden;
        position: relative;
    }

    .reset-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: #ff7e5f;
        border-radius: 50%;
        z-index: 1;
        opacity: 0.3;
    }

    .reset-card::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        background: #feb47b;
        border-radius: 50%;
        z-index: 1;
        opacity: 0.3;
    }

    .card-body {
        position: relative;
        z-index: 2;
        padding: 50px 30px;
    }

    h2 {
        font-weight: 700;
        color: #ff6f61;
        font-size: 1.8rem;
    }

    p {
        color: #666666;
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #ff6f61;
        box-shadow: 0 0 8px rgba(255, 111, 97, 0.3);
        outline: none;
    }

    .btn-outline-danger {
        border-radius: 50px;
        border: 2px solid #ff6f61;
        background: linear-gradient(135deg, #ff6f61, #ff9472);
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #ff9472, #ff6f61);
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(255, 111, 97, 0.4);
    }

    .text-center a {
        color: #ff6f61;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .text-center a:hover {
        color: #ff9472;
        text-decoration: underline;
    }

    .error {
        color: #ff3b30;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 40px 20px;
        }
    }
</style>

<div class="container py-5">
    <div class="card reset-card">
        <div class="card-body">
            <h2 class="text-center mb-3">Reset Password</h2>
            <p class="text-center mb-4">Please enter your new password below.</p>

            <form action="" method="post">
                <div class="mb-4">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" placeholder="Enter new password"
                        data-validation="required strongPassword min max" data-min="8" data-max="25" name="newPassword">
                    <div class="error" id="newPasswordError"></div>
                </div>

                <div class="mb-4">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password"
                        data-validation="required confirmPassword" data-password-id="newPassword" name="confirmPassword">
                    <div class="error" id="confirmPasswordError"></div>
                </div>

                <button type="submit" class="btn btn-outline-danger w-100 mb-3" name="reset_pwd_btn">Update Password</button>

                <div class="text-center">
                    <a href="login.php" class="text-decoration-none">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<?php
if (isset($_POST['reset_pwd_btn'])) {
    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $password = $_POST['newPassword'];

        $update_query = "UPDATE registration SET password = '$password' WHERE email = '$email'";
        if (mysqli_query($con, $update_query)) {
            $delete_query = "DELETE FROM password_token WHERE email = '$email'";
            mysqli_query($con, $delete_query);
            unset($_SESSION['forgot_email']);

            setcookie('success', 'Password has been reset successfully.', time() + 5, '/');
?>
            <script>
                window.location.href = 'login.php';
            </script>
        <?php
        } else {
            setcookie('error', 'Error in resetting Password.', time() + 5, '/');
        ?>
            <script>
                window.location.href = 'forget_password.php';
            </script>
        <?php
        }
    } else {
        setcookie('error', 'No email found for resetting password.', time() + 5, '/');
        ?>
        <script>
            window.location.href = 'forget_password.php';
        </script>
<?php
    }
}
?>