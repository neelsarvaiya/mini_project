<?php
include('db_connect.php');

if (isset($_POST['add_user_btn'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_pic = uniqid() . "_" . $_FILES['profile_picture']['name'];
        $temp_name = $_FILES['profile_picture']['tmp_name'];
        $profile_path = "images/profile_pictures/" . $profile_pic;
        move_uploaded_file($temp_name, $profile_path);
    }

    $insert = "INSERT INTO registration (firstname,lastname, email, mobile, password, address, role, status, profile_picture)
               VALUES ('$firstname', '$lastname', '$email', '$phone', '$password', '$address', '$role', '$status', '$profile_pic')";

    $result = mysqli_query($con, $insert);

    if ($result) {
        echo "<script>alert('User Added Successfully.'); window.location.href='admin_user.php';</script>";
    } else {
        echo "<script>alert('Error adding user!'); window.location.href='add_user.php';</script>";
    }
}
?>

<?php include_once('admin_header.php'); ?>

<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: #fff;
        border-bottom: none;
        text-align: center;
        font-weight: 600;
        font-size: 1.3rem;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 12px;
        border: 1px solid #ced4da;
        transition: 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6610f2;
        box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        border-radius: 50px;
        padding: 12px 40px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        transform: translateY(-2px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .error {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .container .card-body {
        padding: 2rem;
    }

    label {
        font-weight: 600;
        color: #333;
    }

    #profile_picture {
        padding: 5px;
    }

    @media (max-width: 768px) {
        .card {
            margin: 20px;
        }
    }
</style>

<div class="card-body row">
    <div class="col-md-3"></div>

    <div class="col-md-6">
        <div class="d-flex justify-content-between p-5 align-items-center">
            <h2 class="mb-0">Add New User</h2>
            <a href="admin_user.php" class="btn btn-secondary btn-custom">Back to Users</a>
        </div>
        <div class="container mt-2 mb-5">
            <div class="card shadow-lg rounded-4">


                <form action="add_user.php" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="mb-3">
                        <label for="firstname" class="form-label fw-semibold">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            placeholder="Enter first name" data-validation="required alpha min" data-min="2">
                        <div class="error" id="firstnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label fw-semibold">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"
                            placeholder="Enter last name" data-validation="required alpha">
                        <div class="error" id="lastnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" data-validation="required email" name="email"
                            placeholder="Enter email">
                        <div class="error" id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" data-validation="required numeric min max" data-min="10" data-max="10"
                            placeholder="Enter 10-digit phone number">
                        <div class="error" id="phoneError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" id="address" name="address" data-validation="required"
                            placeholder="Enter address">
                        <div class="error" id="addressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="text" class="form-control" id="password" name="password"
                            placeholder="Password" data-validation="required strongPassword">
                        <div class="error" id="passwordError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="profile_picture" class="form-label fw-semibold">Profile Image</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" data-validation="required file filesize">
                        <div class="error" id="profile_pictureError"></div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success px-5" name="add_user_btn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3"></div>
</div>

<?php include_once('admin_footer.php'); ?>