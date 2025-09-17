<?php include 'header.php'; ?>

<!-- Hero Slider -->
<section class="hero-section pt-5">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.jpg" class="d-block w-100" alt="Fresh Vegetables">
                <div class="carousel-caption">
                    <h2>Fresh Vegetables Everyday</h2>
                    <p>Get the best quality straight from the farms.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/2.jpg" class="d-block w-100" alt="Organic Fruits">
                <div class="carousel-caption">
                    <h2>Organic Fruits</h2>
                    <p>Eat healthy, stay healthy with FreshPick.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/3.png" class="d-block w-100" alt="Dairy Products">
                <div class="carousel-caption">
                    <h2>Fresh Dairy Products</h2>
                    <p>Milk, Cheese & Butter at your doorstep.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- About -->
<section class="about-section py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Welcome to FreshPick</h2>
        <p class="text-muted mb-4">
            FreshPick is your one-stop shop for fresh groceries, organic fruits, vegetables,
            dairy products, and more. We bring the farm freshness directly to your doorstep.
        </p>
        <a href="#" class="btn btn-theme rounded-pill px-4">Shop Now</a>
    </div>
</section>

<!-- Offer Banner -->
<section class="offer-banner py-5 text-center">
    <div class="container">
        <h2 class="fw-bold">Special Offer: Get 20% OFF on First Order!</h2>
        <p>Use code <strong>FRESHPICK20</strong> at checkout.</p>
        <a href="#" class="btn btn-light rounded-pill px-4">Shop Now</a>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <p>"FreshPick delivers the best vegetables I’ve ever bought online. Always fresh and quick service!"</p>
                    <h6 class="fw-bold mt-3 text-success">- Priya Sharma</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <p>"I love their organic fruits! Great quality and affordable prices. Highly recommended."</p>
                    <h6 class="fw-bold mt-3 text-success">- Rohan Patel</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 shadow-sm rounded bg-white h-100">
                    <p>"Their dairy products are always fresh. Delivery is on time and packaging is excellent."</p>
                    <h6 class="fw-bold mt-3 text-success">- Anjali Verma</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter py-5 bg-light">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Subscribe to Our Newsletter</h2>
        <p class="text-muted mb-4">Get updates on fresh arrivals and exclusive discounts.</p>
        <form action="#" class="d-flex justify-content-center" method="post">
            <input type="text" class="form-control w-50 rounded-start-pill" name="email" placeholder="Your Name email" data-validation="required email">
            <div class="error" id="emailError"></div>
            <button class="btn btn-theme rounded-end-pill px-4" type="submit">Subscribe</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>