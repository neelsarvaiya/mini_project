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

    .preview-img {
        max-width: 150px;
        border-radius: 10px;
        margin-top: 10px;
    }
</style>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Offer</h2>
        <a href="admin_offer.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <?php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>window.location.href='admin_offer.php';</script>";
        exit;
    }

    $id = $_GET['id'];
    $offer = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM offers WHERE id='$id'"));

    if (!$offer) {
        echo "<script>alert('Offer not found');window.location.href='admin_offer.php';</script>";
        exit;
    }
    ?>

    <div class="card p-4">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category_id" id="category" class="form-control">
                    <?php
                    $cat_query = "SELECT * FROM categories";
                    $cat_result = mysqli_query($con, $cat_query);
                    while ($cat = mysqli_fetch_assoc($cat_result)) {
                        $selected = ($offer['category_id'] == $cat['id']) ? "selected" : "";
                        echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="offer_title" class="form-label">Offer Title</label>
                <input type="text" name="offer_title" id="offer_title" class="form-control" data-validation="required"
                       value="<?= htmlspecialchars($offer['title']); ?>">
                       <div class="error" id="offer_titleError"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Offer Image</label>
                <input type="file" name="offer_image" class="form-control" data-validation="file file2">
                <div class="error" id="offer_imageError"></div>
                <?php if (!empty($offer['image'])) { ?>
                    <div>
                        <img src="images/products/<?= $offer['image']; ?>" class="preview-img">
                    </div>
                <?php } ?>
            </div>

            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" name="discount" id="discount" class="form-control" data-validation="required"
                       min="1" max="100" value="<?= $offer['discount']; ?>">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active" <?= ($offer['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?= ($offer['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>

            <button type="submit" name="updateOffer" class="btn btn-primary btn-custom">Update Offer</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST['updateOffer'])) {
    $category_id = $_POST['category_id'];
    $offer_title = $_POST['offer_title'];
    $discount = $_POST['discount'];
    $status = $_POST['status'];
    $image = $offer['image'];

    if (!empty($_FILES['offer_image']['name'])) {
        $newImage = time() . "_" . basename($_FILES['offer_image']['name']);
        $targetFile = "images/products/" . $newImage;

        if (move_uploaded_file($_FILES['offer_image']['tmp_name'], $targetFile)) {
            if (!empty($offer['image']) && file_exists("images/products/" . $offer['image'])) {
                unlink("images/products/" . $offer['image']);
            }
            $image = $newImage;
        }
    }

    $update_query = "UPDATE offers 
                     SET category_id='$category_id', title='$offer_title', discount='$discount', image='$image', status='$status' 
                     WHERE id='$id'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Offer Updated Successfully.');window.location.href='admin_offer.php';</script>";
    } else {
        echo "<script>alert('Failed to Update Offer.');window.location.href='admin_offer.php';</script>";
    }
}
?>

<?php include_once('admin_footer.php'); ?>
