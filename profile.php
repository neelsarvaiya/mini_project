<?php
include_once('db_connect.php');
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['user'];

// profile update

if (isset($_POST['save_profile'])) {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    $update_sql = "UPDATE registration SET firstname='$firstname', lastname='$lastname', mobile='$mobile', address='$address'";

    if (!empty($_FILES['profile_picture']['name'])) {

        $filename = time() . "_" . basename($_FILES['profile_picture']['name']);
        $target = "images/profile_pictures/" . $filename;



        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            $sql = "SELECT profile_picture FROM registration WHERE email = $user_email";
            $data = mysqli_query($con, $sql);
            $user = mysqli_fetch_assoc($data);

            if (!empty($user['profile_picture'])) {
                $old_path = "images/profile_pictures/" . $user['profile_picture'];
                unlink($old_path);
            }
            $update_sql .= ", profile_picture='$filename'";
        }


    }

    $update_sql .= " WHERE email='$user_email'";

    if (mysqli_query($con, $update_sql)) {
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit;
    } else {
        $_SESSION['error'] = "Error updating profile!";
    }

}

$sql = "SELECT * FROM registration WHERE email = '$user_email' LIMIT 1";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);
?>

<?php include_once('header.php'); ?>

<style>
    .profile-container {
        margin-top: 30px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
        /* padding for small screens */
    }

    .profile-card {
        border-radius: 1.2rem;
        border: none;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        max-width: 750px;
        width: 100%;
        transition: all 0.3s ease-in-out;
    }

    .profile-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.15);
    }

    .profile-header {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
        padding: 30px;
        border-top-left-radius: 1.2rem;
        border-top-right-radius: 1.2rem;
        text-align: center;
    }

    .profile-header .profile-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .profile-header .profile-image:hover {
        transform: scale(1.08);
    }

    .profile-header h2 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .profile-header p {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .card-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 0.8rem;
        padding: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
    }

    .btn-custom {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save {
        border: 2px solid #28a745;
        color: #28a745;
    }

    .btn-save:hover {
        background: linear-gradient(90deg, #28a745, #56d879);
        color: #fff;
    }

    /* Responsive Tweaks */
    @media (max-width: 768px) {
        .profile-container {
            margin-top: 30px;
        }

        .card-body {
            padding: 1.5rem;
        }

        .profile-header .profile-image {
            width: 100px;
            height: 100px;
        }

        .btn-custom {
            width: 100%;
            /* full width buttons on small screens */
        }

        .d-flex.gap-3 {
            flex-direction: column;
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .profile-container {
            margin-top: 30px;
        }

        .profile-header h2 {
            font-size: 1.2rem;
        }

        .profile-header .profile-image {
            width: 80px;
            height: 80px;
        }

        .profile-header p {
            font-size: 0.85rem;
        }
    }
</style>

<div class="profile-container py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['success'];
                                unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>


                        <div class="text-center mb-4">
                            <img src="images/profile_pictures/<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'default.jpg'; ?>"
                                alt="Profile Picture" class="rounded-circle border border-2 shadow-sm mb-3" width="120"
                                height="120" style="object-fit: cover;">
                            <h2 class="mb-1">
                                <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>
                            </h2>
                            <p class="text-muted fs-6"><?php echo htmlspecialchars($user['email']); ?></p>
                            <hr class="my-4">
                        </div>

                        <h5 class="mb-4">Edit Profile Details</h5>
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        value="<?php echo htmlspecialchars($user['firstname']); ?>"
                                        data-validation="required alpha min" data-min="2">
                                    <div class="error" id="firstnameError"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        value="<?php echo htmlspecialchars($user['lastname']); ?>"
                                        data-validation="required alpha min" data-min="2">
                                    <div class="error" id="lastnameError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        value="<?php echo htmlspecialchars($user['mobile']); ?>"
                                        data-validation="required numeric min max" data-min="10" data-max="10">
                                    <div class="error" id="mobileError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        data-validation="required min"
                                        data-min="5"><?php echo htmlspecialchars($user['address']); ?></textarea>
                                    <div class="error" id="addressError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="profile_picture" class="form-label">Update Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                                <a href="index.php" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary" name="save_profile">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include_once('footer.php'); ?>