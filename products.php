<?php include 'header.php'; ?>

<section class="page-header py-5 text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Our Fresh Products</h1>
        <p class="lead text-muted">Handpicked for quality, delivered with care.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="filter-sidebar d-none d-lg-block">
                    <h4 class="mb-4">Filter & Sort</h4>
                    <form>
                        <div class="mb-4">
                            <label for="categorySelect" class="form-label fw-bold">Category</label>
                            <select id="categorySelect" class="form-select">
                                <option selected>All Categories</option>
                                <option>Vegetables</option>
                                <option>Fruits</option>
                                <option>Dairy</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="sortSelect" class="form-label fw-bold">Sort by</label>
                            <select id="sortSelect" class="form-select">
                                <option selected>Popularity</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="searchInput" class="form-label fw-bold">Search</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="e.g. Organic Apples">
                        </div>
                        <button class="btn btn-primary w-100 btn-filter">Apply Filters</button>
                    </form>
                </div>
                <div class="d-lg-none mb-4 text-end">
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters">
                        <i class="bi bi-funnel-fill me-2"></i> Filter & Sort
                    </button>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card">
                            <div class="product-card__image">
                                <a href="#">
                                    <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?ixlib=rb-4.0.3&q=85&fm=jpg&crop=entropy&cs=srgb&w=400" alt="Fresh Vegetables">
                                </a>
                                <div class="product-card__badge">-10%</div>
                                <button class="product-card__wishlist" data-bs-toggle="tooltip" title="Add to Wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                            <div class="product-card__content">
                                <div class="product-card__details">
                                    <h5 class="product-card__title"><a href="#">Fresh Vegetable Box</a></h5>
                                    <div class="product-card__rating">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                    </div>
                                    <p class="product-card__price">
                                        <span class="old">₹130</span>
                                        <span class="new">₹120</span>
                                    </p>
                                </div>
                                <div class="product-card__action-bar">
                                    <button class="btn btn-add-cart w-100">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>