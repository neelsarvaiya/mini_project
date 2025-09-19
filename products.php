<?php include 'header.php'; ?>

<section class="py-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <div class="filter-sidebar d-none d-lg-block">
                    <h4 class="mb-4 fw-bold">Filter & Sort</h4>
                    <form>
                        <div class="mb-4">
                            <label for="categorySelect" class="form-label fw-bold">Category</label>
                            <select id="categorySelect" class="form-select">
                                <option selected>All Categories</option>
                                <option>Vegetables</option>
                                <option>Fruits</option>
                                <option>Dairy</option>
                                <option>Staples</option>
                                <option>Snacks</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="sortSelect" class="form-label fw-bold">Sort by</label>
                            <select id="sortSelect" class="form-select">
                                <option selected>Popularity</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>By Rating</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="searchInput" class="form-label fw-bold">Search</label>
                            <input type="text" id="searchInput" class="form-control" placeholder="e.g. Organic Apples">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-filter">Apply Filters</button>
                    </form>
                </div>

                <div class="d-lg-none mb-4 text-end">
                    <button class="btn btn-light border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasFilters" aria-controls="offcanvasFilters">
                        <i class="bi bi-funnel-fill me-2"></i> Filter & Sort
                    </button>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row g-4">
                    
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product-card">
                            <span class="discount-badge">-10%</span>
                            <div class="product-actions"><a href="#" class="action-btn" title="Add to Cart"><i
                                        class="bi bi-cart-plus"></i></a><a href="#" class="action-btn"
                                    title="Add to Wishlist"><i class="bi bi-heart"></i></a><a href="#"
                                    class="action-btn" title="Quick View"><i class="bi bi-eye"></i></a></div>
                            <div class="product-image"><img src="img/products/product-img-1.png" alt="Amul Gold Milk">
                            </div>
                            <div class="product-info-new">
                                <div class="top-meta"><span class="category">Dairy</span><span class="stock-status">In
                                        Stock</span></div>
                                <h5><a href="#" class="title">Amul Gold Milk</a></h5>
                                <div class="rating"><span class="stars"><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                            class="bi bi-star-fill"></i><i class="bi bi-star-half"></i></span><span
                                        class="review-count">(125)</span></div>
                                <div class="price-container">
                                    <div class="prices"><span class="new-price">₹33</span><span
                                            class="old-price">₹36</span></div><span class="save-badge">Save ₹3</span>
                                </div>
                            </div>
                        </div>
                    </div>
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