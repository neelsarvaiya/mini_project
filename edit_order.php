<?php include_once('admin_header.php'); ?>

<style>
    body {
        background: linear-gradient(135deg, #f5f6fa, #e8ecf7);
        font-family: 'Poppins', sans-serif;
    }

    .edit-card {
        max-width: 600px;
        margin: 60px auto;
        border-radius: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        background: #fff;
        padding: 30px 40px;
    }

    h2 {
        font-weight: 700;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    label {
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    select {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ced4da;
        width: 100%;
        font-size: 1rem;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    select:focus {
        border-color: #6610f2;
        box-shadow: 0 0 8px rgba(102, 16, 242, 0.3);
        outline: none;
    }

    .btn-save {
        border-radius: 50px;
        padding: 0.7rem 2rem;
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        color: #fff;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
    }

    .back-btn {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #0d6efd;
        text-decoration: none;
        font-weight: 500;
    }

    .back-btn:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <?php
    if (isset($_GET['id'])) {
        $order_id = $_GET['id'];
        $query = mysqli_query($con, "SELECT o.*, r.firstname, r.lastname FROM orders o JOIN registration r ON o.user_id = r.id WHERE o.id = '$order_id'");
        $order = mysqli_fetch_assoc($query);

        if (!$order) {
            echo "<div class='alert alert-danger mt-5 text-center'>Order not found.</div>";
            exit;
        }

        if (isset($_POST['update_status'])) {
            $new_status = mysqli_real_escape_string($con, $_POST['order_status']);
            $update_query = "UPDATE orders SET order_status = '$new_status' WHERE id = '$order_id'";

            if (mysqli_query($con, $update_query)) {
    ?>
                <script>
                    alert('Order status updated successfully.');
                    window.location.href = 'admin_order.php';
                </script>
            <?php
            } else {
            ?>
                <script>
                    alert('Failed to update status. Try again.');
                    window.location.href = 'admin_order.php';
                </script>
    <?php
            }
        }
    } else {
        echo "<div class='alert alert-warning mt-5 text-center'>Invalid order ID.</div>";
        exit;
    }
    ?>

    <div class="card edit-card">
        <h2><i class="bi bi-pencil-square"></i> Edit Order Status</h2>

        <form method="post">
            <div class="mb-3">
                <label>Order Number</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($order['order_number']); ?>" disabled>
            </div>

            <div class="mb-3">
                <label>User Name</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($order['firstname'] . ' ' . $order['lastname']); ?>" disabled>
            </div>

            <div class="mb-3">
                <label>Total Amount (₹)</label>
                <input type="text" class="form-control" value="₹<?= number_format($order['total_amount'], 2); ?>" disabled>
            </div>

            <div class="mb-4">
                <label for="order_status">Order Status</label>
                <select name="order_status" id="order_status" required>
                    <option value="Pending" <?= $order['order_status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Delivered" <?= $order['order_status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                </select>
            </div>

            <button type="submit" name="update_status" class="btn-save">Save Changes</button>
        </form>

        <a href="admin_order.php" class="back-btn"><i class="bi bi-arrow-left"></i> Back to Orders</a>
    </div>
</div>

<?php include_once('admin_footer.php'); ?>