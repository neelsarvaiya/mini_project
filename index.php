<?php include 'header.php'; ?>

<?php

$sql = "SELECT p.*,c.category_name FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE p.status='active' AND c.category_status = 'active' AND
        p.product_name IN('Banana (Robusta)','Potato','Mango (Alphonso)','Amul Milk (Toned)','Croissant','Tata Salt')";

$result = $con->query($sql);

?>


<section class="banner-sec mt-3" style="background-image: url(images/products/header-bg.png);">
    <div class="container">
        <div class="header-main-text">
            <h3>FLAT ₹20 OFF On Your First Order</h3>
            <h1>Your Daily Dose of Freshness, Delivered.</h1>
            <p>Experience the joy of farm-fresh vegetables, seasonal fruits, and all your daily essentials delivered
                right to your home in Rajkot. Skip the queues and enjoy quality you can trust.</p>
            <div class="nav-btn mt-4"><a href="">Shop Now</a></div>
        </div>
    </div>
</section>

<main>

    <section class="product-sec">
        <div class="container">
            <div class="text-center">
                <h2 class="title">Our Bestsellers</h2>
                <p class="subtitle mx-auto mb-5">These are the products our Rajkot families love the most. Fresh,
                    high-quality, and always in demand!</p>
            </div>

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
                                        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="action-btn" title="Add to Cart">
                                            <i class="bi bi-cart-plus"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="add_to_wishlist.php?id=<?= $product['id'] ?>" class="action-btn"
                                        title="Add to Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#" class="action-btn" title="Quick View"><i class="bi bi-eye"></i></a>
                                </div>

                                <div class="product-image">
                                    <img src="images/products/<?= $product['main_image'] ?>"
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
                                    <p class="text-success" style="font-size: 13px;"><?= $product['description'] ?></p>

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
    </section>

    <section class="seasonal-offers-sec">
        <div class="container">
            <div class="text-center">
                <h2 class="title">Your Festive Feast Starts Here!</h2>
                <p class="subtitle mx-auto mb-5">Celebrate Navratri & Diwali with our hand-picked essentials. Fresh
                    ingredients for a joyous celebration, with savings you'll love.</p>
            </div>

            <div class="row g-4">

                <?php

                $today = date('Y-m-d');

                $deactive_offer = "SELECT end_date FROM offers WHERE end_date <= '$today'";
                $res = mysqli_query($con, $deactive_offer);

                if($res->num_rows > 0){
                    mysqli_query($con, "UPDATE offers SET status = 'inactive' WHERE end_date <= '$today'");
                }

                $offer_query = "SELECT o.*, c.category_name 
                        FROM offers o
                    JOIN categories c ON o.category_id = c.id
                        WHERE o.status='active'
                    AND (o.start_date IS NULL OR o.start_date <= '$today')
                    AND (o.end_date IS NULL OR o.end_date >= '$today') ";

                $offer_result = mysqli_query($con, $offer_query);

                while ($offer = mysqli_fetch_assoc($offer_result)) {
                    ?>
                    <div class="col-lg-6">
                        <div class="offer-card">
                            <div class="offer-image"
                                style="background-image: url('images/products/<?= $offer['image']; ?>');">
                            </div>
                            <div class="offer-content">
                                <h4><?php echo $offer['title']; ?></h4>
                                <?php
                                if (!empty($offer['end_date'])) {
                                    $today = new DateTime();
                                    $end_date = new DateTime($offer['end_date']);
                                    $interval = $today->diff($end_date);

                                    if ($interval->invert == 0) {
                                        echo "<p class='text-white mt-3'>Only {$interval->days} day(s) left!</p>";
                                    } else {
                                        echo "<p class='text-muted'>Offer expired</p>";
                                    }
                                }
                                ?>
                                <a href="products.php?category=<?= $offer['category_id'] ?>" class="btn mt-3">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </section>

    <section class="farmer-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="farmer-img-wrapper">
                        <img src="https://uifaces.co/our-content/donated/xP_YIYn2.jpg"
                            alt="Ramesh Bhai, a local farmer from near Gondal, Gujarat" class="farmer-img">
                    </div>
                </div>
                <div class="col-lg-6 farmer-content">
                    <h5 class="subtitle">Farmer Spotlight</h5>
                    <h2 class="fw-bold">Straight From the Farm to Your Family</h2>
                    <p class="text-muted mt-3">
                        We believe in transparency and quality. That's why we partner directly with local farmers
                        like **Ramesh Bhai from near Gondal**, who has been cultivating the land for over 30 years.
                        His passion for natural farming ensures that the groundnuts and garlic you receive are not
                        only fresh but also full of authentic flavor.
                    </p>

                    <div class="farmer-stats">
                        <div class="stat-item text-center">
                            <i class="bi bi-calendar-check"></i>
                            <h5>30+ Years</h5>
                            <p>Experience</p>
                        </div>
                        <div class="stat-item text-center">
                            <i class="bi bi-tree"></i>
                            <h5>100% Natural</h5>
                            <p>Farming</p>
                        </div>
                        <div class="stat-item text-center">
                            <i class="bi bi-geo-alt"></i>
                            <h5>Local Saurashtra</h5>
                            <p>Produce</p>
                        </div>
                    </div>

                    <a href="#" class="btn btn-story mt-4">
                        Learn Our Story <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-3 section-title">Trusted by Families in Rajkot</h2>
            <p class="lead section-subtitle mx-auto">Here’s what our happy customers have to say about our
                commitment to freshness.</p>
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="testimonial-card">
                            <img src="https://uifaces.co/our-content/donated/xP_YIYn2.jpg" class="testimonial-img"
                                alt="Priya S.">
                            <div class="rating-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i></div>
                            <p>"The quality is consistently amazing and the service is always so quick!"</p>
                            <h6 class="customer-name">- Priya S.</h6><small class="customer-location">University
                                Road, Rajkot</small>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="testimonial-card">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-img"
                                alt="Rohan P.">
                            <div class="rating-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                    class="bi bi-star-fill"></i></div>
                            <p>"FreshPick is a lifesaver. Their Navratri essentials I ordered were top-notch. Highly
                                recommended!"</p>
                            <h6 class="customer-name">- Rohan P.</h6><small class="customer-location">Kalawad Road,
                                Rajkot</small>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span
                        class="visually-hidden">Previous</span></button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                    data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span
                        class="visually-hidden">Next</span></button>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>