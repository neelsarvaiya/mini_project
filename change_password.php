<?php include_once('header.php');

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

?>

<style>
    .profile-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }

    .profile-card {
        border-radius: 1.2rem;
        border: none;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        max-width: 600px;
        width: 100%;
        transition: all 0.3s ease-in-out;
    }

    .profile-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.15);
    }

    .profile-header {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
        padding: 30px;
        border-top-left-radius: 1.2rem;
        border-top-right-radius: 1.2rem;
        text-align: center;
    }

    .profile-header h2 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .profile-header p {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .card-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 0.8rem;
        padding: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
    }

    .btn-custom {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save {
        border: 2px solid #28a745;
        color: #28a745;
    }

    .btn-save:hover {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .btn-custom {
            width: 100%;
        }
    }
</style>

<div class="profile-container">
    <div class="card profile-card">
        <div class="profile-header">
            <h2>Change Password</h2>
            <p>Update your account password securely</p>
        </div>

        <div class="card-body">
            <form action="change_password.php" method="post">

                <!-- Current Password -->
                <div class="mb-4">
                    <input type="password" class="form-control" name="current_password"
                        placeholder="Current Password"
                        data-validation="required strongPassword">
                    <div class="error" id="current_passwordError"></div>
                </div>

                <!-- New Password -->
                <div class="mb-4">
                    <input type="password" class="form-control" name="new_password" id="new_password"
                        placeholder="New Password"
                        data-validation="required strongPassword">
                    <div class="error" id="new_passwordError"></div>
                </div>

                <!-- Confirm New Password -->
                <div class="mb-4">
                    <input type="password" class="form-control" name="confirm_password"
                        placeholder="Confirm New Password"
                        data-validation="required confirmPassword"
                        data-password-id="new_password">
                    <div class="error" id="confirm_passwordError"></div>
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-custom btn-save" name="change_pwd_btn">Update Password</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php');

if (isset($_POST['change_pwd_btn'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $email = $_SESSION['user'];

    $q = "select * from registration where email='$email'";
    $result = $con->query($q);
    $row = mysqli_fetch_assoc($result);

    if ($row['password'] == $current_password) {
        $q = "UPDATE registration SET `password`='$new_password' WHERE `email`='$email'";
        if ($con->query($q)) {
            setcookie('success', 'Password updated successfully', time() + 2,'/');
?>
            <script>
                window.location.href = 'change_password.php';
            </script>
        <?php
        }
    } else {
        setcookie('error', 'Old Password is Incorrect.', time() + 2, '/');
        ?>
        <script>
            window.location.href = 'change_password.php';
        </script>
<?php
    }
}
?>