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
        {
        $quantity = $cart_data['quantity'] - 1;
        if($quantity==0)
        {
            setcookie('error', 'Minimum quantity must be 1', time() + 2,'/');
            exit();
        }
        $total_price = $product_data['discounted_price'] * $quantity;
        $update_cart = "update cart set quantity=$quantity, total_price=$total_price where product_id=$id and email='$email'";
        $res = mysqli_query($con, $update_cart);
        if ($res) {
            echo "success";
        } else {
            echo "error";
        }
    }
}
