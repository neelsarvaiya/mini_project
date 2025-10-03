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
    .checkout-form-panel,
    .summary-box-v2 {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .summary-title {
        font-weight: 700;
    }

    .summary-product-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
</style>

<div class="container py-5">

    <div class="section-heading-v2">
        <h2>Secure <span class="highlight-green">Checkout</span></h2>
    </div>

    <div class="row g-5 mt-4">
        <div class="col-lg-8">
            <div class="checkout-form-panel">
                <h4 class="mb-4">Shipping Address</h4>
                <?php

                $email = $_SESSION['user'];
                $q = "select * from registration where email='$email'";
                $user = mysqli_fetch_assoc(mysqli_query($con, $q));

                ?>

                <form id="checkout-form" method="POST">
                    <div class="mb-3">
                        <label for="firstname" class="form-label fw-semibold">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            placeholder="Enter first name" value="<?= $user['firstname']; ?>"
                            data-validation="required alpha min" data-min="2">
                        <div class="error" id="firstnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label fw-semibold">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname"
                            placeholder="Enter last name" data-validation="required alpha"
                            value="<?= $user['lastname']; ?>">
                        <div class="error" id="lastnameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone No.</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            data-validation="required numeric min max" data-min="10" data-max="10"
                            placeholder="Enter 10-digit phone number" value="<?= $user['mobile']; ?>">
                        <div class="error" id="phoneError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <input type="text" class="form-control" id="address" name="address" data-validation="required"
                            placeholder="Enter address" value="<?= $user['address']; ?>">
                        <div class="error" id="addressError"></div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-success p-2" onclick="makePayment()" id="rzp-button1" type="button">
                        Place Order
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-box-v2">
                <h4 class="summary-title d-flex justify-content-between align-items-center">
                    <span>Your Cart</span>
                    <?php

                    if (isset($_SESSION['user'])) {
                        $email = $_SESSION['user'];
                        $result = mysqli_query($con, "SELECT * FROM cart WHERE email='$email'");
                        $cart_count = mysqli_num_rows($result);
                    }
                    ?>
                    <span class="badge bg-secondary rounded-pill"><?= round($cart_count) ?></span>
                </h4>

                <ul class="list-unstyled">
                    <li class="summary-product-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <?php if ($cart_count == 0) { ?>
                                <h5 class='text-center text-secondary flex align-item-center' style="align-items:center;">
                                    Your Cart is Empty
                                </h5>
                                <?php } else {
                                while ($cart_data = mysqli_fetch_assoc($result)) {
                                    $product_id = $cart_data['product_id'];
                                    $product_data = "select * from products where id='$product_id'";
                                    $product_data = mysqli_fetch_assoc(mysqli_query($con, $product_data));
                                    $product_image = $product_data['main_image'];
                                ?>
                    <li class="summary-product-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="images/products/<?= $product_image ?>" alt="Product" width="50" class="me-2">
                            <div class="item-details">
                                <h6 class="my-0"><?= $product_data['product_name'] ?></h6>
                                <small class="text-muted">Qty: <?= $cart_data['quantity'] ?></small>
                            </div>
                        </div>
                        <span class="text-muted">₹ <?= round($cart_data['total_price']) ?></span>
                    </li>
            <?php
                                }
                            } ?>

                </ul>

                <hr class="my-3">

                <div class="summary-total d-flex justify-content-between">
                    <span>Total (INR)</span>
                    <strong>₹ <?= round($_SESSION['cart_total'] + $_SESSION['shipping_cost']); ?></strong>
                </div>

            </div>
        </div>

    </div>
</div>
<?php include_once('footer.php') ?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    function makePayment() {
        const firstname = document.getElementById('firstname').value;
        const lastname = document.getElementById('lastname').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;

        const email = "<?= $user['email']; ?>";
        const amount = <?= round($_SESSION['cart_total'] + $_SESSION['shipping_cost']) ?>; // total in INR

        const options = {
            key: 'rzp_test_RH45AztS9OAD9H',
            amount: amount * 100,
            currency: 'INR',
            name: 'Kanjariya Kirit',
            description: 'Order Payment',
            image: 'your_logo_url',

            handler: function(response) {
                const formData = new URLSearchParams();
                formData.append('payment_id', response.razorpay_payment_id);
                formData.append('firstname', firstname);
                formData.append('lastname', lastname);
                formData.append('phone', phone);
                formData.append('address', address);

                fetch('order.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: formData.toString()
                    })
                    .then(res => res.text())
                    .then(data => {
                        <?php
                        setcookie("success", "🎉 Thank you, ! Your order  has been placed successfully. A copy of your invoice has been sent to Your Eamil. 🚚✨", time() + 2, '/');
                        ?>
                        window.location.href = 'index.php';
                    });
            },

            prefill: {
                name: firstname + ' ' + lastname,
                email: email
            },
            theme: {
                color: '#528FF0'
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();
    }
</script>