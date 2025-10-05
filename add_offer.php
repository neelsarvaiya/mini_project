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
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .form-control:focus {
        border-color: #6610f2;
        box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
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

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add New Offer</h2>
        <a href="admin_offer.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card p-4">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category_id" id="category" class="form-control">
                    <?php
                    $cat_query = "SELECT * FROM categories";
                    $cat_result = mysqli_query($con, $cat_query);
                    while ($cat = mysqli_fetch_assoc($cat_result)) {
                        echo "<option value='{$cat['id']}'>{$cat['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="offer_title" class="form-label">Offer Title</label>
                <input type="text" name="offer_title" id="offer_title" class="form-control" placeholder="Enter Offer Title" data-validation="required">
                <div class="error" id="offer_titleError"></div>
            </div>

            <div class="mb-3">
                <label for="offer_title" class="form-label">Offer Image</label>
                <input type="file" name="offer_image" id="offer_image" class="form-control" placeholder="Enter Offer Title" data-validation="required file file2">
                <div class="error" id="offer_imageError"></div>
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-control" min="1" max="100" placeholder="Enter Discount Percentage" data-validation="required">
                <div class="error" id="discountError"></div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" name="saveOffer" class="btn btn-primary btn-custom">Save Offer</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST['saveOffer'])) {
    $category_id = $_POST['category_id'];
    $offer_title =  $_POST['offer_title'];
    $discount = $_POST['discount'];
    $status = $_POST['status'];

    if (!empty($_FILES['offer_image']['name'])) {
        $image = time() . "_" . basename($_FILES['offer_image']['name']);
        $targetFile = "images/products/" . $image;
        move_uploaded_file($_FILES['offer_image']['tmp_name'], $targetFile);
    }

    $query = "INSERT INTO offers (category_id, title, discount, image, status) 
              VALUES ('$category_id', '$offer_title', '$discount', '$image' ,'$status')";

    if (mysqli_query($con, $query)) {
?>
        <script>
            alert('Offer Added Successfully.');
            window.location.href = 'admin_offer.php';
        </script>
    <?php
    } else {
    ?>
        <script>
            alert('Failed to Add Offer.');
            window.location.href = 'admin_offer.php';
        </script>
<?php
    }
}
?>

<?php include_once('admin_footer.php'); ?>