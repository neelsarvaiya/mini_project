<?php include_once('admin_header.php') ?>
<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
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

    .card {
        border-radius: 1.5rem;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .table {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .table img {
        object-fit: cover;
        transition: transform 0.3s;
    }

    .table img:hover {
        transform: scale(1.1);
    }

    .badge-status {
        padding: 0.5em 0.8em;
        font-size: 0.9rem;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-active {
        background-color: #28a745;
        color: white;
    }

    .badge-inactive {
        background-color: #ffc107;
        color: black;
    }
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Product Management</h2>
        <a href="add_product.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Discount</th>
                            <th>Discounted Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // ✅ Fetch products with category name
                        $sql = "SELECT p.*, c.category_name 
                                FROM products p 
                                LEFT JOIN categories c 
                                ON p.category_id = c.id
                                ORDER BY p.id DESC";

                        $result = mysqli_query($con, $sql);
                        $sr_no = 1;

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= $sr_no++; ?></td>
                                    <td>
                                        <img src="images/products/<?= htmlspecialchars($row['main_image']); ?>"
                                            height="80px" width="80px"
                                            class="rounded shadow-sm">
                                    </td>
                                    <td><?= htmlspecialchars($row['product_name']); ?></td>
                                    <td><?= htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
                                    <td>₹<?= number_format($row['price'], 2); ?></td>
                                    <td><?= htmlspecialchars($row['unit']); ?></td>
                                    <td><?= htmlspecialchars($row['quantity']); ?></td>
                                    <td><?= htmlspecialchars($row['discount']); ?>%</td>
                                    <td>₹<?= number_format($row['discounted_price'], 2); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'active') { ?>
                                            <span class="badge badge-status badge-active">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-inactive">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_product.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info me-1">
                                            Edit
                                        </a>

                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="deleteProduct" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='11' class='text-center'>No products found</td></tr>";
                        }

                        // ✅ Handle delete product
                        if (isset($_POST['deleteProduct'])) {
                            $productId = $_POST['id'];
                            $result = mysqli_query($con, "SELECT main_image FROM products WHERE id = $productId");
                            $product = mysqli_fetch_assoc($result);

                            $delete_query = "DELETE FROM products WHERE id = $productId";
                            if (mysqli_query($con, $delete_query)) {
                                if (!empty($product['main_image']) && file_exists("img/products/" . $product['main_image'])) {
                                    unlink("img/products/" . $product['main_image']);
                                }
                            ?>
                                <script>
                                    alert('Product deleted successfully.');
                                    window.location.href = 'admin_product.php';
                                </script>
                            <?php
                            } else {
                            ?>
                                <script>
                                    alert('Failed to delete product.');
                                    window.location.href = 'admin_product.php';
                                </script>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('admin_footer.php') ?>