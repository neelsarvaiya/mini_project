<?php
include_once("header.php");
if (isset($_POST['add_to_cart'])) {
    $quantity = $_POST['quantity'];
    $id = $_POST['id'];
} else {
    $quantity = 1;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
}
if (isset($_SESSION['user'])) {
    $email = $_SESSION['user'];
    $products_data = "select * from products where id=$id";
    $products_data = mysqli_fetch_assoc(mysqli_query($con, $products_data));
    $check_cart = "select * from cart where product_id='$id' and email='$email'";
    $res = mysqli_query($con, $check_cart);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (isset($_POST['add_to_cart'])) {
            $add_quantity = $_POST['quantity'];
        } else {
            $add_quantity = 1;
        }

        $quantity = $row['quantity'] + $add_quantity;
        if ($quantity > 5) {
            setcookie('error', 'Cannot add more than 5 products to cart', time() + 2);
?>
            <script>
                window.location.href = 'cart.php';
            </script>
        <?php
        } else if ($products_data['quantity'] < $quantity) {
            setcookie('error', 'Sorry for the inconvenience, Product not available in stock', time() + 2);
        ?>
            <script>
                window.location.href = 'cart.php';
            </script>
    <?php

        } else {
            $total_price = $products_data['discounted_price'] * $quantity;
            $update_cart = "update cart set quantity='$quantity', `total_price`=$total_price where  product_id='$id' and email='$email'";
            if (mysqli_query($con, $update_cart)) {
                setcookie('success', 'Product Updated in cart', time() + 2);
            } else {
                setcookie('error', 'Error in updating product in cart', time() + 2);
            }
        }
    } else {
        $total_price = $products_data['discounted_price'] * $quantity;
        $add_to_cart = "insert into cart (product_id, email, quantity,total_price) values ('$id', '$email', '$quantity', $total_price)";

        if (mysqli_query($con, $add_to_cart)) {
            setcookie('success', 'Product added to cart', time() + 2);
        } else {
            setcookie('error', 'Error in adding product to cart', time() + 2);
        }
    }
    ?>
    <script>
        window.location.href = 'cart.php';
    </script>
<?php
} else {
    setcookie('error', 'You can add produts to cart only after login', time() + 2);
}

include_once("footer.php");
