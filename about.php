<?php include 'header.php';

$about_query = "SELECT * FROM contact_us LIMIT 1";
$about_result = mysqli_query($con, $about_query);
$about = mysqli_fetch_assoc($about_result);
?>

<section class="about-hero py-5 text-center text-white">
    <div class="container">
        <h1 class="fw-bold">About FreshPick</h1>
        <p>Fresh, Organic & Quality Groceries at Your Fingertips</p>
    </div>
</section>

<!-- About Content -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Image -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <img src="images/products/<?= $about['about_image']; ?>"
                    class="img-fluid rounded-3 shadow" alt="About FreshPick">
            </div>

            <!-- Right Content -->
            <div class="col-lg-6">
                <h2 class="fw-bold">Who We Are</h2>
                <p class="text-muted">
                    <?php echo nl2br($about['about_text']); ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="about-box p-4">
                    <i class="bi bi-bullseye fs-1 text-success"></i>
                    <h4 class="fw-bold mt-3">Our Mission</h4>
                    <p class="text-muted"><?php echo nl2br($about['mission']); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-box p-4">
                    <i class="bi bi-lightbulb fs-1 text-success"></i>
                    <h4 class="fw-bold mt-3">Our Vision</h4>
                    <p class="text-muted"><?php echo nl2br($about['vision']); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>