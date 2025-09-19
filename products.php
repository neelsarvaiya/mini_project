<?php include 'header.php';

$sql = "SELECT p.*, c.category_name AS category_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id WHERE status = 'active' order by id DESC";
$result = $con->query($sql);

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

                    <form method="GET" action="">

                        <div class="filter-group mb-3">
                            <!-- Header -->
                            <div class="filter-group-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true"
                                role="button">
                                <span class="fw-bold">Category</span>
                                <i class="bi bi-chevron-down"></i>
                            </div>

                            <!-- Collapsible Body -->
                            <div class="collapse show mt-2" id="collapseCategory">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#" class="d-flex align-items-center"><i
                                                class="bi bi-basket-fill me-2 text-danger"></i> Fresh Meat</a></li>
                                    <li><a href="#" class="d-flex align-items-center"><i
                                                class="bi bi-basket me-2 text-success"></i> Vegetables</a></li>
                                    <li><a href="#" class="d-flex align-items-center"><i
                                                class="bi bi-basket2-fill me-2 text-warning"></i> Fruits & Nut Gifts</a>
                                    </li>
                                    <li><a href="#" class="d-flex align-items-center"><i
                                                class="bi bi-egg-fried me-2 text-primary"></i> Butter & Eggs</a></li>
                                    <li><a href="#" class="d-flex align-items-center"><i
                                                class="bi bi-droplet me-2 text-info"></i> Ocean Foods</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="filter-group mb-3">
                            <div class="filter-group-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#collapseSort" aria-expanded="true"
                                role="button">
                                <span class="fw-bold">Sort By</span>
                                <i class="bi bi-chevron-down"></i>
                            </div>

                            <div class="collapse show mt-2" id="collapseSort">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="?sort=rating-high" class="d-block"> Price: High to Low</a></li>
                                    <li><a href="?sort=rating-low" class="d-block"> Price: Low to High</a></li>
                                    <li><a href="?sort=top-rated" class="d-block"> Top Rated</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-4 mt-4">
                            <div class="input-group">
                                <input type="text" id="searchInput" name="q" class="form-control"
                                    placeholder="e.g. Organic Apples">
                                <button class="btn btn-success" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="bi bi-funnel-fill me-2"></i> Apply Filters
                        </button>

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
                                        <img src="img/products/<?= $product['main_image'] ?>"
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
                                                    <span class="old-price text-muted text-decoration-line-through">M.R.P
                                                        ₹<?= round($originalPrice); ?></span>
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
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>
</section>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFilters" aria-labelledby="offcanvasFiltersLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFiltersLabel">Filter & Sort</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form>
            <div class="mb-4">
                <label for="categorySelectMobile" class="form-label fw-bold">Category</label>
                <select id="categorySelectMobile" class="form-select">
                    <option selected>All Categories</option>
                    <option>Vegetables</option>
                    <option>Fruits</option>
                    <option>Dairy</option>
                    <option>Staples</option>
                    <option>Snacks</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="sortSelectMobile" class="form-label fw-bold">Sort by</label>
                <select id="sortSelectMobile" class="form-select">
                    <option selected>Popularity</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>By Rating</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="searchInputMobile" class="form-label fw-bold">Search</label>
                <input type="text" id="searchInputMobile" class="form-control" placeholder="e.g. Organic Apples">
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-filter">Apply Filters</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>