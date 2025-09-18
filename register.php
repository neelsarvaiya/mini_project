<?php

include("db_connect.php");
include("mailer.php");

if (isset($_POST['signup_btn'])) {
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $mobile = $_POST['phone'];
    $password = $_POST['password'];
    $profile_picture = uniqid() . $_FILES['profile_picture']['name'];
    $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
    $token = uniqid() . time();
    $insert = "INSERT INTO registration(firstname, lastname, email,address, mobile, password, profile_picture, role, status,token) VALUES ('$firstName','$lastName','$email','$address','$mobile','$password','$profile_picture','User','Inactive','$token')";
    if ($con->query($insert)) {
        if (!file_exists('images/profile_pictures')) {
            mkdir('images/profile_pictures');
        }
        move_uploaded_file($profile_picture_tmp_name, 'images/profile_pictures/' . $profile_picture);
        $link = 'http://localhost/mini_project/verify_email.php?email=' . $email . '&token=' . $token;
        $body = "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'> <h2 style='color: #dc3545; text-align: center;'>Account Verification</h2> <p style='text-align: center;'>Click on the button below to verify your account</p> <a href='" . $link . "' style='display: block; width: 200px; margin: 0 auto; text-align: center; background-color: #dc3545; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Account</a> </div>";
        $subject = "Account Verification Mail";
        if (sendEmail($email, $subject, $body, "")) {
            echo "<script> alert('Registration Successfull. Account verification link has been sent to your email. Verify your email to login.'); </script>";
        } else {
            echo "<script> alert('Failed to send the registration link'); </script>";
        }
    } else {
        echo "<script> alert('Registration Failed'); </script>";
    }
    ?>
    <script>
        window.location.href = 'register.php';
    </script>
    <?php
}
?>
<?php include_once('header.php'); ?>
<style>
    body {
        background: linear-gradient(135deg, #f8fff6, #e6f9ee);
        font-family: 'Poppins', sans-serif;
    }

    .register-container {
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
</style>

<div class="register-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-3">Create Your Account</h3>
                        <p class="text-center text-muted mb-4">Join FreshPick and shop fresh groceries with ease!</p>
                        <form action="register.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        placeholder="First Name" data-validation="required alpha min" data-min="2">
                                    <div class="error" id="firstnameError"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Last Name" data-validation="required alpha min" data-min="2">
                                    <div class="error" id="lastnameError"></div>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Email Address" data-validation="required email">
                                    <div class="error" id="emailError"></div>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Phone Number" data-validation="required numeric min max"
                                        data-min="10" data-max="10">
                                    <div class="error" id="phoneError"></div>
                                </div>
                                <div class="col-12">
                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                        data-validation="required file filesize" data-filesize="">
                                    <div class="error" id="profile_pictureError"></div>
                                </div>
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label">Your Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"
                                        placeholder="Your Address" data-validation="required min"
                                        data-min="5"></textarea>
                                    <div class="error" id="addressError"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" data-validation="required strongPassword">
                                    <div class="error" id="passwordError"></div>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Confirm Password"
                                        data-validation="required confirmPassword" data-password-id="password">
                                    <div class="error" id="confirm_passwordError"></div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-success w-100" type="submit" name="signup_btn">Sign
                                        Up</button>
                                </div>
                            </div>
                        </form>
                        <p class="text-center mt-4"> Already have an account? <a href="login.php"
                                class="text-success fw-bold">Login here</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once('footer.php');
?>