<?php
include 'header.php';

$categoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;
$searchQuery = isset($_POST['q']) ? trim($_POST['q']) : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : null;

// Base SQL
$sql = "SELECT 
    p.id, 
    p.product_name, 
    p.price, 
    p.discount, 
    p.main_image, 
    p.quantity, 
    p.unit,
    p.description,
    p.category_id,
    c.category_name,
    AVG(r.rating) AS avg_rating,
    COUNT(r.id) AS total_reviews
FROM products p
JOIN categories c ON p.category_id = c.id
LEFT JOIN reviews r ON p.id = r.product_id
WHERE p.status = 'active'";

if ($categoryId) {
    $sql .= " AND p.category_id=$categoryId";
}

if ($searchQuery) {
    $searchQueryEscaped = $con->real_escape_string($searchQuery);
    $sql .= " AND p.product_name LIKE '%$searchQueryEscaped%'";
}

$sql .= " GROUP BY p.id";

if ($sort == 1) {
    $sql .= " ORDER BY (p.price - (p.price * p.discount / 100)) DESC";
} elseif ($sort == 0) {
    $sql .= " ORDER BY (p.price - (p.price * p.discount / 100)) ASC";
} elseif ($sort == 'top_rated') {
    $sql .= " ORDER BY avg_rating DESC";
} else {
    $sql .= " ORDER BY p.id DESC";
}

$result = $con->query($sql);

// Active offers
$today = date('Y-m-d');
$offer_query = "SELECT * FROM offers 
                WHERE status='active' 
                AND (start_date IS NULL OR start_date <= '$today')
                AND (end_date IS NULL OR end_date >= '$today')";
$offer_result = $con->query($offer_query);

$active_offers = [];
while ($offer = $offer_result->fetch_assoc()) {
    $active_offers[$offer['category_id']] = $offer;
}

// Category colors
$colors = [
    'Fruits' => 'text-danger',
    'Vegetables' => 'text-success',
    'Dairy' => 'text-primary',
    'Eggs' => 'text-warning',
    'Bakery' => 'text-brown',
    'Oils & Spices' => 'text-orange',
    'Meat & Seafood' => 'text-danger',
    'Household Essentials' => 'text-dark'
];

