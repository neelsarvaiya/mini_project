<?php
include_once('db_connect.php');
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit('Not logged in');
}

if (!isset($_POST['payment_id'])) {
    http_response_code(400);
    exit('Payment ID missing');
}

$payment_id = mysqli_real_escape_string($con, $_POST['payment_id']);

$email = $_SESSION['user'];
$total = $_SESSION['cart_total'];
$shipping = $_SESSION['shipping_cost'];
$grandTotal = $total + $shipping;

$firstname = mysqli_real_escape_string($con, $_POST['firstname']);
$lastname  = mysqli_real_escape_string($con, $_POST['lastname']);
$phone     = mysqli_real_escape_string($con, $_POST['phone']);
$address   = mysqli_real_escape_string($con, $_POST['address']);

$user_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT id FROM registration WHERE email='$email'"));
$user_id = $user_data['id']; 

$order_number = 'ORD' . time();

$cartItemsArr = [];
$cartItems = mysqli_query($con, "SELECT * FROM cart WHERE email='$email'");
while ($item = mysqli_fetch_assoc($cartItems)) {
    $cartItemsArr[] = [
        'product_id' => $item['product_id'],
        'quantity' => $item['quantity'],
        'price' => $item['total_price']
    ];
}
$items_json = mysqli_real_escape_string($con, json_encode($cartItemsArr));


$insertOrder = "
INSERT INTO orders
(user_id, first_name, last_name, phone, order_number, items,
total_amount, order_status, shipping_address, created_at, updated_at)
VALUES (
    '$user_id',
    '$firstname',
    '$lastname',
    '$phone',
    '$order_number',
    '$items_json',
    ROUND($grandTotal),
    'Delivered',
    '$address',
    NOW(),
    NOW()
)";

mysqli_query($con, $insertOrder);

mysqli_query($con, "DELETE FROM cart WHERE email='$email'");

// Optional: send confirmation email here

?>