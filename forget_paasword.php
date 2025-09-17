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

                        <form action="forgot_submit.php" method="post" id="forgotForm">
                            <div class="row g-3">

                                <!-- Email -->
                                <div class="col-12">
                                    <input type="text" class="form-control" name="email" placeholder="Email Address"
                                        data-validation="required email">
                                    <div class="error" id="emailError"></div>
                                </div>

                                <!-- Submit -->
                                <div class="col-12">
                                    <button class="btn btn-success w-100">Send Reset Link</button>
                                </div>
                            </div>
                        </form>

                        <p class="text-center mt-4">
                            Remembered your password?
                            <a href="login.php" class="text-success fw-bold">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>