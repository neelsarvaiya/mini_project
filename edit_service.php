<?php
include_once('admin_header.php');

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location.href='admin_service.php';</script>";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM services WHERE id = $id";
$result = mysqli_query($con, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Service not found!'); window.location.href='admin_service.php';</script>";
    exit;
}

$service = mysqli_fetch_assoc($result);

if (isset($_POST['updateService'])) {
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    $update = "UPDATE services SET icon='$icon', title='$title', description='$description' WHERE id=$id";
    if (mysqli_query($con, $update)) {
        echo "<script>alert('Service updated successfully!'); window.location.href='admin_service.php';</script>";
    } else {
        echo "<script>alert('Failed to update service!');</script>";
    }
}
?>

<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    .form-container {
        max-width: 700px;
        margin: 50px auto;
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
    }

    h2 {
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #444;
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

    .icon-preview {
        font-size: 3rem;
        margin-top: 10px;
        color: #198754;
    }
</style>

<div class="container">
    <div class="form-container">
        <h2>Edit Service</h2>
        <form method="POST">
            <!-- Icon -->
            <div class="mb-3">
                <label class="form-label">Icon Class (Bootstrap Icon)</label>
                <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($service['icon']); ?>" data-validation="required">
                <div class="error" id="iconError"></div>
                <div class="icon-preview">
                    <i class="<?= htmlspecialchars($service['icon']); ?>"></i>
                </div>
                <small class="text-muted">Example: <code>bi bi-gear</code>, <code>bi bi-laptop</code></small>
            </div>

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Service Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($service['title']); ?>" data-validation="required">
                <div class="error" id="titleError"></div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Service Description</label>
                <textarea name="description" class="form-control" rows="4" data-validation="required"><?= htmlspecialchars($service['description']); ?></textarea>
                <div class="error" id="descriptionError"></div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <a href="admin_service.php" class="btn btn-secondary btn-custom">Cancel</a>
                <button type="submit" name="updateService" class="btn btn-primary btn-custom">Update Service</button>
            </div>
        </form>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>
