<?php include_once('admin_header.php'); ?>
<style>
/* Background */
body {
    background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
    font-family: 'Poppins', sans-serif;
}

/* Card Design */
.reply-card {
    max-width: 800px;
    margin: 50px auto;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    padding: 40px;
    animation: fadeInUp 0.8s ease;
}

/* Heading */
.reply-card h2 {
    text-align: center;
    font-size: 26px;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
    position: relative;
}
.reply-card h2::after {
    content: "";
    display: block;
    width: 60px;
    height: 4px;
    background: linear-gradient(90deg, #74ebd5, #4facfe);
    margin: 12px auto 0;
    border-radius: 10px;
}

/* Labels & Text */
.reply-card label {
    font-weight: 600;
    color: #222;
    display: block;
    margin-bottom: 5px;
}
.reply-card p {
    background: #f8faff;
    padding: 10px 15px;
    border-radius: 10px;
    border: 1px solid #e5e9f2;
    margin-bottom: 15px;
}

/* Textarea */
.reply-card textarea {
    border-radius: 12px;
    border: 1px solid #ddd;
    transition: 0.3s ease;
}
.reply-card textarea:focus {
    border-color: #4facfe;
    box-shadow: 0 0 8px rgba(79,172,254,0.5);
}

/* Buttons */
.btn-custom {
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease-in-out;
}
.btn-send {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
    border: none;
}
.btn-send:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}
.btn-back {
    background: #eee;
    color: #444;
    border: none;
}
.btn-back:hover {
    background: #ddd;
}

/* Animation */
@keyframes fadeInUp {
    from {opacity: 0; transform: translateY(40px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>

<div class="reply-card">
    <h2>📩 Reply to Inquiry</h2>
    <?php
    if (!isset($_GET['id'])) {
        die("<p style='color:red;'>Invalid Request</p>");
    }

    $id = intval($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM contact_inquiry WHERE id = $id");
    if (!$query || mysqli_num_rows($query) == 0) {
        die("<p style='color:red;'>Inquiry not found</p>");
    }
    $data = mysqli_fetch_assoc($query);
    ?>
    <form method="post">
        <div class="mb-3">
            <label><i class="fas fa-user"></i> Name:</label>
            <p><?= htmlspecialchars($data['name']); ?></p>
        </div>
        <div class="mb-3">
            <label><i class="fas fa-envelope"></i> Email:</label>
            <p><?= htmlspecialchars($data['email']); ?></p>
        </div>
        <div class="mb-3">
            <label><i class="fas fa-tag"></i> Subject:</label>
            <p><?= htmlspecialchars($data['subject']); ?></p>
        </div>
        <div class="mb-3">
            <label><i class="fas fa-comment-dots"></i> Message:</label>
            <p><?= htmlspecialchars($data['message']); ?></p>
        </div>
        <div class="mb-3">
            <label for="msg"><i class="fas fa-reply"></i> Your Response:</label>
            <textarea name="msg" id="msg" class="form-control" rows="5" placeholder="Type your stylish reply..." data-validation="required"></textarea>
            <div class="error" id="msgError"></div>
        </div>
        <div class="text-center">
            <button type="submit" name="response_btn" class="btn btn-custom btn-send me-2">🚀 Send Response</button>
            <a href="admin_contact_query.php" class="btn btn-custom btn-back">⬅ Back</a>
        </div>
    </form>
</div>

<?php
include_once('admin_footer.php');

if (isset($_POST['response_btn'])) {
    $message = mysqli_real_escape_string($con, $_POST['msg']);
    $name = $data['name'];
    $user_subject = $data['subject'];
    $user_query = $data['message'];
    $email = $data['email'];

    $subject = "Response from Admin";
    $body = "
    <html>
    <head>
        <style>
            body { font-family: 'Poppins', sans-serif; background: #f4f8fb; margin: 0; padding: 0; }
            .email-box { max-width: 650px; margin: 30px auto; background: white; border-radius: 12px;
                         padding: 30px; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
            h2 { text-align: center; color: #4facfe; }
            .highlight { font-weight: bold; color: #4facfe; }
            .section { background: #f9fcff; padding: 15px; border-left: 5px solid #4facfe;
                       border-radius: 8px; margin: 15px 0; }
            .footer { text-align: center; font-size: 14px; margin-top: 20px; color: #555; }
        </style>
    </head>
    <body>
        <div class='email-box'>
            <h2>💡 FreshPick Support</h2>
            <p>Dear <span class='highlight'>$name</span>,</p>
            <p>Thank you for contacting us. Below is our response to your inquiry:</p>

            <div class='section'>
                <p><strong>📌 Subject:</strong> $user_subject</p>
                <p><strong>📩 Your Query:</strong> $user_query</p>
                <p><strong>📝 Response:</strong> <span class='highlight'>$message</span></p>
            </div>

            <p>If you have further questions, feel free to reply to this email anytime.</p>
            <div class='footer'>
                <p>📞 +1-234-567-890 | ✉ support@freshpick.com</p>
                <p>© 2025 FreshPick</p>
            </div>
        </div>
    </body>
    </html>";

    if (sendEmail($email, $subject, $body, "")) {
        mysqli_query($con, "UPDATE contact_inquiry SET reply = '$message' WHERE id = $id");
        echo "<script>alert('Response sent successfully!'); window.location.href='admin_contact_query.php';</script>";
        exit;
    } else {
        echo "<script>alert('Failed to send email.');</script>";
    }
}
?>
