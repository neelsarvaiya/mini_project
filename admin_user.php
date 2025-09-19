<?php include_once('admin_header.php') ?>
<style>
    body {
        background-color: #f5f6fa;
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .btn-custom {
        border-radius: 50px;
        font-weight: 500;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }

    .card {
        border-radius: 1.5rem;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .table {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        color: #fff;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .table img {
        object-fit: cover;
        transition: transform 0.3s;
    }

    .table img:hover {
        transform: scale(1.1);
    }

    .badge-status {
        padding: 0.5em 0.8em;
        font-size: 0.9rem;
        border-radius: 50px;
        font-weight: 500;
    }

    .badge-active {
        background-color: #28a745;
        color: white;
    }

    .badge-inactive {
        background-color: #ffc107;
        color: black;
    }

    .input-group .form-control:focus {
        border-color: #6610f2;
        box-shadow: 0 0 0 0.2rem rgba(102, 16, 242, 0.25);
    }

    .pagination .page-item .page-link {
        border-radius: 50px;
        margin: 0 2px;
        border: none;
        color: #6610f2;
        transition: all 0.3s;
    }

    .pagination .page-item.active .page-link {
        background: #6610f2;
        color: #fff;
    }

    .pagination .page-item .page-link:hover {
        background: #0d6efd;
        color: #fff;
    }

    /* Search input group styling */
    .input-group .btn-outline-danger {
        background: linear-gradient(135deg, #6610f2, #0d6efd);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }

    .input-group .btn-outline-danger:hover {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        color: #fff;
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

    <!-- Users Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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

                        $sr_no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $sr_no++; ?></td>
                                    <td>
                                        <img src="images/profile_pictures/<?= $row['profile_picture']; ?>"
                                            height="80px" width="80px"
                                            class="rounded-circle shadow-sm">
                                    </td>
                                    <td><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo ucfirst($row['role']); ?></td>
                                    <td>
                                        <?php if ($row['status'] == 'active') { ?>
                                            <span class="badge badge-status badge-active">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-inactive">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_user.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info me-1 editBtn">
                                            Edit
                                        </a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteUser" class="btn btn-sm btn-outline-danger" value="Delete">
                                        </form>

                                        <?php
                                        if (isset($_POST['deleteUser'])) {
                                            $userId = $_POST['id'];

                                            $result = mysqli_query($con, "SELECT profile_picture FROM registration WHERE id = $userId");
                                            $user = mysqli_fetch_assoc($result);

                                            $delete_query = "DELETE FROM registration WHERE id = $userId";
                                            if (mysqli_query($con, $delete_query)) {
                                                if (!empty($user['profile_picture'])) {
                                                    if (file_exists("images/profile_pictures/" . $user['profile_picture'])) {
                                                        unlink("images/profile_pictures/" . $user['profile_picture']);
                                                    }
                                                }
                                                setcookie('success', 'User Deleted successfully.', time() + 2, '/');
                                        ?>
                                                <script>
                                                    window.location.href = 'admin_user.php';
                                                </script>
                                            <?php
                                            } else {
                                                setcookie('error', 'Failed to Delete User.', time() + 2, '/');
                                            ?>
                                                <script>
                                                    window.location.href = 'admin_user.php';
                                                </script>
                                        <?php
                                            }
                                        }
                                        ?>
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
        </div>
    </div>

</div>
<?php include_once('admin_footer.php') ?>