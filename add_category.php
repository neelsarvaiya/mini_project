<?php include_once('admin_header.php'); ?>

<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-weight: 500;
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
        <h2 class="mb-0">Add Category</h2>
        <a href="admin_category.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <?php
            if (isset($_POST['addCategory'])) {
                $icon = $_POST['icon'];
                $category_name = $_POST['category_name'];
                $status = $_POST['status'];

                $insertSQL = "INSERT INTO categories (icon, category_name, category_status) 
                              VALUES ('$icon', '$category_name', '$status')";

                if (mysqli_query($con, $insertSQL)) {
                    echo "<script>alert('Category added successfully.'); window.location.href='admin_category.php';</script>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                }
            }
            ?>

            <form action="" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" class="form-control" data-validation="required">
                        <div class="error" id="iconError"></div>
                        <small class="text-muted">Example: <code>bi bi-star</code></small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" data-validation="required">
                        <div class="error" id="category_nameError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" name="addCategory" class="btn btn-primary btn-custom">
                        <i class="bi bi-plus-circle"></i> Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>