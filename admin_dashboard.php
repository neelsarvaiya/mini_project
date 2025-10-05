<?php include_once("admin_header.php"); ?>

<style>
    .card {
        min-height: 160px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        padding: 20px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .card-body i {
        font-size: 2.2rem;
        margin-right: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .card-body h5 {
        margin-bottom: 5px;
        font-size: 1rem;
        font-weight: 600;
        color: #555;
    }

    .card-body h6 {
        margin-bottom: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: #111;
    }

    .text-primary {
        color: #4e73df !important;
    }

    .text-success {
        color: #1cc88a !important;
    }

    .text-info {
        color: #36b9cc !important;
    }

    .text-warning {
        color: #f6c23e !important;
    }

    .text-danger {
        color: #e74a3b !important;
    }

    .text-secondary {
        color: #858796 !important;
    }

    @media (max-width: 768px) {
        .card {
            min-height: 140px;
            padding: 15px;
        }

        .card-body i {
            width: 50px;
            height: 50px;
            font-size: 1.8rem;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            flex-direction: column;
            text-align: center;
        }

        .card-body i {
            margin-bottom: 10px;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, Admin!</h2>
        <p class="text-muted">This is your dashboard overview.</p>
    </div>

    <div class="row g-3">

        <!-- Total Users -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people-fill text-primary"></i>
                    <div>
                        <h5>Total Users</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM registration"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-person-check-fill text-success"></i>
                    <div>
                        <h5>Active Users</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM registration WHERE status='active'"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-person-check-fill text-success"></i>
                    <div>
                        <h5>Inactive Users</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM registration WHERE status='inactive'"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Users Today -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-person-plus-fill text-info"></i>
                    <div>
                        <h5>New Users Today</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM registration WHERE DATE(created_at)=CURDATE()"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-box-seam text-warning"></i>
                    <div>
                        <h5>Products</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM products"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-box text-primary"></i>
                    <div>
                        <h5>Active Products</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM products WHERE status='active'"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                    <div>
                        <h5>Low Stock</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM products WHERE quantity < 5"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-cart-fill text-danger"></i>
                    <div>
                        <h5>Orders</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM orders"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-hourglass-split text-secondary"></i>
                    <div>
                        <h5>Pending Orders</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM orders WHERE order_status='pending'"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <div>
                        <h5>Completed Orders</h5>
                        <h6 class="counter">
                            <?php echo mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) as count FROM orders WHERE order_status='completed'"))['count']; ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-currency-dollar text-info"></i>
                    <div>
                        <h5>Revenue</h5>
                        <h6 class="counter">
                            ₹<?php echo number_format(mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total_amount) as total FROM orders"))['total'], 2); ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today Revenue -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-cash-stack text-success"></i>
                    <div>
                        <h5>Today Revenue</h5>
                        <h6 class="counter">
                            ₹<?php echo number_format(mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(total_amount) as total FROM orders WHERE DATE(created_at)=CURDATE()"))['total'], 2); ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.innerText.replace(/[^0-9.-]+/g, "");
        let count = 0;
        let increment = Math.ceil(target / 100);
        const updateCounter = () => {
            count += increment;
            if (count >= target) {
                counter.innerText = counter.innerText.includes('₹') ? '₹' + target : target;
            } else {
                counter.innerText = counter.innerText.includes('₹') ? '₹' + count : count;
                setTimeout(updateCounter, 20);
            }
        }
        updateCounter();
    });
</script>

<?php include_once("admin_footer.php"); ?>