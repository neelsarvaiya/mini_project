<?php
include_once("header.php");

if (!isset($_SESSION['user'])) {
    setcookie('error', 'You can add products to cart only after login', time() + 2);
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}

$email = $_SESSION['user'];
$id = $_POST['id'] ?? $_GET['id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;
$action = $_POST['action'] ?? 'add'; // default = add

if (!$id) {
    setcookie('error', 'Invalid product', time() + 2);
    echo "<script>window.location.href = 'products.php';</script>";
    exit;
}

// ✅ Fetch product data
$productQuery = "SELECT * FROM products WHERE id=$id";
$productData = mysqli_fetch_assoc(mysqli_query($con, $productQuery));

if (!$productData) {
    setcookie('error', 'Product not found', time() + 2);
    echo "<script>window.location.href = 'products.php';</script>";
    exit;
}

// ✅ Check stock availability
if ($quantity > $productData['quantity']) {
    setcookie('error', 'Product not available in requested quantity', time() + 2);
    echo "<script>window.location.href = 'cart.php';</script>";
    exit;
}

// ✅ Fetch active category offer
$today = date('Y-m-d');
$offerQuery = "SELECT * FROM offers WHERE category_id={$productData['category_id']} 
                AND status='active' 
                AND (start_date IS NULL OR start_date <= '$today') 
                AND (end_date IS NULL OR end_date >= '$today') LIMIT 1";
$offerData = mysqli_fetch_assoc(mysqli_query($con, $offerQuery));

// ✅ Calculate discounted price dynamically
$finalPrice = $productData['price'];

// Product-level discount
if ($productData['discount'] > 0) {
    $finalPrice -= ($finalPrice * $productData['discount'] / 100);
}

// Category-level offer
if ($offerData) {
    $finalPrice -= ($finalPrice * $offerData['discount'] / 100);
}

// ✅ Total price for requested quantity
$totalPrice = $finalPrice * $quantity;

// ✅ Check if product already in cart
$checkCart = "SELECT * FROM cart WHERE product_id='$id' AND email='$email'";
$res = mysqli_query($con, $checkCart);

if (mysqli_num_rows($res) > 0) {
    $cartRow = mysqli_fetch_assoc($res);
    $newQuantity = $cartRow['quantity'];

    // Handle actions
    if ($action === 'increase') {
        $newQuantity++;
    } elseif ($action === 'decrease') {
        $newQuantity--;
    } else { // default add
        $newQuantity += $quantity;
    }

    // ✅ Apply restrictions
    if ($newQuantity > 5) {
        setcookie('error', 'Cannot add more than 5 products to cart', time() + 2);
    } elseif ($newQuantity > $productData['quantity']) {
        setcookie('error', 'Sorry, Product not available in stock', time() + 2);
    } elseif ($newQuantity < 1) {
        setcookie('error', 'Minimum quantity must be 1', time() + 2);
    } else {
        $updateCart = "UPDATE cart 
                       SET quantity=$newQuantity, total_price=" . ($finalPrice * $newQuantity) . " 
                       WHERE product_id='$id' AND email='$email'";
        if (mysqli_query($con, $updateCart)) {
            setcookie('success', 'Cart updated successfully', time() + 2);
        } else {
            setcookie('error', 'Error updating cart', time() + 2);
        }
    }
} else {
    // Insert new product
    $insertCart = "INSERT INTO cart (product_id, email, quantity, total_price) 
                   VALUES ('$id', '$email', '$quantity', $totalPrice)";
    if (mysqli_query($con, $insertCart)) {
        setcookie('success', 'Product added to cart', time() + 2);
    } else {
        setcookie('error', 'Error adding product to cart', time() + 2);
    }
}

echo "<script>window.location.href = 'cart.php';</script>";
include_once("footer.php");
?>