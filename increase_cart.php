<?php
include "db_connect.php";
session_start();
$email = $_SESSION['user'];
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $cart_result = "select * from cart where product_id='$id' and email='$email'";
    $cart_data = mysqli_query($con, $cart_result);
    $product_result = "select * from products where id='$id'";
    $product_data = mysqli_fetch_assoc(mysqli_query($con, $product_result));
    $cart_data = mysqli_fetch_assoc($cart_data);

    if ($cart_data['quantity'] >= 1) {
        $quantity = $cart_data['quantity'] + 1;
        if ($quantity > 5) {
            setcookie('error', 'Sorry, You cannot buy more than 5 Quantity for a single product', time() + 3);
?>
            <script>
                window.location.href = "view_cart.php";
                exit();
            </script>
        <?php
        } else if ($product_data['quantity'] < $quantity) {
            setcookie('error', 'Sorry for the inconvenience, but the quantity of this product is not available', time() + 3);

        ?>
            <script>
                window.location.href = "view_cart.php";
                exit();
            </script>
<?php
        } else {
            $total_price = $product_data['discounted_price'] * $quantity;
            $update_cart = "update cart set quantity=$quantity, total_price=$total_price where product_id=$id and email='$email'";
            $res = mysqli_query($con, $update_cart);
            if ($res) {
                setcookie('success', 'Product quantity updated in cart', time() + 2,'/');
                echo "success";
            } else {
                setcookie('error', 'Error in updating product quantity in cart', time() + 2, '/');
                echo "error";
            }
        }
    }
}
