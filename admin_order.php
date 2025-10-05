<?php include_once('admin_header.php'); ?>

<style>
    body {
        background: linear-gradient(135deg, #f5f6fa, #e8ecf7);
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        font-weight: 700;
        color: #2c3e50;
    }

    .btn-custom {
        border-radius: 50px;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        border: none;
        color: #fff;
    }

    .btn-custom:hover {
        transform: translateY(-3px);
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border: none;
        transition: all 0.3s ease;
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
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.07);
        transition: background 0.3s ease;
    }

    .badge-status {
        padding: 0.5em 1em;
        font-size: 0.9rem;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-pending {
        background: #ffc107;
        color: #000;
    }

    .badge-delivered {
        background: #28a745;
        color: #fff;
    }

    .product-img {
        height: 50px;
        width: 50px;
        object-fit: cover;
        border-radius: 8px;
    }

    .btn-action {
        border-radius: 50px;
        padding: 0.3rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover {
        background: #0dcaf0;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background: #dc3545;
        color: #fff;
    }

    .items-table {
        background: #f8f9fa;
        border-radius: 12px;
        margin-top: 10px;
        padding: 10px 15px;
        box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.05);
    }

    .items-table table {
        margin-bottom: 0;
    }

    .items-table thead {
        background-color: #e9ecef;
        font-weight: 600;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-receipt"></i> Order Management</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>User Name</th>
                            <th>Order Number</th>
                            <th>Items</th>
                            <th>Total (₹)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                    o.id, 
                                    o.order_number, 
                                    o.items, 
                                    o.total_amount, 
                                    o.order_status,
                                    r.firstname, 
                                    r.lastname 
                                FROM orders o
                                JOIN registration r ON o.user_id = r.id
                                ORDER BY o.id DESC";
                        $result = mysqli_query($con, $sql);

                        $sr_no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $items = json_decode($row['items'], true);
                        ?>
                                <tr>
                                    <td><?= $sr_no++; ?></td>
                                    <td><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></td>
                                    <td><?= htmlspecialchars($row['order_number']); ?></td>
                                    <td>
                                        <div class="items-table">
                                            <table class="table table-sm align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Price (₹)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (is_array($items)) {
                                                        foreach ($items as $item) {
                                                            $pid = $item['product_id'];
                                                            $pquery = mysqli_query($con, "SELECT main_image FROM products WHERE id = '$pid'");
                                                            $p = mysqli_fetch_assoc($pquery);
                                                            $image = $p['main_image'] ?? 'no-image.png';
                                                    ?>
                                                            <tr>
                                                                <td><img src="images/products/<?= htmlspecialchars($image); ?>" class="product-img"></td>
                                                                <td><?= htmlspecialchars($item['product_name']); ?></td>
                                                                <td><?= htmlspecialchars($item['quantity']); ?></td>
                                                                <td><?= htmlspecialchars($item['price']); ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td><strong>₹<?= number_format($row['total_amount'], 2); ?></strong></td>
                                    <td>
                                        <?php if ($row['order_status'] == 'Delivered') { ?>
                                            <span class="badge badge-status badge-delivered">Delivered</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-pending">Pending</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_order.php?id=<?= $row['id']; ?>" class="btn btn-outline-info btn-action me-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="deleteOrder" class="btn btn-outline-danger btn-action">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center text-muted py-3'>No orders found</td></tr>";
                        }

                        if (isset($_POST['deleteOrder'])) {
                            $orderId = $_POST['id'];
                            $delete_query = "DELETE FROM orders WHERE id = $orderId";
                            if (mysqli_query($con, $delete_query)) {
                            ?>
                                <script>
                                    alert('Order Deleted Successfully.');
                                    window.location.href = 'admin_order.php';
                                </script>
                            <?php
                            } else {
                            ?>
                                <script>
                                    alert('Failed to Delete Order.');
                                    window.location.href = 'admin_order.php';
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

<?php include_once('admin_footer.php'); ?>