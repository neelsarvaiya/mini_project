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

    .preview-img {
        max-width: 150px;
        border-radius: 10px;
        margin-top: 10px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Category</h2>
        <a href="admin_category.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left"></i> Back to Categories
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM categories WHERE id = $id";
            $result = mysqli_query($con, $sql);

            if ($result->num_rows == 0) {
                echo "<div class='alert alert-danger'>Category not found.</div>";
                exit;
            }

            $category = mysqli_fetch_assoc($result);

            if (isset($_POST['updateCategory'])) {

                $icon = $_POST['icon'];
                $category_name = $_POST['category_name'];
                $status = $_POST['status'];

                $updateSQL = "UPDATE categories SET 
                                icon = '$icon',
                                category_name = '$category_name',
                                category_status = '$status'
                                WHERE id = $id";


                if (mysqli_query($con, $updateSQL)) {
                    echo "<script>alert('Category updated successfully.'); window.location.href='admin_category.php';</script>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                }
            }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="icon" class="form-control" data-validation="required"
                            value="<?= $category['icon'] ?>">
                        <div class="error" id="iconError"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" data-validation="required"
                            value="<?= $category['category_name'] ?>">
                        <div class="error" id="category_nameError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?= ($category['category_status'] == 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($category['category_status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" name="updateCategory" class="btn btn-primary btn-custom">
                        <i class="bi bi-save"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>