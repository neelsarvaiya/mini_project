<?php include_once("admin_header.php") ?>

<style>
    /* Make all cards same height */
    .card {
        min-height: 160px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        padding: 20px;
    }

    .card-body i {
        font-size: 2rem;
        margin-right: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .card-body h5 {
        margin-bottom: 5px;
        font-size: 1rem;
        font-weight: 600;
    }

    .card-body h6 {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #555;
    }
</style>

<!-- Dashboard Content -->
<div class="container-fluid py-4">

    <!-- Welcome Message -->
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, Admin!</h2>
        <p class="text-muted">This is your simple dashboard overview.</p>
    </div>

    <!-- Dashboard Boxes -->
    <div class="row g-3">
        <!-- Total Users -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-people-fill text-primary"></i>
                    <div>
                        <h5>Total Users</h5>
                        <h6>1,234</h6>
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
                        <h6>123</h6>
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
                        <h6>12</h6>
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
                        <h6>567</h6>
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
                        <h6>890</h6>
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
                        <h6>45</h6>
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
                        <h6>780</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-x-circle-fill text-danger"></i>
                    <div>
                        <h5>Cancelled Orders</h5>
                        <h6>65</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-currency-dollar text-primary"></i>
                    <div>
                        <h5>Revenue</h5>
                        <h6>$12,345</h6>
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
                        <h6>$1,234</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-box text-info"></i>
                    <div>
                        <h5>Active Products</h5>
                        <h6>450</h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Products -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <div>
                        <h5>Low Stock</h5>
                        <h6>23</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include_once("admin_footer.php") ?>
