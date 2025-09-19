<?php
session_start();

if (isset($_SESSION["user"])) {
    unset($_SESSION['user']);
}

if (isset($_SESSION["admin"])) {
    unset($_SESSION['admin']);
}
?>
<script>
    window.location.href = "login.php";
</script>