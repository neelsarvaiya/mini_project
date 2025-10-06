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
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            color: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-icon {
            font-size: 60px;
            background: #fff;
            color: #764ba2;
            border-radius: 50%;
            padding: 20px;
            display: inline-block;
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            color: #fff;
        }

        .form-control {
            border-radius: 15px;
            border: none;
            padding: 12px 15px;
            margin-top: 5px;
        }

        .form-control:focus {
            border: 2px solid #fff;
            box-shadow: none;
        }

        .btn-primary {
            background: #ff758c;
            background: linear-gradient(to right, #ff7eb3, #ff758c);
            border-radius: 15px;
            padding: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #ff91b2, #ff6f91);
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 2px;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3"></div> <!-- Empty left -->
            <div class="col-md-6">
                <div class="card bg-primary">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle profile-icon"></i>
                        <h2>Complete Your Profile</h2>
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

                        <button type="submit" name="submit" class="btn btn-light w-100 mt-3">Save and Continue</button>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div> <!-- Empty right -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>