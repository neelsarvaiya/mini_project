<?php include_once('admin_header.php'); ?>

<style>
    body {
        background: linear-gradient(135deg, #f5f6fa 0%, #eef2f7 100%);
        font-family: 'Poppins', sans-serif;
        color: #333;
    }

    .page-title {
        font-weight: 600;
        color: #343a40;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }

    .page-title::after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 50px;
    }

    .card-custom {
        background: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 20px;
        text-align: center;
        font-size: 1.3rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    label {
        font-weight: 500;
        color: #444;
    }

    .form-control,
    textarea {
        border-radius: 10px;
        border: 1px solid #ccc;
        transition: 0.3s;
    }

    .form-control:focus,
    textarea:focus {
        border-color: #6610f2;
        box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
    }

    .btn-custom {
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        border: none;
        color: #fff;
        font-weight: 500;
        border-radius: 50px;
        padding: 10px 30px;
        transition: all 0.3s;
    }

    .btn-custom:hover {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .image-preview {
        max-width: 200px;
        border-radius: 15px;
        margin-bottom: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    textarea {
        resize: none;
    }
</style>

<div class="container py-5">

    <h2 class="page-title">Website Information Management</h2>

    <div class="card card-custom mb-5">
        <div class="card-header">Edit Contact Information</div>
        <div class="card-body p-4">
            <?php
            // Fetch contact info
            $contactQuery = mysqli_query($con, "SELECT * FROM contact_us LIMIT 1");
            $contact = mysqli_fetch_assoc($contactQuery);
            ?>

            <form method="POST">
                <div class="mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" data-validation="required" value="<?= $contact['address'] ?>">
                    <div class="error" id="addressError"></div>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" data-validation="required email" value="<?= $contact['email'] ?? '' ?>">
                    <div class="error" id="emailError"></div>
                </div>

                <div class="mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" data-validation="required" value="<?= $contact['mobile'] ?? '' ?>">
                    <div class="error" id="mobileError"></div>
                </div>

                <div class="mb-3">
                    <label>Google Map Embed Link</label>
                    <textarea name="map" rows="3" class="form-control" data-validation="required" placeholder="Paste Google Map embed code"><?= $contact['maps'] ?? '' ?></textarea>
                    <div class="error" id="mapError"></div>
                </div>

                <button type="submit" name="updateContact" class="btn btn-custom">Save Changes</button>
            </form>

            <?php
            if (isset($_POST['updateContact'])) {
                $address = mysqli_real_escape_string($con, $_POST['address']);
                $email   = mysqli_real_escape_string($con, $_POST['email']);
                $mobile  = mysqli_real_escape_string($con, $_POST['mobile']);
                $map     = mysqli_real_escape_string($con, $_POST['map']);

                $update = "UPDATE contact_us SET address='$address', mobile='$mobile', email='$email', maps='$map'";
                if (mysqli_query($con, $update)) {
            ?>
                    <script>
                        alert('Contact Information Updated!');
                        window.location.href = 'admin_contact.php';
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        alert('Failed to Update Contact Info.');
                        window.location.href = 'admin_contact.php';
                    </script>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header">Edit About, Mission & Vision</div>
        <div class="card-body p-4">
            <?php
            $aboutQuery = mysqli_query($con, "SELECT * FROM contact_us LIMIT 1");
            $about = mysqli_fetch_assoc($aboutQuery);
            ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Current About Image</label><br>
                    <?php if (!empty($about['about_image'])): ?>
                        <img src="images/products/<?= $about['about_image']; ?>" class="image-preview">
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control mt-2" data-validation="file file2">
                    <div class="error" id="imageError"></div>
                </div>

                <div class="mb-3">
                    <label>About Text</label>
                    <textarea name="about_text" rows="4" class="form-control" required><?= $about['about_text'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Mission</label>
                    <textarea name="mission" rows="3" class="form-control" required><?= $about['mission'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Vision</label>
                    <textarea name="vision" rows="3" class="form-control" required><?= $about['vision'] ?? '' ?></textarea>
                </div>

                <button type="submit" name="updateAbout" class="btn btn-custom">Update Information</button>
            </form>

            <?php
            if (isset($_POST['updateAbout'])) {
                $about_text = $_POST['about_text'];
                $mission = $_POST['mission'];
                $vision = $_POST['vision'];
                $image = $about['about_image'];

                if (!empty($_FILES['image']['name'])) {
                    $targetDir = "images/products/";
                    $newImage = uniqid() . "_" . basename($_FILES["image"]["name"]);
                    $targetFile = $targetDir . $newImage;

                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                        if (!empty($image) && file_exists($targetDir . $image)) {
                            unlink($targetDir . $image);
                        }
                        $image = $newImage;
                    }
                }

                $updateAbout = "UPDATE contact_us SET about_text='$about_text', mission='$mission', vision='$vision', about_image='$image'";
                if (mysqli_query($con, $updateAbout)) {
                    ?>
                    <script>
                        alert('About Information Updated!');
                        window.location.href = 'admin_contact.php';
                    </script>
                <?php
                } else {
                    ?>
                    <script>
                        alert('Failed to Update About Section.');
                        window.location.href = 'admin_contact.php';
                    </script>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>