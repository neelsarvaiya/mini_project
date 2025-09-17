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
            echo "<h2 style='color:green; text-align:center;'>✅ Your account has been verified successfully. You can now <a href='login.php'>login</a>.</h2>";
        } else {
            echo "<h2 style='color:red; text-align:center;'>❌ Something went wrong. Please try again later.</h2>";
        }
    } else {
        echo "<h2 style='color:red; text-align:center;'>⚠️ Invalid or expired verification link.</h2>";
    }
} else {
    echo "<h2 style='color:red; text-align:center;'>❌ Invalid request.</h2>";
}
