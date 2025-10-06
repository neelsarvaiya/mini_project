<?php
include_once('db_connect.php');
include_once('mailer.php');
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
$lastname = mysqli_real_escape_string($con, $_POST['lastname']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$address = mysqli_real_escape_string($con, $_POST['address']);

$user_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM registration WHERE email='$email'"));
$user_id = $user_data['id'];

$order_number = 'ORD' . time();

// fetch cart items
$cartItemsArr = [];
$cartItems = mysqli_query($con, "SELECT c.*, p.product_name, p.price, p.discounted_price 
                                 FROM cart c 
                                 JOIN products p ON c.product_id = p.id 
                                 WHERE c.email='$email'");
while ($item = mysqli_fetch_assoc($cartItems)) {
    $cartItemsArr[] = [
        'product_id' => $item['product_id'],
        'product_name' => $item['product_name'],
        'quantity' => $item['quantity'],
        'price' => $item['total_price']
    ];
}
$items_json = mysqli_real_escape_string($con, json_encode($cartItemsArr));

// insert order
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

$order_id = mysqli_insert_id($con);

// clear cart
mysqli_query($con, "DELETE FROM cart WHERE email='$email'");

// fetch order with user info (include items)
$sql_order = "SELECT 
    o.id AS order_id,
    o.order_number,
    o.items,
    o.total_amount,
    o.order_status,
    o.created_at,
    r.firstname,
    r.lastname,
    r.email,
    r.address,
    r.mobile,
    p.id AS product_id,
    p.product_name,
    p.discounted_price,
    jt.quantity
FROM orders o
JOIN registration r ON o.user_id = r.id
JOIN JSON_TABLE(
    o.items,
    '$[*]' COLUMNS (
        product_id INT PATH '$.product_id',
        quantity INT PATH '$.quantity'
    )
) AS jt ON TRUE
JOIN products p ON p.id = jt.product_id
WHERE o.id = '$order_id';
";

$result = mysqli_query($con, $sql_order);

$data = null;
$items = [];

while ($row = mysqli_fetch_assoc($result)) {
    if ($data === null) {
        $data = $row; // first row holds general order details
    }

    $items[] = [
        'product_name' => $row['product_name'],
        'discounted_price' => (float) $row['discounted_price'],
        'quantity' => (int) $row['quantity']
    ];
}

require('fpdf/fpdf.php');

function generateOrderPDF($data, $items)
{
    $pdf = new FPDF();
    $pdf->AddPage();

    // COLORS
    $primaryColor = [44, 62, 80];     // Dark Navy
    $secondaryColor = [52, 152, 219]; // Sky Blue
    $lightColor = [236, 240, 241];    // Light Grey

    // HEADER BAR
    $pdf->SetFillColor(...$primaryColor);
    $pdf->Rect(0, 0, 210, 35, 'F');
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 22);
    $pdf->Cell(0, 15, 'GROCERY SHOP', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'INVOICE / ORDER RECEIPT', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetTextColor(0, 0, 0);

    // CUSTOMER DETAILS
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetFillColor(...$secondaryColor);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 8, 'Customer Information', 0, 1, 'L', true);

    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFillColor(...$lightColor);
    $pdf->MultiCell(
        0,
        7,
        "Name: {$data['firstname']} {$data['lastname']}\n" .
        "Email: {$data['email']}\n" .
        "Phone: {$data['mobile']}\n" .
        "Address: {$data['address']}",
        0,
        'L',
        true
    );
    $pdf->Ln(4);

    // ORDER INFO
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetFillColor(...$secondaryColor);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 8, 'Order Information', 0, 1, 'L', true);

    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(
        0,
        7,
        "Order Number: {$data['order_number']}\n" .
        "Order Date: " . date("d-m-Y", strtotime($data['created_at'])) . "\n" .
        "Status: {$data['order_status']}",
        0,
        'L'
    );
    $pdf->Ln(4);

    // ORDER ITEMS TABLE HEADER
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(...$primaryColor);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(70, 10, 'Product', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'Qty', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'Price', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Total', 1, 1, 'C', true);

    // TABLE BODY
    $pdf->SetFont('Arial', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $fill = false;
    $grandTotal = 0;

    foreach ($items as $item) {
        $qty = $item['quantity'];
        $price = $item['discounted_price'];
        $subtotal = $price * $qty;
        $grandTotal += $subtotal;

        $pdf->SetFillColor($fill ? 245 : 255, $fill ? 245 : 255, $fill ? 245 : 255);
        $pdf->Cell(70, 8, $item['product_name'], 1, 0, 'L', true);
        $pdf->Cell(25, 8, $qty, 1, 0, 'C', true);
        $pdf->Cell(35, 8, "Rs. " . round($price, 2), 1, 0, 'R', true);
        $pdf->Cell(40, 8, "Rs. " . round($subtotal, 2), 1, 1, 'R', true);
        $fill = !$fill;
    }

    // SUMMARY
    $shippingCharge = 50;
    $finalTotal = $grandTotal + $shippingCharge;

    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(130, 8, '', 0);
    $pdf->Cell(40, 8, 'Subtotal:', 1, 0, 'R');
    $pdf->Cell(30, 8, "Rs. " . round($grandTotal, 2), 1, 1, 'R');

    $pdf->Cell(130, 8, '', 0);
    $pdf->Cell(40, 8, 'Shipping:', 1, 0, 'R');
    $pdf->Cell(30, 8, "Rs. " . number_format($shippingCharge, 2), 1, 1, 'R');

    $pdf->SetFillColor(...$secondaryColor);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(130, 10, '', 0);
    $pdf->Cell(40, 10, 'Grand Total:', 1, 0, 'R', true);
    $pdf->Cell(30, 10, "Rs. " . round($finalTotal, 2), 1, 1, 'R', true);

    // FOOTER
    $pdf->Ln(15);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'I', 11);
    $pdf->MultiCell(0, 6, "✔ Thank you for shopping with Grocery Shop!\nWe truly appreciate your business.");
    $pdf->Ln(8);

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, 'Grocery Shop, 123 Market Street, City', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Phone: 940-818-6776 | Email: support@groceryshop.com', 0, 1, 'C');

    return $pdf->Output('', 'S');
}

function sendOrderEmail($toEmail, $userName, $pdfData)
{
    $subject = "Order Confirmation - Grocery Shop";
    $body = "<p>Dear $userName,</p>
             <p>Thank you for your order. Please find the invoice attached.</p>
             <p>Regards,<br>Grocery Shop</p>";

    return sendEmail($toEmail, $subject, $body, $pdfData);
}

$pdfData = generateOrderPDF($data, $items);
$emailStatus = sendOrderEmail($data['email'], $data['firstname'], $pdfData);
