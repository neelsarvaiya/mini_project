<?php
include('db_connect.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM registration WHERE id = $id";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['edit_user_btn'])) {
    $id = $_POST['user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $mobile = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $password = $_POST['password'];


    $get_data = "SELECT * FROM registration WHERE id = $id";
    $result = mysqli_query($con, $get_data);
    $user = mysqli_fetch_assoc($result);

    if (!empty($_FILES['profile_picture']['name'])) {

        $old_pic = $user['profile_picture'];

        if (file_exists("images/profile_pictures/" . $old_pic)) {
            unlink("images/profile_pictures/" . $old_pic);
        }

        $profile_pic = uniqid() . "_" . $_FILES['profile_picture']['name'];
        $temp_name = $_FILES['profile_picture']['tmp_name'];
        $profile_path = "images/profile_pictures/" . $profile_pic;

        move_uploaded_file($temp_name, $profile_path);

        $update = "UPDATE registration SET 
                firstname = '$firstname',
                lastname = '$lastname',
                email = '$email',
                address = '$address',
                mobile = '$mobile',
                password = '$password',
                profile_picture = '$profile_pic',
                role = '$role',
                status = '$status'
               WHERE id='$id'";
    } else {
        $update = "UPDATE registration SET 
                firstname = '$firstname',
                lastname = '$lastname',
                email = '$email',
                address = '$address',
                mobile = '$mobile',
                password = '$password',
                role = '$role',
                status = '$status'
               WHERE id='$id'";
    }


    $result = mysqli_query($con, $update);

    if ($result) {
        setcookie('success', 'User Updated Successfull.', time() + 2, '/');
    } else {
        setcookie('error', 'Error updating user details!', time() + 2, '/');
    }
    ?>
        <script>
            window.location.href = 'admin_user.php';
        </script>
    <?php
}

?>

<?php include_once('admin_header.php') ?>
<style>
    body {
        background: #f0f2f5;
    }

    .card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        border: none;
        padding: 25px;
        text-align: center;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 600;
        color: #fff;
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
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        border-radius: 12px;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1e7e34);
        transform: translateY(-2px);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-img {
        border: 5px solid #fff;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.15);
        transition: 0.3s;
    }

    .profile-img:hover {
        transform: scale(1.05);
    }
</style>

<div class="card-body row">
    <div class="col-md-3"></div>

    <div class="col-md-6">
        <div class="container mt-5 mb-5">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>

                <form action="edit_user.php" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="images/profile_pictures/<?= $user['profile_picture']; ?>"
                            class="img-fluid rounded-circle profile-img"
                            style="height: 220px; width: 220px; object-fit: cover;">
                    </div>

                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                    <div class="mb-3">
                        <label for="firstname" class="form-label fw-semibold">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            placeholder="Enter first name" value="<?= $user['firstname']; ?>" data-validation="required alpha min" data-min="2">
                        <div class="error" id="firstnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label fw-semibold">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"
                            placeholder="Enter last name" data-validation="required alpha" value="<?= $user['lastname']; ?>">
                        <div class="error" id="lastnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" data-validation="required email" name="email"
                            placeholder="Enter email" value="<?= $user['email']; ?>">
                        <div class="error" id="emailError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" data-validation="required numeric min max" data-min="10" data-max="10"
                            placeholder="Enter 10-digit phone number" value="<?= $user['mobile']; ?>">
                        <div class="error" id="phoneError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" id="address" name="address" data-validation="required"
                            placeholder="Enter address" value="<?= $user['address']; ?>">
                        <div class="error" id="addressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="text" class="form-control" id="password" name="password" da value="<?= $user['password']; ?>"
                            placeholder="Password" data-validation="required strongPassword">
                        <div class="error" id="passwordError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user" <?= ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?= ($user['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?= ($user['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="profile_picture" class="form-label fw-semibold">Profile Image</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" data-validation="file filesize">
                        <div class="error" id="profile_pictureError"></div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success px-5" name="edit_user_btn">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3"></div>
</div>

<?php include_once('admin_footer.php') ?>