<?php include_once('header.php');

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

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
            <div class="col-md-4 col-sm-6">
                <div class="wishlist-card">
                    <img src="images/product1.jpg" alt="Product" class="wishlist-image">
                    <div class="wishlist-body">
                        <h5>Stylish Headphones</h5>
                        <p>Wireless over-ear headphones with crystal clear sound.</p>
                        <div class="price">$120</div>
                        <div class="wishlist-actions">
                            <button class="btn-cart"><i class="bi bi-cart-plus me-1"></i> Move to Cart</button>
                            <button class="btn-remove"><i class="bi bi-trash me-1"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="wishlist-card">
                    <img src="images/product1.jpg" alt="Product" class="wishlist-image">
                    <div class="wishlist-body">
                        <h5>Stylish Headphones</h5>
                        <p>Wireless over-ear headphones with crystal clear sound.</p>
                        <div class="price">$120</div>
                        <div class="wishlist-actions">
                            <button class="btn-cart"><i class="bi bi-cart-plus me-1"></i> Move to Cart</button>
                            <button class="btn-remove"><i class="bi bi-trash me-1"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="wishlist-card">
                    <img src="images/product1.jpg" alt="Product" class="wishlist-image">
                    <div class="wishlist-body">
                        <h5>Stylish Headphones</h5>
                        <p>Wireless over-ear headphones with crystal clear sound.</p>
                        <div class="price">$120</div>
                        <div class="wishlist-actions">
                            <button class="btn-cart"><i class="bi bi-cart-plus me-1"></i> Move to Cart</button>
                            <button class="btn-remove"><i class="bi bi-trash me-1"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>