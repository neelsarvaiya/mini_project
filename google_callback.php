<?php
session_start();
include_once('db_connect.php');

$client_id = "652671025707-pl2232vbckj2224jk6fg2cl5v67aoi3p.apps.googleusercontent.com";
$client_secret = "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";
$redirect_uri = "http://localhost/mini_project/google_callback.php";

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Get Access Token
    $token_url = "https://oauth2.googleapis.com/token";
    $post_fields = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        // Get user info from Google
        $user_info = file_get_contents("https://www.googleapis.com/oauth2/v1/userinfo?access_token=$access_token");
        $user = json_decode($user_info, true);

        $email = $user['email'];
        $full_name = $user['name'];

        // Split full name into first and last name
        $name_parts = explode(' ', trim($full_name), 2);
        $first_name = $name_parts[0];
        $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

        // Check if user exists
        $sql = "SELECT * FROM registration WHERE email='$email'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $db_user = mysqli_fetch_assoc($result);
            if ($db_user['role'] == 'user') {
                $_SESSION['user'] = $db_user['email'];
                header("Location: index.php");
            } else {
                $_SESSION['admin'] = $db_user['email'];
                header("Location: admin_dashboard.php");
            }
        } else {
            // New Google user — store basic info in session temporarily
            $_SESSION['google_user'] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email
            ];

            header("Location: complete_profile.php");
            exit;
        }
    } else {
        echo "Google login failed!";
    }
} else {
    echo "No code found!";
}
