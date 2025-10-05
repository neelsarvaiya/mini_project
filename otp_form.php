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
    .otp-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 20px;
    }

    /* OTP card */
    .otp-container {
        width: 100%;
        max-width: 450px;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        padding: 40px 30px;
        animation: fadeIn 0.8s ease-in-out;
        text-align: center;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Title & subtitle */
    .otp-container h2 {
        font-size: 2rem;
        color: #28a745;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .otp-container p {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 25px;
    }

    /* OTP input boxes */
    .otp-input {
        width: 55px;
        height: 55px;
        margin: 0 5px;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        border: 2px solid #ddd;
        border-radius: 12px;
        background: #f1f5f9;
        transition: all 0.3s ease;
    }

    .otp-input:focus {
        border-color: #28a745;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.4);
        outline: none;
        background: #e6f9ee;
    }

    /* Timer text */
    #timer {
        font-weight: 600;
        margin: 10px 0;
        color: #dc3545;
        font-size: 0.95rem;
    }

    /* Resend button */
    #resend_otp {
        background: linear-gradient(135deg, #ff416c, #ff4b2b);
        border: none;
        padding: 12px 0;
        border-radius: 50px;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-bottom: 15px;
    }

    #resend_otp:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 75, 43, 0.4);
    }

    /* Verify button */
    .btn-verify {
        background: linear-gradient(135deg, #28a745, #56d879);
        border: none;
        border-radius: 50px;
        color: #fff;
        font-weight: 600;
        width: 100%;
        padding: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-verify:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    /* Back to login */
    .text-center a {
        color: #ff416c;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .text-center a:hover {
        text-decoration: underline;
        color: #ff4b2b;
    }

    /* Error message */
    .error {
        color: red;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    /* Responsive OTP input */
    @media(max-width: 576px) {
        .otp-input {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
            margin: 0 3px;
        }
    }
</style>

<div class="otp-wrapper">
    <div class="otp-container">
        <h2>Enter OTP</h2>
        <p>Please enter the verification code sent to your email</p>

        <form action="otp_form.php" method="post">
            <div class="d-flex justify-content-center mb-3">
                <input type="text" class="form-control otp-input" maxlength="1" autofocus oninput="moveToNext(this, 0)" name="otp1">
                <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 1)" name="otp2">
                <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 2)" name="otp3">
                <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 3)" name="otp4">
                <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 4)" name="otp5">
                <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 5)" name="otp6">
            </div>
            <div class="error" id="otpError"></div>

            <div id="timer"></div>

            <button type="button" id="resend_otp">Resend OTP</button>
            <button type="submit" class="btn-verify" name="otp_btn">Verify OTP</button>
        </form>

        <div class="text-center mt-3">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</div>

<script>
    function moveToNext(input, index) {
        if (input.value.length === input.maxLength) {
            if (index < 5) input.parentElement.children[index + 1].focus();
        }
    }

    let timeLeft = 120;
    const timerDisplay = document.getElementById('timer');
    const resendButton = document.getElementById('resend_otp');

    if (sessionStorage.getItem('otpTimer')) {
        timeLeft = parseInt(sessionStorage.getItem('otpTimer'), 10);
    } else {
        sessionStorage.setItem('otpTimer', 120);
    }

    function startCountdown() {
        resendButton.style.display = "none";
        const countdown = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerDisplay.innerHTML = "You can now resend the OTP.";
                resendButton.style.display = "inline";
                sessionStorage.removeItem('otpTimer');
            } else {
                timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                timeLeft -= 1;
                sessionStorage.setItem('otpTimer', timeLeft);
            }
        }, 1000);
    }

    if (timeLeft > 0) startCountdown();
    else {
        resendButton.style.display = "inline";
        timerDisplay.innerHTML = "You can now resend the OTP.";
    }

    resendButton.onclick = function(event) {
        event.preventDefault();
        sessionStorage.setItem('otpTimer', 120);
        window.location.href = 'resend_otp_forgot_password.php';
    };
</script>

<?php
include 'footer.php';

// OTP verification logic (unchanged)
if (isset($_POST['otp_btn'])) {
    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $otp = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6'];

        if ($otp == "") {
            setcookie('error', 'Please Enter OTP..', time() + 5, '/');
            echo "<script>window.location.href = 'otp_form.php';</script>";
            exit();
        }

        $query = "SELECT otp FROM password_token WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row['otp'];
            if (!$db_otp) {
                setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 5, '/');
                echo "<script>window.location.href = 'forgot_password.php';</script>";
                exit();
            } else {
                if ($otp == $db_otp) {
                    echo "<script>window.location.href = 'reset_password.php';</script>";
                    exit();
                } else {
                    setcookie('error', 'Incorrect OTP', time() + 5, '/');
                    echo "<script>window.location.href = 'otp_form.php';</script>";
                    exit();
                }
            }
        } else {
            setcookie('error', 'OTP has expired. Regenerate New OTP', time() + 5, '/');
            echo "<script>window.location.href = 'forgot_password.php';</script>";
            exit();
        }
    }
}
?>