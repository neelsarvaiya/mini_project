<?php include 'header.php'; ?>
<?php
$query = "SELECT * FROM services ORDER BY id ASC";
$result = mysqli_query($con, $query);
?>
<section class="py-5 bg-light text-center">
    <div class="container">
        <h1 class="fw-bold">Our Services</h1>
        <p class="text-muted">We make grocery shopping easier, fresher, and faster for you.</p>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($service = mysqli_fetch_assoc($result)): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card text-center p-4">
                            <div class="icon">
                                <i class="bi <?php echo $service['icon']; ?>"></i>
                            </div>
                            <h5 class="fw-bold mt-3"><?php echo $service['title']; ?></h5>
                            <p class="text-muted"><?php echo $service['description']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No services available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>