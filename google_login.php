<?php
session_start();

$client_id = "";  //YOUR_GOOGLE_CLIENT_ID
$redirect_uri = "http://localhost/mini_project/google_callback.php";
$scope = "email profile";

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&access_type=online&prompt=select_account";

header("Location: $auth_url");
exit();
?>
