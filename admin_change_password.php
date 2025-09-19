<?php include_once('admin_header.php'); ?>
<style>
    .profile-container {
        width: 100%;
        padding: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .profile-card {
        border-radius: 1.2rem;
        border: none;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        max-width: 600px;
        width: 100%;
        overflow: hidden;
        animation: fadeInUp 0.8s ease-in-out;
    }

    .profile-header {
        background: linear-gradient(135deg, #28a745, #56d879);
        color: #fff;
        padding: 35px 25px;
        text-align: center;
    }

    .profile-header h2 {
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 1.6rem;
    }

    .profile-header p {
        font-size: 0.95rem;
        opacity: 0.95;
    }

    .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 0.8rem;
        padding: 12px;
        border: 1px solid #ddd;
        background: #f9f9f9;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        background: #fff;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
    }

    .btn-custom {
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-save {
        border: none;
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-save:hover {
        background: linear-gradient(90deg, #56d879, #28a745);
        transform: scale(1.05);
        box-shadow: 0 7px 20px rgba(40, 167, 69, 0.5);
    }

    .error {
        font-size: 0.85rem;
        color: #ff4d6d;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .btn-custom {
            width: 100%;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="profile-container">
    <div class="card profile-card">
        <div class="profile-header">
            <h2>🔒 Change Password</h2>
            <p>Update your account password securely</p>
        </div>

        <div class="card-body">
            <form action="admin_change_password.php" method="post">

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

<?php include_once('admin_footer.php');

if (isset($_POST['change_pwd_btn'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $email = $_SESSION['admin'];

    $q = "select * from registration where email='$email'";
    $result = $con->query($q);
    $row = mysqli_fetch_assoc($result);

    if ($row['password'] == $current_password) {
        $q = "UPDATE registration SET `password`='$new_password' WHERE `email`='$email'";
        if ($con->query($q)) {
?>
            <script>
                alert('Password updated successfully');
                window.location.href = 'admin_change_password.php';
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            alert('Old Password is Incorrect.');
            window.location.href = 'admin_change_password.php';
        </script>
<?php
    }
}
?>