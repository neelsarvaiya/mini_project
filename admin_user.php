<?php include_once('admin_header.php') ?>
<style>
    body {
        background-color: #f5f6fa;
    }

    .card {
        border-radius: 1rem;
    }

    .table img {
        object-fit: cover;
    }

    .badge-status {
        padding: 0.5em 0.8em;
        font-size: 0.9rem;
        border-radius: 0.5rem;
    }

    .badge-active {
        background-color: #28a745;
        color: white;
    }

    .badge-inactive {
        background-color: #ffc107;
        color: black;
    }

    .btn-custom {
        border-radius: 50px;
    }
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">User Management</h2>
        <a href="add_user.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New User
        </a>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search users...">
                <button class="btn btn-outline-danger"><i class="bi bi-search"></i> Search</button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM registration";
                        $result = mysqli_query($con, $sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo mysqli_num_rows($result) ?></td>
                                    <td>
                                        <img src="images/profile_pictures/<?= $row['profile_picture']; ?>"
                                            height="100px" width="100px"
                                            class="rounded-circle">
                                    </td>
                                    <td><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['role']; ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'Active') { ?>
                                            <span class="badge badge-status badge-active">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-inactive">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_user.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Static Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-3">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>

        </div>
    </div>

</div>
<?php include_once('admin_footer.php') ?>