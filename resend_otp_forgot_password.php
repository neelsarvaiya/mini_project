<?php
include_once("header.php");

if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];

    // Fetch OTP attempts and last resend time
    $query = "SELECT otp_attempts, last_resend FROM password_token WHERE email = '$email'";
    $result = $con->query($query);
    $row = mysqli_fetch_assoc($result);

    $attempts = $row['otp_attempts'];

    if ($attempts >= 3) {
        setcookie('error', "OTP resend limit reached. You can generate a new OTP after 24 hours.", time() + 5, "/");
?>
        <script>
            window.location.href = 'login.php';
        </script>
        <?php
        exit();
    }

    $email_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime('+2 minutes'));
    // Generate a new OTP
    $new_otp = rand(100000, 999999);
    $updateQuery = "UPDATE password_token SET otp=$new_otp, otp_attempts=$attempts+1, last_resend=now(), created_at='$email_time', expires_at='$expiry_time' WHERE email='$email'";
    if ($con->query($updateQuery)) {
        $to = $email;
        $subject = "Reset Your Password - OTP Verification";
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
                    <div class='otp'>$new_otp</div>
                    <p>This OTP is valid for 2 minutes. Please do not share it with anyone.</p>
                    <p>If you did not request a password reset, you can safely ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message, please do not reply.</p>
                </div>
            </div>
        </body>
        </html>";

        if (sendEmail($to, $subject, $body, "")) {
            setcookie("success", "OTP for reset password is sent successfully", time() + 5, "/");
        ?>
            <script>
                window.location.href = "otp_form.php";
            </script>
        <?php
        } else {
            setcookie("error", "Error in sending OTP for reset password", time() + 5, "/");
        ?>
            <script>
                window.location.href = "forget_password.php";
            </script>
<?php
        }
    }

    echo "<script>alert('New OTP sent.'); window.location.href='otp_form.php';</script>";
}
?>