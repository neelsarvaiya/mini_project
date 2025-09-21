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
        <h2 class="mb-0">Edit Product</h2>
        <a href="admin_product.php" class="btn btn-secondary btn-custom">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <?php
            $id = $_GET['id'];
            $sql = "SELECT * FROM products WHERE id = $id";
            $result = mysqli_query($con, $sql);

            if ($result->num_rows == 0) {
                echo "<div class='alert alert-danger'>Product not found.</div>";
                exit;
            }

            $product = mysqli_fetch_assoc($result);

            if (isset($_POST['updateProduct'])) {
                $product_name = $_POST['product_name'];
                $category_id  = $_POST['category_id'];
                $price        = $_POST['price'];
                $unit        = $_POST['unit'];
                $quantity     = $_POST['quantity'];
                $discount     = $_POST['discount'];
                $status       = $_POST['status'];
                $description  = $_POST['description'];
                $discounted_price = $price - ($discount * $price / 100);


                $main_image = $product['main_image'];

                if (!empty($_FILES['main_image']['name'])) {
                    $targetDir = "images/products/";
                    $newImage = time() . "_" . basename($_FILES['main_image']['name']);
                    $targetFile = $targetDir . $newImage;

                    if (move_uploaded_file($_FILES['main_image']['tmp_name'], $targetFile)) {
                        if (!empty($product['main_image']) && file_exists("images/products/" . $product['main_image'])) {
                            unlink("images/products/" . $product['main_image']);
                        }
                        $main_image = $newImage;
                    }
                }

                $updateSQL = "UPDATE products SET 
                    product_name = '$product_name',
                    main_image   = '$main_image',
                    category_id  = '$category_id',
                    price        = '$price',
                    unit        = '$unit',
                    description  = '$description',
                    quantity     = '$quantity',
                    status       = '$status',
                    discount     = '$discount',
                    discounted_price     = '$discounted_price',
                    updated_at   = NOW()
                    WHERE id = $id";

                if (mysqli_query($con, $updateSQL)) {
            ?>
                    <script>
                        alert('Product updated successfully.');
                        window.location.href = 'admin_product.php';
                    </script>
            <?php
                } else {
                    echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
                }
            }
            ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="product_name" class="form-control" data-validation="required alpha"
                            value="<?= $product['product_name'] ?>">
                        <div class="error" id="product_nameError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control">
                            <?php
                            $catQuery = mysqli_query($con, "SELECT * FROM categories");
                            while ($cat = mysqli_fetch_assoc($catQuery)) {
                                $selected = ($cat['id'] == $product['category_id']) ? "selected" : "";
                                echo "<option value='{$cat['id']}' $selected>{$cat['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" data-validation="required"
                            value="<?= $product['price'] ?>">
                        <div class="error" id="priceError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control" data-validation="required"
                            value="<?= $product['unit'] ?>">
                        <div class="error" id="unitError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" data-validation="required numeric"
                            value="<?= $product['quantity'] ?>">
                        <div class="error" id="quantityError"></div>

                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" data-validation="required numeric"
                            value="<?= $product['discount'] ?>">
                        <div class="error" id="discountError"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" <?= ($product['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($product['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" data-validation="required"><?= $product['description'] ?></textarea>
                        <div class="error" id="descriptionError"></div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="main_image" class="form-control" data-validation="file file2">
                        <div class="error" id="main_imageError"></div>
                        <?php if (!empty($product['main_image'])) { ?>
                            <img src="images/products/<?= $product['main_image'] ?>" class="preview-img mt-2">
                        <?php } ?>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" name="updateProduct" class="btn btn-primary btn-custom">
                        <i class="bi bi-save"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>