<?php include_once('admin_header.php'); ?>


<?php
if (isset($_POST['addSlider'])) {
    $status = $_POST['status'];

    if (isset($_FILES['slider_image']['name']) && $_FILES['slider_image']['error'] == 0) {
        $imageName = time() . "_" . basename($_FILES['slider_image']['name']);
        $targetPath = "images/" . $imageName;

        if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $targetPath)) {
            $query = "INSERT INTO slider (slider_image, status) VALUES ('$imageName', '$status')";
            if (mysqli_query($con, $query)) {
                echo "<script>alert('Slider added successfully');</script>";
                echo "<script>window.location.href='admin_slider.php';</script>";
            } else {
                echo "<script>alert('Database error: Unable to save slider');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image');</script>";
        }
    } else {
        echo "<script>alert('Please select a valid image');</script>";
    }
}
?>
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
        <h2 class="mb-0">Add New Slider</h2>
        <a href="admin_slider.php" class="btn btn-secondary btn-custom">Back to Sliders</a>
    </div>

    <div class="card p-4">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-semibold">Slider Image</label>
                <input type="file" name="slider_image" class="form-control" data-validation="required file filesize">
                <div class="error" id="slider_imageError"></div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" name="addSlider" class="btn btn-primary btn-custom">
                <i class="bi bi-upload"></i> Save Slider
            </button>
        </form>
    </div>
</div>
<?php include_once('admin_footer.php'); ?>