<?php include_once('header.php') ?>

<style>
    body {
        background: linear-gradient(135deg, #fdfbfb, #ebedee);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }

    .cart-container {
        margin-top: 80px;
    }

    /* Cart Card */
    .cart-card {
        border-radius: 1.2rem;
        border: none;
        background: #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .cart-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .cart-image {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }

    .cart-image:hover {
        transform: scale(1.1) rotate(-2deg);
    }

    .cart-title {
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 1.1rem;
    }

    .cart-sub {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .cart-price {
        font-size: 1rem;
        font-weight: 700;
        color: #28a745;
    }

    .cart-remove {
        font-size: 0.9rem;
        color: #dc3545;
        cursor: pointer;
        transition: all 0.3s;
    }

    .cart-remove:hover {
        color: #a71d2a;
        text-decoration: underline;
    }

    /* Quantity Selector */
    .qty-selector-v2 {
        background: #f8f9fa;
        border-radius: 50px;
        border: 1px solid #ddd;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .qty-selector-v2:hover {
        background: #eafbee;
        border-color: #28a745;
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.25);
    }

    .qty-btn {
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        font-weight: bold;
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .qty-btn:hover {
        background: #218838;
        transform: scale(1.1);
    }

    .qty-number {
        font-weight: 600;
        font-size: 1rem;
        padding: 0 12px;
        color: #333;
    }

    /* Checkout Summary */
    .summary-card {
        border-radius: 1.5rem;
        background: linear-gradient(135deg, #28a745, #56d879);
        color: #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-6px);
    }

    .summary-card h4 {
        font-weight: 700;
        margin-bottom: 20px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        padding-bottom: 8px;
    }

    .summary-details p {
        margin: 0;
        font-size: 0.95rem;
        display: flex;
        justify-content: space-between;
    }

    .checkout-btn {
        background: #fff;
        color: #28a745;
        font-weight: 600;
        border-radius: 50px;
        padding: 12px 20px;
        transition: all 0.3s ease;
        border: none;
    }

    .checkout-btn:hover {
        background: #f9fdf8;
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(255, 255, 255, 0.3);
    }

    /* Animation */
    .fade-in {
        animation: fadeInUp 0.8s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container cart-container">
    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="cart-card p-4 mb-4 fade-in">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="img/1.jpg" class="cart-image" alt="Product">
                    </div>
                    <div class="col-md-4">
                        <h5 class="cart-title">Fresh Apples</h5>
                        <p class="cart-sub">1kg pack</p>
                        <span class="cart-remove"><i class="bi bi-trash"></i> Remove</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="product-quantity">
                            <div class="d-flex align-items-center">
                                <form action="#" method="POST" class="d-inline">
                                    <button type="submit" class="qty-btn">-</button>
                                </form>

                                <div class="px-2">1</div>

                                <form action="#" method="POST" class="d-inline">
                                    <button type="submit" class="qty-btn">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="cart-price">$10.00</span>
                    </div>
                </div>
            </div>

            <div class="cart-card p-4 mb-4 fade-in" style="animation-delay:0.2s;">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="img/1.jpg" class="cart-image" alt="Product">
                    </div>
                    <div class="col-md-4">
                        <h5 class="cart-title">Organic Bananas</h5>
                        <p class="cart-sub">1 dozen</p>
                        <span class="cart-remove"><i class="bi bi-trash"></i> Remove</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="product-quantity">
                            <div class="d-flex align-items-center">
                                <form action="#" method="POST" class="d-inline">
                                    <button type="submit" class="qty-btn">-</button>
                                </form>

                                <div class="px-2">1</div>

                                <form action="#" method="POST" class="d-inline">
                                    <button type="submit" class="qty-btn">+</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="cart-price">$6.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Summary -->
        <div class="col-lg-4">
            <div class="summary-card p-4 fade-in" style="animation-delay:0.4s;">
                <h4>Order Summary</h4>
                <div class="summary-details mb-4">
                    <p><span>Subtotal</span> <span>$16.00</span></p>
                    <p><span>Delivery</span> <span>$2.00</span></p>
                    <p class="fw-bold mt-2"><span>Total</span> <span>$18.00</span></p>
                </div>
                <button class="checkout-btn w-100">Proceed to Checkout</button>
                <button class="btn btn-outline-light w-100 mt-2 rounded-pill">Continue Shopping</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->

<?php include_once('footer.php') ?>