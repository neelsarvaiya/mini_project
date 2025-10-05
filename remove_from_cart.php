<?php
include "header.php";

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please log in to access this page.', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

$email = $_SESSION['user'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $q = "delete from cart where product_id='$id' and email='$email'";
    if (mysqli_query($con, $q)) {
        setcookie('success', 'Product removed from cart successfully', time() + 2,'/');
?>
        <script>
            window.location.href = "cart.php";
        </script>
    <?php
    } else {
        setcookie('error', 'Error in removing product from cart.', time() + 2 ,'/');
    ?>
        <script>
            window.location.href = "cart.php";
        </script>
<?php
    }
}
