<?php

include 'header.php';


if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$productId = (int) $_GET['id'];

$sql = "SELECT p.*, c.category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.id = $productId";
$result = $con->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "<p class='text-center mt-5 fw-bold'>Product not found.</p>";
    exit;
}

$active_offers = [];
$offerSql = "SELECT * FROM offers WHERE start_date <= CURDATE() AND end_date >= CURDATE() AND status = 'active'";
$offerResult = $con->query($offerSql);
while ($offer = $offerResult->fetch_assoc()) {
    $active_offers[$offer['category_id']] = $offer;
}

// Price Calculation
$originalPrice = $product['price'];
$productDiscount = $product['discount'];
$finalPrice = $originalPrice;
$save = 0;

// Product-level discount
if ($productDiscount > 0) {
    $finalPrice -= ($finalPrice * $productDiscount / 100);
    $save = $originalPrice - $finalPrice;
}

// Category offer
$catDiscount = 0;
$offerEndDate = null;
if (isset($active_offers[$product['category_id']])) {
    $catDiscount = $active_offers[$product['category_id']]['discount'];
    $finalPrice -= ($finalPrice * $catDiscount / 100);
    $save = $originalPrice - $finalPrice;
    $offerEndDate = $active_offers[$product['category_id']]['end_date'];
}

$reviewSql = "SELECT r.*,rg.firstname,rg.lastname FROM reviews r 
                JOIN registration rg ON r.user_id = rg.id  
                WHERE product_id = $productId ORDER BY created_at DESC";

$reviewResult = $con->query($reviewSql);

$avgSql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM reviews WHERE product_id = $productId";
$avgResult = $con->query($avgSql);
$avgData = $avgResult->fetch_assoc();
$avgRating = $avgData['avg_rating'];
$totalReviews = $avgData['total_reviews'];
?>

<style>
    .discount-badge {
        background: #dc3545;
        color: #fff;
        padding: 5px 8px;
        font-size: 12px;
        border-radius: 6px;
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .save-badge {
        font-size: 12px;
        font-weight: 600;
    }

    .rating i {
        color: #ffc107;
    }

    .review-box {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
</style>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-5">
            <div class="position-relative">
                <?php if ($productDiscount > 0 || $catDiscount > 0): ?>
                    <span class="discount-badge">-<?= $productDiscount + $catDiscount ?>% Off</span>
                <?php endif; ?>
                <img src="images/products/<?= $product['main_image'] ?>" alt="<?= $product['product_name'] ?>"
                    class="img-fluid rounded shadow-sm" style="max-height: 400px; width: 100%; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-7">
            <h3><?= $product['product_name'] ?></h3>
            <p class="text-muted mb-1">Category: <?= $product['category_name'] ?></p>
            <p class="<?= ($product['quantity'] > 0) ? 'text-success' : 'text-danger'; ?>">
                <?= ($product['quantity'] > 0) ? "In Stock" : "Out of Stock"; ?>
            </p>
            <p><?= $product['description'] ?></p>

            <div class="rating mb-2">
                <span class="stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i
                            class="bi <?= ($i <= floor($avgRating)) ? 'bi-star-fill' : (($i - $avgRating < 1 && $i - $avgRating > 0) ? 'bi-star-half' : 'bi-star') ?>"></i>
                    <?php endfor; ?>
                </span>
                <span>(<?= $totalReviews ?> Reviews)</span>
            </div>

            <h4 class="text-success">₹<?= round($finalPrice) ?> / <?= $product['unit']; ?></h4>
            <?php if ($save > 0): ?>
                <p class="text-muted"><del>₹<?= round($originalPrice) ?></del> <span class="save-badge">Save
                        ₹<?= round($save) ?></span></p>
            <?php endif; ?>

            <?php if ($offerEndDate):
                $todayDT = new DateTime();
                $endDT = new DateTime($offerEndDate);
                $interval = $todayDT->diff($endDT);
                if ($interval->invert == 0): ?>
                    <p class="text-danger fw-bold">Offer ends in <?= $interval->days ?> day(s)!</p>
            <?php endif;
            endif; ?>

            <div class="mt-4">
                <?php if ($product['quantity'] > 0): ?>
                    <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn btn-success me-2"><i
                            class="bi bi-cart-plus"></i> Add to Cart</a>
                <?php endif; ?>
                <a href="add_to_wishlist.php?id=<?= $product['id'] ?>" class="btn btn-outline-danger"><i
                        class="bi bi-heart"></i> Wishlist</a>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="row">
        <div class="col-md-8 mx-auto">
            <h3 class="fw-bold text-center mb-5 text-gradient">✨ Customer Reviews ✨</h3>

            <?php if ($totalReviews > 0): ?>
                <?php while ($review = $reviewResult->fetch_assoc()): ?>
                    <div class="review-card mb-4 shadow-sm p-4 rounded-4 bg-white position-relative">
                        <div class="d-flex align-items-start">
                            <!-- User Image -->
                            <img src="<?= !empty($review['user_image']) ? 'images/profile_pictures/' . htmlspecialchars($review['user_image']) : 'images\profile_pictures\68dd6bdac9591_1758786535_u3.jpg' ?>"
                                alt="User Image"
                                class="rounded-circle me-3 review-user-img">

                            <div class="flex-grow-1">
                                <!-- User Name -->
                                <h5 class="mb-1 fw-semibold text-dark"><?= htmlspecialchars($review['firstname'] . " " . $review['lastname']) ?></h5>

                                <!-- Star Rating -->
                                <div class="rating mb-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi <?= ($i <= $review['rating']) ? 'bi-star-fill text-warning' : 'bi-star text-muted' ?>"></i>
                                    <?php endfor; ?>
                                </div>

                                <!-- Review Text -->
                                <p class="mb-2 review-text text-secondary fst-italic">
                                    “<?= htmlspecialchars($review['review_text']) ?>”
                                </p>

                                <!-- Review Date -->
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('d M Y', strtotime($review['created_at'])) ?>
                                </small>
                            </div>
                        </div>

                        <!-- Floating Quote Icon -->
                        <div class="quote-icon">
                            <i class="bi bi-chat-quote-fill text-danger opacity-25"></i>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center text-muted">
                    <i class="bi bi-emoji-smile display-4 d-block mb-3"></i>
                    <h5>No reviews yet.</h5>
                    <p>Be the first to share your experience!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        /* === Review Section Styling === */
        .text-gradient {
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .review-card {
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: linear-gradient(145deg, #fff8f8, #ffffff);
        }

        .review-user-img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border: 3px solid #ff4b2b;
            padding: 2px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.2);
        }

        .review-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #555;
        }

        .rating i {
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .rating i:hover {
            color: #ffc107;
        }

        .quote-icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
        }

        @media (max-width: 576px) {
            .review-user-img {
                width: 55px;
                height: 55px;
            }

            .review-card {
                padding: 1.2rem;
            }
        }
    </style>

</div>

<?php include 'footer.php'; ?>