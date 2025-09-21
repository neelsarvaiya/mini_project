<?php
include "header.php";
if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
    <?php
}
$email = $_SESSION['user'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $q = "delete from wishlist where product_id='$id' and email='$email'";
    if (mysqli_query($con, $q)) {
        setcookie('success', 'Product removed from wishlist', time() + 2);
    ?>
        <script>
            window.location.href = "wishlist.php";
        </script>
    <?php
    } else {
        setcookie('error', 'Error in removing product from wishlist.', time() + 2);
    ?>
        <script>
            window.location.href = "wishlist.php";
        </script>
<?php
    }
}
?>