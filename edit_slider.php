<?php include_once('admin_header.php'); ?>

<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .btn-custom {
        border-radius: 50px;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Slider</h2>
        <a href="admin_slider.php" class="btn btn-secondary btn-custom">Back to Sliders</a>
    </div>

    <?php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<div class='alert alert-danger'>Invalid Slider ID</div>";
        include_once('admin_footer.php');
        exit;
    }

    $sliderId = $_GET['id'];
    $query = "SELECT * FROM slider WHERE id = $sliderId";
    $result = mysqli_query($con, $query);
    $slider = mysqli_fetch_assoc($result);

    if (isset($_POST['updateSlider'])) {
        $status = $_POST['status'];
        $newImage = $slider['slider_image'];

        if (isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['error'] == 0) {
            $imageName = time() . "_" . basename($_FILES['slider_image']['name']);
            $targetPath = "images/" . $imageName;

            if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $targetPath)) {
                if (!empty($slider['slider_image']) && file_exists("images/" . $slider['slider_image'])) {
                    unlink("images/" . $slider['slider_image']);
                }
                $newImage = $imageName;
            } else {
                setcookie('error', 'Error uploading new image', time() + 2, '/');
    ?>
                <script>
                    window.location.href = 'admin.php';
                </script>
    <?php
            }
        }

        $updateQuery = "UPDATE slider SET slider_image='$newImage', status='$status' WHERE id=$sliderId";
        if (mysqli_query($con, $updateQuery)) {
            echo "<script>alert('Slider updated successfully');</script>";
            echo "<script>window.location.href='admin_slider.php';</script>";
        } else {
            echo "<script>alert('Database error: Unable to update slider');</script>";
        }
    }
    ?>

    <div class="card p-4">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-semibold">Current Image</label><br>
                <img src="images/<?= $slider['slider_image']; ?>" height="120px" width="250px" class="rounded shadow-sm mb-2">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Upload New Image (Optional)</label>
                <input type="file" name="slider_image" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= ($slider['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?= ($slider['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" name="updateSlider" class="btn btn-primary btn-custom">
                <i class="bi bi-save"></i> Update Slider
            </button>
        </form>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>