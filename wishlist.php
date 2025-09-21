<?php include_once('header.php');

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

$email = $_SESSION['user'];
$wishlist = "select * from wishlist where email='$email'";
$wishlist_result1 = mysqli_query($con, $wishlist);
$wishlist_rows = mysqli_num_rows($wishlist_result1);
?>

<style>
    body {
        background: #f6f9fc;
        font-family: 'Poppins', sans-serif;
    }

    .wishlist-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .wishlist-title {
        font-weight: 700;
        text-align: center;
        font-size: 2.2rem;
        margin-bottom: 2rem;
        color: #6c4ed2;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .wishlist-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.12);
    }

    .wishlist-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 1.2rem;
        border-top-right-radius: 1.2rem;
        transition: 0.3s ease-in-out;
    }

    .wishlist-card:hover .wishlist-image {
        transform: scale(1.05);
    }

    .wishlist-body {
        padding: 1.5rem;
    }

    .wishlist-body h5 {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .wishlist-body p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .price {
        font-weight: 700;
        font-size: 1.1rem;
        color: #6c4ed2;
        /* theme purple */
        margin-bottom: 1rem;
    }

    .wishlist-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .wishlist-actions button {
        flex: 1;
        border: none;
        padding: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .btn-cart {
        background: linear-gradient(90deg, #667eea, #6c4ed2);
        color: #fff;
    }

    .btn-cart:hover {
        background: linear-gradient(90deg, #6c4ed2, #667eea);
        transform: scale(1.05);
    }

    .btn-remove {
        background: #f8d7da;
        color: #a71d2a;
    }

    .btn-remove:hover {
        background: #f5c6cb;
        transform: scale(1.05);
    }
</style>

<div class="wishlist-container">
    <h2 class="wishlist-title">My Wishlist</h2>
    <div class="wishlist-grid">
        <div class="row">
            <?php
            if ($wishlist_rows > 0) {

                while ($wishlist_result = $wishlist_result1->fetch_assoc()) {
                    $product_id = $wishlist_result['product_id'];
                    $product_data = "select * from products where id='$product_id'";
                    $product_result = mysqli_fetch_assoc(mysqli_query($con, $product_data));
            ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product-card">
                            <?php
                            $originalPrice = $product_result['price'];
                            $finalPrice = $product_result['price']; // adjust if you have discount logic
                            $discountPercent = ($originalPrice > $finalPrice) ? round((($originalPrice - $finalPrice) / $originalPrice) * 100) : 0;
                            $save = $originalPrice - $finalPrice;
                            ?>

                            <?php if ($discountPercent > 0): ?>
                                <span class="discount-badge">-<?= $discountPercent ?>% Off</span>
                            <?php endif; ?>

                            <div class="product-actions">
                                <a href="add_to_cart.php?id=<?= $product_result['id'] ?>" class="action-btn" title="Move to Cart">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                                <a href="remove_from_wishlist.php?id=<?= $product_result['id'] ?>" class="action-btn" title="Remove">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>

                            <div class="product-image">
                                <img src="images/products/<?= $product_result['main_image'] ?>" alt="<?= $product_result['product_name'] ?>">
                            </div>

                            <div class="product-info-new">
                                <div class="top-meta">
                                    <span class="category"><?= $product_result['category_name'] ?? '' ?></span>
                                    <span class="<?= ($product_result['quantity'] > 0) ? 'text-success' : 'text-danger'; ?>"
                                        style="font-size: 12px; font-weight: 600;">
                                        <?= ($product_result['quantity'] > 0) ? "In Stock" : "Out of Stock"; ?>
                                    </span>
                                </div>

                                <h5><a href="#" class="title"><?= $product_result['product_name'] ?></a></h5>

                                <div class="rating">
                                    <span class="stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </span>
                                    <span class="review-count">(reviews 125)</span>
                                </div>

                                <div class="price-container">
                                    <div class="prices">
                                        <span class="new-price text-success">
                                            ₹<?= $product_result['discounted_price']  ?><?= $product_result['unit']; ?>
                                        </span>

                                        <?php if ($discountPercent > 0): ?>
                                            <span class="text-muted" style="font-size: 11px;">M.R.P</span>
                                            <span class="old-price text-muted text-decoration-line-through">
                                                ₹<?= round($originalPrice); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($save > 0): ?>
                                        <span class="save-badge">Save ₹<?= round($save); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                }
            } else {
                ?>
                <h2>No Product Fond in Whishlist</h2>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>