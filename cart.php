<?php
include 'header.php';

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
    ?>
    <script>
        window.location.href = 'login.php';
    </script>
    <?php
}


$email = $_SESSION['user'];
$q = "select * from cart where email='$email'";
$cart_result = mysqli_query($con, $q);

?>



<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: var(--theme-light-green-bg);
        color: var(--text-dark);
    }

    h4.text-center {
        font-weight: 600;
        margin-bottom: 2rem;
        color: var(--theme-green-darker);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .cart-item {
        border: none;
        border-radius: 1.25rem;
        background: #fff;
        box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cart-item:hover {
        transform: translateY(-3px);
        box-shadow: 0px 12px 24px rgba(55, 168, 71, 0.25);
    }

    .cart-item img {
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }

    .cart-item img:hover {
        transform: scale(1.05);
    }

    .cart-item .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .cart-item p {
        font-size: 1rem;
        font-weight: 600;
    }

    .input-group .btn {
        border-radius: 0.75rem !important;
        font-size: 1.2rem;
        font-weight: 600;
        background: var(--theme-green);
        color: #fff;
        border: none;
        transition: all 0.2s ease;
    }

    .input-group .btn:hover {
        background: var(--theme-green-darker);
        transform: scale(1.1);
    }

    .input-group input {
        border-radius: 0.75rem !important;
        font-weight: 600;
        font-size: 1rem;
        background: #fff;
        border: 1px solid var(--theme-green);
        color: var(--theme-green-darker);
    }

    .remove-btn {
        border-radius: 0.75rem;
        font-weight: 600;
        border: 1px solid #ff0000ff;
        color: #ff0000ff;
        background: transparent;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: red;
        color: #ff0000ff;
        box-shadow: 0 6px 16px rgba(47, 143, 60, 0.3);
    }

    .card-body {
        padding: 2rem;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--theme-green-darker);
    }

    .col-lg-4 .card {
        border: none;
        border-radius: 1.5rem;
        background: #fff;
        box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.08);
    }

    .card-body strong {
        font-size: 1.2rem;
        color: var(--text-dark);
    }

    .btn-outline-danger {
        border-radius: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        border: 1px solid var(--theme-green);
        color: var(--theme-green-darker);
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, var(--theme-green), var(--theme-green-darker));
        color: #fff;
        border: none;
        box-shadow: 0 6px 20px rgba(55, 168, 71, 0.3);
    }

    .text-secondary {
        font-size: 1.1rem;
        font-weight: 500;
        opacity: 0.8;
        color: var(--text-light);
    }

    .out-of-stock {
        opacity: 0.6;
        filter: grayscale(80%);
    }

    .out-of-stock .badge {
        font-size: 0.9rem !important;
        border-radius: 1rem;
        font-weight: 600;
        background: var(--theme-light-green);
        color: var(--text-dark);
    }

    @media (max-width: 768px) {
        h3.text-center {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .input-group {
            width: 120px !important;
        }
    }
</style>


<div class="container">
    <h4 class="text-center mt-4">Shopping Cart</h4>
    <br>
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <?php
            $sub_total = 0;
            if (mysqli_num_rows($cart_result) == 0) {
                echo "<br><h5 class='text-center text-secondary'>Your Cart is Empty</h5>";
            } else {
                while ($cart_data = mysqli_fetch_assoc($cart_result)) {
                    $product_id = $cart_data['product_id'];
                    $product_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM products WHERE id='$product_id'"));
                    $product_image = $product_data['main_image'];
                    $in_stock = $product_data['quantity'] > 0;

                    $sub_total += $cart_data['total_price'];
                    ?>
                    <div class="card cart-item mb-3 <?php echo !$in_stock ? 'out-of-stock' : ''; ?>">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Product Image -->
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="images/products/<?= $product_image ?>" class="img-fluid rounded"
                                        alt="<?= $product_data['product_name'] ?>">
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h5 class="card-title mb-1"><?= $product_data['product_name'] ?></h5>
                                    <?php
                                    $original_total = $product_data['price'] * $cart_data['quantity'];
                                    $discount_amount = $original_total - $cart_data['total_price'];
                                    ?>
                                    <small>Discount:</small> ₹<?= round($discount_amount); ?><br>

                                    <p class="mb-1"><small>Discounted Price:</small>
                                        ₹<?= round($cart_data['total_price']); ?></p>
                                    <small class="text-muted">Price: ₹<?= round($product_data['price']); ?> ×
                                        <?= $cart_data['quantity'] ?></small>

                                    <div class="mt-2">
                                        <?php if ($in_stock): ?>
                                            <span class="text-success fw-600">In Stock</span>
                                        <?php else: ?>
                                            <span class="text-danger fw-600">Out of Stock</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Quantity Controls & Remove -->
                                <div class="col-md-3 d-flex flex-column align-items-center">

                                    <div class="input-group mb-3" style="width: 150px;">
                                        <form action="add_to_cart.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $cart_data['product_id'] ?>">
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="btn btn-sm btn-success me-2">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                        </form>

                                        <input type="text" class="form-control text-center fw-bold"
                                            value="<?= $cart_data['quantity'] ?>" readonly>

                                        <form action="add_to_cart.php" method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $cart_data['product_id'] ?>">
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="btn btn-sm btn-success ms-2">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </form>
                                    </div>


                                    <?php if ($in_stock): ?>
                                        <a href="remove_from_cart.php?id=<?= $product_id ?>" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Remove
                                        </a>
                                    <?php else: ?>
                                        <p class="badge bg-danger mt-2">Unavailable</p>
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

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span>₹<?= round($sub_total) ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <?php $shipping_cost = ($sub_total == 0 || $sub_total > 1000000) ? 0 : 50; ?>
                        <span>₹<?= $shipping_cost ?></span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="text-success">₹<?= round($sub_total + $shipping_cost) ?></strong>
                    </div>

                    <a href="checkout.php" class="btn btn-success w-100 mb-3">Proceed to Checkout</a>
                    <a href="products.php" class="btn btn-success w-100">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php';
$_SESSION['cart_total'] = $sub_total;
$_SESSION['shipping_cost'] = $shipping_cost; ?>