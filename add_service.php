<?php
include_once('admin_header.php');

if (isset($_POST['addService'])) {
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    $insert = "INSERT INTO services (icon, title, description) VALUES ('$icon', '$title', '$description')";
    if (mysqli_query($con, $insert)) {
?>
        <script>
            alert('Service added successfully!');
            window.location.href = 'admin_service.php';
        </script>
    <?php
    } else {
    ?>
        <script>
            alert('Failed to add service!');
            window.location.href = 'admin_service.php';
        </script>
<?php
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
        <h2>Add New Service</h2>
        <form method="POST">
            <!-- Icon -->
            <div class="mb-3">
                <label class="form-label">Icon Class (Bootstrap Icon)</label>
                <input type="text" name="icon" id="iconInput" class="form-control" placeholder="e.g., bi bi-truck" data-validation="required">
                <div class="error" id="iconError"></div>
                <div class="icon-preview">
                    <i id="iconPreview"></i>
                </div>
                <small class="text-muted">Example: <code>bi bi-truck</code>, <code>bi bi-shop</code>, <code>bi bi-credit-card-2-front</code></small>
            </div>

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Service Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter service title" data-validation="required">
                <div class="error" id="titleError"></div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Service Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Enter short description" data-validation="required"></textarea>
                <div class="error" id="descriptionError"></div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <a href="admin_service.php" class="btn btn-secondary btn-custom">Cancel</a>
                <button type="submit" name="addService" class="btn btn-success btn-custom">Add Service</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('iconInput').addEventListener('input', function() {
        document.getElementById('iconPreview').className = this.value;
    });
</script>

<?php include_once('admin_footer.php'); ?>