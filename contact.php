<?php include 'header.php' ?>

<!-- Contact Hero Section -->
<section class="contact-hero py-5 text-center text-white">
    <div class="container">
        <h1 class="fw-bold">Contact Us</h1>
        <p>We’re here to help! Reach out for any queries or support.</p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="contact-info p-4 shadow-sm rounded">
                    <h3 class="fw-bold mb-4">Get in Touch</h3>
                    <p><i class="bi bi-geo-alt-fill text-success"></i> 123 Fresh Street, Green City, India</p>
                    <p><i class="bi bi-envelope-fill text-success"></i> support@freshpick.com</p>
                    <p><i class="bi bi-telephone-fill text-success"></i> +91 98765 43210</p>
                    <p><i class="bi bi-clock-fill text-success"></i> Mon - Sat: 8:00 AM - 9:00 PM</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="contact-form p-4 shadow-sm rounded">
                    <h3 class="fw-bold mb-4">Send Us a Message</h3>
                    <form action="send_message.php" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control" name="subject" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success w-100">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Google Map -->
<section class="map-section">
    <div class="container-fluid px-0">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24481.75524536903!2d70.77637710682365!3d22.28832837458996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959c98ac71cdf0f%3A0x76dd15cfbe93ad3b!2sRajkot%2C%20Gujarat!5e1!3m2!1sen!2sin!4v1758039686536!5m2!1sen!2sin" 
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<?php include 'footer.php'; ?>