// Fetch categories for sidebar
$categoryRes = $con->query("SELECT id, category_name AS name, icon FROM categories WHERE category_status='active' ORDER BY id ASC");
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="shop-title">🛒 Our Shop</h2>
            <p class="shop-subtitle">Fresh & Organic Groceries Delivered to You</p>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar p-4 bg-white rounded-3 shadow-sm">
                    <h4 class="mb-4 fw-bold">Filter & Sort</h4>

                    <!-- Category Filter -->
                    <div class="filter-group mb-3">
                        <div class="filter-group-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true">
                            <span class="fw-bold">Category</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="collapse show mt-2" id="collapseCategory">
                            <ul class="list-unstyled mb-0">
                                <?php while ($category = $categoryRes->fetch_assoc()):
                                    $colorClass = $colors[$category['name']] ?? 'text-dark'; ?>
                                    <li>
                                        <a href="products.php?category=<?= $category['id'] ?>" class="d-flex align-items-center">
                                            <i class="bi <?= $category['icon'] ?> me-2 <?= $colorClass ?>"></i>
                                            <?= $category['name'] ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="filter-group mb-3">
                        <div class="filter-group-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#collapseSort" aria-expanded="true" role="button">
                            <span class="fw-bold">Sort By</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <?php
                        $params = [];
                        if (isset($_GET['category'])) {
                            $params[] = 'category=' . $_GET['category'];
                        }
                        if (isset($_POST['q']) && !empty($_POST['q'])) {
                            $params[] = 'q=' . urlencode($_POST['q']);
                        }
                        $queryString = !empty($params) ? '&' . implode('&', $params) : '';
                        ?>

                        <div class="collapse show mt-2" id="collapseSort">
                            <ul class="list-unstyled mb-0">
                                <li><a href="products.php?sort=1<?= $queryString ?>" class="d-block">Price: High to Low</a></li>
                                <li><a href="products.php?sort=0<?= $queryString ?>" class="d-block">Price: Low to High</a></li>
                                <li><a href="products.php?sort=top_rated<?= $queryString ?>" class="d-block">Top Rated</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Search -->
                    <form action="products.php" method="post">
                        <div class="mb-4 mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" id="q" name="q" class="form-control"
                                    placeholder="e.g. Organic Apples">
                                <button class="btn btn-success" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Section -->
            <div class="col-lg-9">
                <div class="row g-4">
                    <?php
                    if ($result->num_rows > 0):
                        while ($product = $result->fetch_assoc()):
                            $originalPrice = $product['price'];
                            $productDiscount = $product['discount'];
                            $finalPrice = $originalPrice;
                            $save = 0;

                            // Product-level discount
                            if ($productDiscount > 0) {
                                $finalPrice -= ($finalPrice * $productDiscount / 100);
                                $save = $originalPrice - $finalPrice;
                            }

                            // Category-level offer
                            $catDiscount = 0;
                            $offerEndDate = null;
                            if (isset($active_offers[$product['category_id']])) {
                                $catDiscount = $active_offers[$product['category_id']]['discount'];
                                $finalPrice -= ($finalPrice * $catDiscount / 100);
                                $save = $originalPrice - $finalPrice;
                                $offerEndDate = $active_offers[$product['category_id']]['end_date'];
                            }

                            $avgRating = round($product['avg_rating'] ?? 0, 1);
                            $totalReviews = $product['total_reviews'] ?? 0;
                    ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product-card">
                                <?php if ($productDiscount > 0 || $catDiscount > 0): ?>
                                    <span class="discount-badge">-<?= $productDiscount + $catDiscount ?>% Off</span>
                                <?php endif; ?>

                                <div class="product-actions">
                                    <?php if ($product['quantity'] > 0): ?>
                                        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="action-btn" title="Add to Cart">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="add_to_wishlist.php?id=<?= $product['id'] ?>" class="action-btn" title="Add to Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="details.php?id=<?= $product['id'] ?>" class="action-btn" title="Quick View"><i class="bi bi-eye"></i></a>
                                </div>

                                <div class="product-image">
                                    <img src="images/products/<?= $product['main_image'] ?>" alt="<?= $product['product_name'] ?>">
                                </div>

                                <div class="product-info-new">
                                    <div class="top-meta">
                                        <span class="category"><?= $product['category_name'] ?></span>
                                        <span class="<?= ($product['quantity'] > 0) ? 'text-success' : 'text-danger'; ?>"
                                            style="font-size: 12px; font-weight: 600;">
                                            <?= ($product['quantity'] > 0) ? "In Stock" : "Out of Stock"; ?>
                                        </span>
                                    </div>

                                    <h5><a href="#" class="title"><?= $product['product_name'] ?></a></h5>
                                    <p class="text-success" style="font-size: 13px;"><?= $product['description'] ?></p>

                                    <div class="rating">
                                        <span class="stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi <?= ($i <= floor($avgRating))
                                                    ? 'bi-star-fill'
                                                    : (($i - $avgRating < 1 && $i - $avgRating > 0)
                                                        ? 'bi-star-half'
                                                        : 'bi-star') ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                        <span>(<?= $totalReviews ?> Reviews)</span>
                                    </div>

                                    <div class="price-container">
                                        <div class="prices">
                                            <span class="new-price text-success">₹<?= round($finalPrice); ?>/<?= $product['unit']; ?></span>
                                            <?php if ($save > 0): ?>
                                                <span class="text-muted" style="font-size: 11px;">M.R.P</span>
                                                <span class="old-price text-muted text-decoration-line-through">₹<?= round($originalPrice); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($save > 0): ?>
                                            <span class="save-badge">Save ₹<?= round($save); ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-3 text-center">
                                        <?php if ($offerEndDate):
                                            $todayDT = new DateTime();
                                            $endDT = new DateTime($offerEndDate);
                                            $interval = $todayDT->diff($endDT);
                                            if ($interval->invert == 0): ?>
                                                <span class="text-danger" style="font-weight: 700;">Only <?= $interval->days ?> day(s) left!</span>
                                            <?php endif; endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; else: ?>
                        <p class='text-center mt-5 fw-600'>No products found in this category.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
