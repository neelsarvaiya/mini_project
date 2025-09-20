<?php include 'header.php';


if (isset($_GET['category'])) {
    $sql = "SELECT p.*, c.category_name AS category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id WHERE category_id = $_GET[category] AND status = 'active'";
    $result = $con->query($sql);

} elseif (isset($_POST['q']) && !empty(trim($_POST['q']))) {
    $searchQuery = $_POST['q'];

    $sql = "SELECT p.*, c.category_name AS category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id WHERE product_name LIKE '%$searchQuery%' AND status = 'active'";

    $result = $con->query($sql);

} else {
    $sql = "SELECT p.*, c.category_name AS category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id WHERE status = 'active' order by id DESC";
    $result = $con->query($sql);
}



if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 1) {
        $orderBy = "(p.price - (p.price * p.discount / 100)) DESC";
    } else {
        $orderBy = "(p.price - (p.price * p.discount / 100)) ASC";
    }

    $sql = "SELECT p.*, c.category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id 
        WHERE p.status = 'active' 
        ORDER BY $orderBy";

    $result = $con->query($sql);
}



$colors = [
    'Fruits' => 'text-danger',
    'Vegetables' => 'text-success',
    'Dairy' => 'text-primary',
    'Eggs' => 'text-warning',
    'Bakery' => 'text-brown',
    'Oils & Spices' => 'text-orange',   // orange 🌶️ (custom CSS if needed)
    'Meat & Seafood' => 'text-danger',  // red 🥩🐟
    'Household Essentials' => 'text-dark' // black 🧹
];


$category = "SELECT id,category_name as name, icon FROM categories WHERE category_status = 'active' ORDER BY id ASC";
$res = $con->query($category);

?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="shop-title">🛒 Our Shop</h2>
            <p class="shop-subtitle">Fresh & Organic Groceries Delivered to You</p>
        </div>

        <div class="row">

            <div class="col-lg-3">
                <div class="filter-sidebar p-4 bg-white rounded-3 shadow-sm">
                    <h4 class="mb-4 fw-bold">Filter & Sort</h4>

                    <div class="filter-group mb-3">
                        <div class="filter-group-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true"
                            role="button">
                            <span class="fw-bold">Category</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <div class="collapse show mt-2" id="collapseCategory">
                            <ul class="list-unstyled mb-0">
                                <?php if ($res->num_rows > 0): ?>
                                    <?php while ($category = $res->fetch_assoc()): ?>
                                        <?php
                                        $colorClass = $colors[$category['name']] ?? 'text-dark';
                                        ?>
                                        <li>
                                            <a href="products.php?category=<?= $category['id'] ?>"
                                                class="d-flex align-items-center">
                                                <i class="bi <?= $category['icon'] ?> me-2 <?= $colorClass ?>"></i>
                                                <?= $category['name'] ?>
                                            </a>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="filter-group mb-3">
                        <div class="filter-group-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#collapseSort" aria-expanded="true" role="button">
                            <span class="fw-bold">Sort By</span>
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <div class="collapse show mt-2" id="collapseSort">
                            <ul class="list-unstyled mb-0">
                                <li><a href="products.php?sort=1" class="d-block">Price: High to Low</a></li>
                                <li><a href="products.php?sort=0" class="d-block">Price: Low to High</a></li>
                                <li><a href="products.php?sort=top_rated" class="d-block">Top Rated</a></li>
                            </ul>

                        </div>
                    </div>

                    <form action="products.php" method="post">
                        <div class="mb-4 mt-4">
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" id="q" name="q" class="form-control" data-validation="required alpha"
                                    placeholder="e.g. Organic Apples">
                                <button class="btn btn-success" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="error" id="qError"></div>
                        </div>
                    </form>

                </div>
            </div>



            <div class="col-lg-9">
                <div class="row g-4">

                    <?php
                    if ($result->num_rows > 0) {
                        while ($product = $result->fetch_assoc()) {
                            $originalPrice = $product['price'];
                            $discountPercent = $product['discount'];
                            $finalPrice = $originalPrice;
                            $save = 0;

                            if ($discountPercent > 0 && $originalPrice > 0) {
                                $finalPrice = $originalPrice - (($originalPrice * $discountPercent) / 100);
                                $discountedPrice[] = round($finalPrice);
                                $save = $originalPrice - $finalPrice;
                            }
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product-card">
                                    <?php if ($discountPercent > 0): ?>
                                        <span class="discount-badge">-<?= $discountPercent ?>% Off</span>
                                    <?php endif; ?>

                                    <div class="product-actions">
                                        <?php if ($product['quantity'] > 0): ?>
                                            <a href="#" class="action-btn" title="Add to Cart">
                                                <i class="bi bi-cart-plus"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="#" class="action-btn" title="Add to Wishlist"><i class="bi bi-heart"></i></a>
                                        <a href="#" class="action-btn" title="Quick View"><i class="bi bi-eye"></i></a>
                                    </div>

                                    <div class="product-image">
                                        <img src="/images/products/<?= $product['main_image'] ?>"
                                            alt="<?= $product['product_name'] ?>">
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
                                                    ₹<?= round($finalPrice); ?>/<?= $product['unit']; ?>
                                                </span>

                                                <?php if ($discountPercent > 0): ?>
                                                    <span class="text-muted" style="font-size: 11px;">M.R.P</span>
                                                    <span
                                                        class="old-price text-muted text-decoration-line-through">₹<?= round($originalPrice); ?></span>
                                                <?php endif; ?>
                                            </div>

                                            <?php if ($save > 0): ?>
                                                <span class="save-badge">
                                                    Save ₹<?= round($save); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='text-center mt-5 fw-600'>No products found in this category.</p>";
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>