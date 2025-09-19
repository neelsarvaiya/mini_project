<?php
include("db_connect.php");

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $query = "SELECT * FROM registration WHERE email='$email' AND token='$token' AND status='Inactive'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        $update = "UPDATE registration SET status='Active' WHERE email='$email'";
        if ($con->query($update)) {
            setcookie('success', 'Your account has been verified successfully. You can now login.', time() + 2, '/');
        } else {
            setcookie('error', 'Something went wrong. Please try again later.', time() + 2, '/');
        }
?>
        <script>
            window.location.href = 'login.php';
        </script>
    <?php
    } else {
        setcookie('error', 'Invalid or expired verification link.', time() + 2, '/');
    ?>
        <script>
            window.location.href = 'login.php';
        </script>
    <?php
    }
} else {
    setcookie('error', 'Invalid request.', time() + 2, '/');
    ?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}
?>