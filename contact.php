<?php include 'header.php' ?>

<section class="contact-hero py-5 text-center">
    <div class="container">
        <h1 class="fw-bold">Contact Us</h1>
        <p>We’re here to help! Reach out for any queries or support.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <div class="col-lg-5">
                <div class="contact-info p-4 shadow-sm rounded">
                    <h3 class="fw-bold mb-4">Get in Touch</h3>
                    <p><i class="bi bi-geo-alt-fill text-success"></i> 123 Fresh Street, Green City, India</p>
                    <p><i class="bi bi-envelope-fill text-success"></i> support@freshpick.com</p>
                    <p><i class="bi bi-telephone-fill text-success"></i> +91 98765 43210</p>
                    <p><i class="bi bi-clock-fill text-success"></i> Mon - Sat: 8:00 AM - 9:00 PM</p>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-form p-4 shadow-sm rounded">
                    <h3 class="fw-bold mb-4">Send Us a Message</h3>
                    <form method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" data-validation="required alpha min" data-min="2">
                                <div class="error" id="nameError"></div>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" data-validation="required email">
                                <div class="error" id="emailError"></div>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" data-validation="required numeric min max" data-min="10" data-max="10">
                                <div class="error" id="mobileError"></div>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject" data-validation="required">
                                <div class="error" id="subjectError"></div>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Your Message" data-validation="required"></textarea>
                                <div class="error" id="messageError"></div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success w-100" name="store_inquery">Send Message</button>
                            </div>
                        </div>
                    </form>
                    <?php

                    if (isset($_POST['store_inquery'])) {
                        $name    = $_POST['name'];
                        $email   =  $_POST['email'];
                        $mobile  = $_POST['mobile'];
                        $subject = $_POST['subject'];
                        $message = $_POST['message'];

                        $sql = "INSERT INTO contact_inquiry (name, email, mobile, subject, message) 
            VALUES ('$name', '$email', '$mobile', '$subject', '$message')";

                        if (mysqli_query($con, $sql)) {
                            setcookie("success", "Message sent successfully!", time() + 3, "/");
                            header("Location: contact.php"); // redirect back to contact page
                            exit();
                        } else {
                            // Error
                            setcookie("error", "Failed to send message. Try again.", time() + 3, "/");
                            header("Location: contact.php");
                            exit();
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="map-section">
    <div class="container-fluid px-0">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2262.337439794505!2d-0.17372283040636402!3d51.52959061706136!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761abba8d10fe3%3A0xe65b82528dff9446!2sLord&#39;s%20Cricket%20Ground!5e1!3m2!1sen!2sin!4v1758040737636!5m2!1sen!2sin"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<?php include 'footer.php'; ?>