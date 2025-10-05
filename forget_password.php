<?php include_once('header.php'); ?>

<style>
    body {
        background: linear-gradient(135deg, #f8fff6, #e6f9ee);
        font-family: 'Poppins', sans-serif;
    }

    .forgot-container {
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

<div class="forgot-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-3">Forgot Password?</h3>
                        <p class="text-center text-muted mb-4">Enter your registered email and we’ll send you a reset link.</p>

                        <form action="forget_password.php" method="post">
                            <div class="row g-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="email" placeholder="Email Address" data-validation="required email">
                                    <div class="error" id="emailError"></div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-success w-100" name="forgot_btn">Send Reset Link</button>
                                </div>
                            </div>
                        </form>

                        <p class="text-center mt-4">
                            Remembered your password? <a href="login.php" class="text-success fw-bold">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>

<?php
if (isset($_POST['forgot_btn'])) {
    $email = $_POST['email'];

    $user_check = "SELECT * FROM registration WHERE email = '$email'";
    $user_result = mysqli_query($con, $user_check);

    if (mysqli_num_rows($user_result) == 0) {
        setcookie('error', 'This email is not registered. Please use a valid email.', time() + 2, "/");
?>
        <script>
            window.location.href = "forget_password.php";
        </script>
<?php
        exit();
    }

    $query = "SELECT * FROM password_token WHERE email = '$email'";
    $result = mysqli_fetch_assoc($con->query($query));

    $otp = rand(100000, 999999);
    $email_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));
    $subject = "Password Reset - OTP";

    $body = "<html>
        <head>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
                body { font-family: 'Poppins', sans-serif; background: #f4f6f8; margin: 0; padding: 0; }
                .email-container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
                .header { background: linear-gradient(135deg, #ff6f61, #ff9472); padding: 30px; text-align: center; color: #fff; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 700; }
                .content { padding: 30px; color: #333; line-height: 1.6; }
                .content p { margin-bottom: 20px; font-size: 15px; }
                .otp { display: inline-block; padding: 15px 25px; font-size: 28px; font-weight: 700; color: #ff6f61; background: #ffe5e0; border-radius: 10px; letter-spacing: 4px; margin-bottom: 20px; }
                .btn { display: inline-block; background: linear-gradient(135deg, #ff6f61, #ff9472); color: #fff; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; }
                .btn:hover { background: linear-gradient(135deg, #ff9472, #ff6f61); transform: translateY(-2px); }
                .footer { text-align: center; font-size: 12px; color: #777; padding: 20px; border-top: 1px solid #eee; }
                @media (max-width: 480px) { .email-container { margin: 20px; } .otp { font-size: 24px; padding: 12px 20px; } }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>
                    <h1>Password Reset OTP</h1>
                </div>
                <div class='content'>
                    <p>Hello,</p>
                    <p>We received a request to reset your password. Use the OTP below to verify your request and reset your password:</p>
                    <div class='otp'>$otp</div>
                    <p>This OTP is valid for 2 minutes. Please do not share it with anyone.</p>
                    <p>If you did not request a password reset, you can safely ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>";;

    if ($result) {
        $attempts = $result['otp_attempts'];
        if ($attempts >= 3) {
            setcookie('error', "Maximum OTP limit reached. Try after 24 hours from last OTP.", time() + 5, "/");
            echo "<script>window.location.href = 'login.php';</script>";
            exit();
        } else {
            $q = "UPDATE password_token SET otp=$otp, otp_attempts=$attempts+1, last_resend=NOW(), created_at='$email_time', expires_at='$expiry_time' WHERE email='$email'";
        }
    } else {
        $q = "INSERT INTO password_token (email, otp, created_at, expires_at, otp_attempts, last_resend) VALUES ('$email', '$otp', '$email_time', '$expiry_time', 0, NOW())";
    }

    if (sendEmail($email, $subject, $body, "")) {
        if ($con->query($q)) {
            $_SESSION['forgot_email'] = $email;
            setcookie('success', 'OTP sent to your email. Expires in 2 minutes.', time() + 5);
            echo "<script>window.location.href = 'otp_form.php';</script>";
            exit();
        } else {
            setcookie('error', 'Failed to store OTP in database', time() + 5);
        }
    } else {
        setcookie('error', 'Failed to send OTP email. Please try again.', time() + 5);
    }
}

?>