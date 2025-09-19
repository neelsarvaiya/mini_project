<?php include_once('admin_header.php');

if (isset($_SESSION['admin'])) {
    $email = $_SESSION['admin'];
    $q = "select * from registration where email='$email'";
    $result = $con->query($q);
    $row = mysqli_fetch_assoc($result);
}

?>

<style>
    body {
        background: linear-gradient(135deg, #f0fff0, #e8f9f2);
        font-family: 'Poppins', sans-serif;
    }

    .profile-container {
        margin-top: 40px;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .profile-card {
        border-radius: 1.5rem;
        border: none;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        width: 100%;
        transition: all 0.4s ease-in-out;
    }

    .profile-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }

    .profile-header {
        background: linear-gradient(120deg, #28a745, #56d879, #3dc27f);
        color: #fff;
        padding: 40px 30px;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .profile-header .profile-image {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        margin-bottom: 15px;
        transition: transform 0.3s ease;
        z-index: 2;
        position: relative;
    }

    .profile-header .profile-image:hover {
        transform: scale(1.08);
    }

    .profile-header h2 {
        font-weight: 700;
        font-size: 1.7rem;
        margin-bottom: 5px;
        z-index: 2;
        position: relative;
    }

    .profile-header p {
        font-size: 1rem;
        opacity: 0.95;
        z-index: 2;
        position: relative;
    }

    .card-body {
        padding: 2.8rem;
    }

    .form-label {
        font-weight: 600;
        color: #222;
    }

    .form-control {
        border-radius: 0.9rem;
        padding: 14px;
        border: 1px solid #d0e6d9;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 12px rgba(40, 167, 69, 0.3);
    }

    textarea.form-control {
        resize: none;
    }

    .btn-custom {
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-save {
        background: linear-gradient(135deg, #28a745, #56d879);
        color: #fff;
        border: none;
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #218838, #4bd07b);
        transform: scale(1.05);
    }

    .btn-secondary {
        border-radius: 50px;
        padding: 12px 28px;
        font-weight: 600;
    }

    /* Responsive Tweaks */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.8rem;
        }

        .profile-header .profile-image {
            width: 110px;
            height: 110px;
        }

        .btn-custom {
            width: 100%;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .profile-header h2 {
            font-size: 1.4rem;
        }

        .profile-header .profile-image {
            width: 90px;
            height: 90px;
        }

        .profile-header p {
            font-size: 0.9rem;
        }
    }
</style>

<div class="profile-container py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card profile-card">
                    <div class="profile-header">
                        <img src="images/profile_pictures/<?php echo $row['profile_picture']; ?>"
                            alt="Profile Picture" class="profile-image">
                        <h2><?php echo $row['firstname'] . " " . $row['lastname']; ?></h2>
                        <p><?php echo $row['email'] ?></p>
                    </div>

                    <div class="card-body">
                        <h5 class="mb-4">Edit Profile Details</h5>
                        <form action="admin_profile.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $row['firstname'] ?>"
                                        data-validation="required alpha min" data-min="2">
                                    <div class="error" id="firstnameError"></div>
                                </div>

                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $row['lastname'];  ?>"
                                        data-validation="required alpha min" data-min="2">
                                    <div class="error" id="lastnameError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile'];  ?>"
                                        data-validation="required numeric min max" data-min="10" data-max="10">
                                    <div class="error" id="mobileError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        data-validation="required min"
                                        data-min="5"><?php echo $row['address'];  ?></textarea>
                                    <div class="error" id="addressError"></div>
                                </div>

                                <div class="col-12">
                                    <label for="profile_picture" class="form-label">Update Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-save btn-custom" name="update_btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php');

if (isset($_POST['update_btn'])) {
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $email = $_SESSION['admin'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    if ($_FILES['profile_picture']['name'] != "") {
        $profile_picture = uniqid() . $_FILES['profile_picture']['name'];
        $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];

        $q1 = "select * from registration where email='$email'";
        $result = mysqli_fetch_assoc($con->query($q1));
        $old_profile_picture = $result['profile_picture'];
    }

    $update = "UPDATE `registration` SET `firstname`='$firstName',`lastname`='$lastName',`address`='$address',`mobile`=$mobile";
    if ($_FILES['profile_picture']['name'] != "") {
        $update = $update . ", `profile_picture`='$profile_picture'";
    }
    $update = $update . " where email='$email'";

    if ($con->query($update)) {
        if ($_FILES['profile_picture']['name'] != "") {
            move_uploaded_file($profile_picture_tmp_name, "images/profile_pictures/" . $profile_picture);
            unlink("images/profile_pictures/" . $old_profile_picture);
        }
?>
        <script>
            alert('profile updated successfully');
            window.location.href = "admin_profile.php";
        </script>
    <?php
    } else {
    ?>
        <script>
            alert('error in updating profile');
            window.location.href = "admin_profile.php";
        </script>
<?php
    }
}

?>
