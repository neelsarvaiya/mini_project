<?php
session_start();
include_once('db_connect.php');

if (!isset($_SESSION['google_user'])) {
    header("Location: login.php");
    exit;
}

$google_user = $_SESSION['google_user'];

if (isset($_POST['submit'])) {
    // Validate inputs
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);

    // Handle profile picture upload
    $profile_picture = '';
    if (isset($_FILES['profile'])) {
        $profile_picture = uniqid() . '_' . basename($_FILES['profile']['name']);
        $profile_picture_tmp_name = $_FILES['profile']['tmp_name'];

        if (!file_exists('images/profile_pictures')) {
            mkdir('images/profile_pictures');
        }

        move_uploaded_file($profile_picture_tmp_name, 'images/profile_pictures/' . $profile_picture);
    }

    $first_name = $google_user['first_name'];
    $last_name = $google_user['last_name'];
    $email = $google_user['email'];
    $password = "";
    $role = "user";
    $status = "active";

    $insert_query = "INSERT INTO registration 
                     (firstname, lastname, email, address, mobile, password, profile_picture, role, status)
                     VALUES ('$first_name', '$last_name', '$email', '$address', '$mobile', '$password', '$profile_picture', '$role', '$status')";

    if (mysqli_query($con, $insert_query)) {
        $_SESSION['user'] = $email;
        unset($_SESSION['google_user']);
        header("Location: index.php");
        exit;
    } else {
        echo "Database error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Complete Your Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="links/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="links/bootstrap.bundle.min.js"></script>
    <script src="links/jquery-3.7.1.js"></script>
    <script src="links/validate.js"></script>
    <link href="links/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fff6, #e6f9ee);
            font-family: 'Poppins', sans-serif;
        }

        .profile-container {
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
            color: #333;
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

        .error {
            color: red;
            font-size: 13px;
            margin-top: 2px;
        }

        label {
            font-weight: 600;
        }

        .profile-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="profile-container py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-person-circle profile-icon"></i>
                                <h3>Complete Your Profile</h3>
                                <p class="text-muted">Finish setting up your account to continue</p>
                            </div>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($google_user['first_name']) ?>" disabled>
                                </div>

                                <div class="mb-3">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" value="<?= htmlspecialchars($google_user['last_name']) ?>" disabled>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="<?= htmlspecialchars($google_user['email']) ?>" disabled>
                                </div>

                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" data-validation="required">
                                    <div class="error" id="addressError"></div>
                                </div>

                                <div class="mb-3">
                                    <label>Profile Picture</label>
                                    <input type="file" class="form-control" name="profile" data-validation="required file file2">
                                    <div class="error" id="profileError"></div>
                                </div>

                                <div class="mb-3">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="mobile" data-validation="required numeric min max" data-min="10" data-max="10">
                                    <div class="error" id="mobileError"></div>
                                </div>

                                <div class="d-grid mt-3">
                                    <button type="submit" name="submit" class="btn btn-success w-100">Save and Continue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>