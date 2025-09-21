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
<script>
    function increase_cart(id) {
        $.ajax({
            url: 'increase_cart.php',
            type: 'post',
            data: {
                id: id
            },
            success: function(data) {
                // alert(data);
                location.reload();
            }
        });
    }

    function decrease_cart(id) {
        // alert(id);
        $.ajax({
            url: 'decrease_cart.php',
            type: 'post',
            data: {
                id: id
            },
            success: function(data) {
                // alert(data);
                location.reload();
            }
        });
    }
</script>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fc;
        color: #333;
    }

    h3.text-center {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 2rem;
        color: #222;
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
        box-shadow: 0px 12px 24px rgba(0, 0, 0, 0.12);
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
        color: #444;
    }

    .cart-item p {
        font-size: 1rem;
        font-weight: 600;
        color: #e63946;
    }

    .input-group .btn {
        border-radius: 0.75rem !important;
        font-size: 1.2rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .input-group .btn:hover {
        transform: scale(1.1);
    }

    .input-group input {
        border-radius: 0.75rem !important;
        font-weight: 600;
        font-size: 1rem;
        background: #fff;
        border: 1px solid #e63946;
        color: #e63946;
    }

    .remove-btn {
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: #e63946;
        color: #fff;
        box-shadow: 0 6px 16px rgba(230, 57, 70, 0.3);
    }

    .card-body {
        padding: 2rem;
    }

    .card-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #222;
    }

    .col-lg-4 .card {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.08);
    }

    .card-body strong {
        font-size: 1.2rem;
    }

    .btn-outline-danger {
        border-radius: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #ff6f61, #e63946);
        color: #fff;
        border: none;
        box-shadow: 0 6px 20px rgba(230, 57, 70, 0.3);
    }


    .text-secondary {
        font-size: 1.1rem;
        font-weight: 500;
        opacity: 0.8;
    }

    .out-of-stock {
        opacity: 0.6;
        filter: grayscale(80%);
    }

    .out-of-stock .badge {
        font-size: 0.9rem !important;
        border-radius: 1rem;
        font-weight: 600;
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
    <h3 class="text-center">Shopping Cart</h3>
    <br>
    <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
            <?php
            $sub_total = 0;
            if (mysqli_num_rows($cart_result) == 0) {
            ?>
                <br>
                <h5 class='text-center text-secondary flex align-item-center' style="align-items:center;">Your Cart is Empty</h5>
                <?php
            } else {

                while ($cart_data = mysqli_fetch_assoc($cart_result)) {
                    $product_id = $cart_data['product_id'];
                    $product_data = "select * from products where id='$product_id'";
                    $product_data = mysqli_fetch_assoc(mysqli_query($con, $product_data));
                    $product_image = $product_data['main_image'];
                ?>
                    <div class="card cart-item mb-3 <?php if ($product_data['quantity'] == 0) {
                                                        echo "out-of-stock";
                                                    } ?>">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <div class="overflow-hidden">
                                        <img src="images/products/<?php echo $product_image; ?>" class="img-fluid product-img" alt="Product" width="100">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <h5 class="card-title"><?php echo $product_data['product_name']; ?></h5>
                                    <p class="text-danger fw-bold mb-0">₹<?php echo round($cart_data['total_price']) ?></p>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="input-group mb-3" style="width: 150px;">
                                            <button class="btn btn-danger me-2" onclick="decrease_cart(<?php echo $cart_data['product_id']; ?>)"><i class="bi bi-dash"></i></button>
                                            <input type="text" class="form-control text-center btn btn-outline-danger me-2" value="<?php echo $cart_data['quantity']; ?>" min="1" readonly>
                                            <button class="btn btn-danger me-2" onclick="increase_cart(<?php echo $cart_data['product_id']; ?>)"><i class="bi bi-plus"></i></button>
                                        </div>
                                        <?php if ($product_data['quantity'] == 0) {
                                            $sub_total = $sub_total + 0;
                                        ?>
                                            <p class="text-danger mb-0 fw-bold badge p-2 btn btn-outline-danger" style="font-size: large;">Out of Stock</p>
                                        <?php
                                        } else {
                                            $sub_total += $cart_data['total_price'];
                                        ?>
                                            <a href="remove_from_cart.php?id=<?php echo $cart_data['product_id']; ?>"><button class="btn btn-outline-danger remove-btn btn-sm mb-3"><i class="bi bi-trash"></i>
                                                    Remove </button></a>
                                        <?php
                                        }


                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>


        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span><?php echo $sub_total; ?></span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>

                        <?php
                        if ($sub_total == 0 || $sub_total > 1000000) {
                            $shipping_cost = 0;
                        } else {
                            $shipping_cost = 50;
                        }
                        ?>
                        <span>Rs. <?php echo $shipping_cost; ?> </span>
                    </div>
                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total</strong>
                        <strong class="text-danger"><?php
                                                    $cart_total = $sub_total + $shipping_cost;
                                                    echo "Rs. " . $cart_total . ".00";
                                                    ?></strong>
                    </div>

                    <a href="checkout.php"><button class="btn btn-outline-danger w-100 mb-3">Proceed to
                            Checkout</button></a>
                    <a href="products.php"><button class="btn btn-outline-danger w-100">Continue
                            Shopping</button></a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include 'footer.php';
$_SESSION['cart_total'] = $sub_total;
$_SESSION['shipping_cost'] = $shipping_cost; ?>