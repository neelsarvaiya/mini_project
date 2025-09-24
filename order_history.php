<?php
include_once('db_connect.php');
include_once('header.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user'];

// fetch user_id
$userRes = mysqli_query($con, "SELECT id FROM registration WHERE email='$email'");
$userRow = mysqli_fetch_assoc($userRes);
$user_id = $userRow['id'];

// fetch orders
$orders = mysqli_query($con, "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY created_at DESC");
?>

<style>
    body {
        background: #f5f7fb;
        font-family: 'Poppins', sans-serif;
    }

    .order-card {
        margin-bottom: 25px;
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease-in-out;
    }

    .order-card:hover {
        transform: translateY(-4px);
    }

    .order-header {
        background: linear-gradient(135deg, #0d6efd, #3b82f6);
        color: white;
        padding: 15px 20px;
        border-radius: 16px 16px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-header strong {
        font-size: 1.1rem;
    }

    .order-body {
        padding: 20px;
    }

    .order-info p {
        margin: 0 0 6px;
        font-size: 0.95rem;
        color: #444;
    }

    .product-box {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .product-img {
        width: 75px;
        height: 75px;
        border-radius: 12px;
        object-fit: cover;
        margin-right: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
    }

    .product-details {
        flex-grow: 1;
    }

    .product-details strong {
        font-size: 1rem;
        color: #222;
    }

    .product-details p {
        margin: 2px 0;
        font-size: 0.9rem;
        color: #666;
    }

    .review-btn {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        border: none;
        padding: 6px 14px;
        font-size: 0.85rem;
        border-radius: 8px;
        color: white;
        transition: 0.2s;
    }

    .review-btn:hover {
        background: linear-gradient(135deg, #15803d, #16a34a);
        transform: scale(1.05);
    }

    .no-orders {
        text-align: center;
        margin-top: 50px;
        font-size: 1.2rem;
        color: #888;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 fw-bold text-center text-primary">My Order History</h2>

    <?php if (mysqli_num_rows($orders) == 0): ?>
        <p class="no-orders">😢 No orders found. Start shopping now!</p>
    <?php endif; ?>

    <?php while ($order = mysqli_fetch_assoc($orders)): ?>
        <div class="card order-card">
            <div class="order-header">
                <strong>Order #<?= $order['order_number'] ?></strong>
                <span><?= date("d M Y", strtotime($order['created_at'])) ?></span>
            </div>
            <div class="order-body">
                <div class="order-info mb-3">
                    <p><strong>Total:</strong> ₹<?= number_format($order['total_amount'], 2) ?> |
                        <strong>Status:</strong> 
                        <span class="badge bg-<?= $order['order_status']=='Delivered' ? 'success' : 'warning' ?>">
                            <?= $order['order_status'] ?>
                        </span>
                    </p>
                    <p><strong>Shipping Address:</strong> <?= $order['shipping_address'] ?></p>
                </div>

                <h6 class="fw-bold mb-3">🛒 Items in this order:</h6>

                <?php
                $items = json_decode($order['items'], true);
                foreach ($items as $item) {
                    $pid = $item['product_id'];
                    $productRes = mysqli_query($con, "SELECT product_name, main_image, price FROM products WHERE id='$pid'");
                    $product = mysqli_fetch_assoc($productRes);
                ?>
                    <div class="product-box">
                        <img src="images/products/<?= $product['main_image'] ?>" alt="<?= $product['product_name'] ?>" class="product-img">
                        <div class="product-details">
                            <strong><?= $product['product_name'] ?></strong>
                            <p>Qty: <?= $item['quantity'] ?> | Price: ₹<?= $item['price'] ?></p>
                        </div>
                        <a href="review_rating.php" class="review-btn">Review</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include_once('footer.php') ?>
