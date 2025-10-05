<?php include_once('admin_header.php'); ?>

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

    .table i {
        font-size: 2rem;
        color: #198754;
        /* Bootstrap green */
        transition: transform 0.3s;
    }

    .table i:hover {
        transform: scale(1.2);
        color: #0d6efd;
        /* blue hover */
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
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Service Management</h2>
        <a href="add_service.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New Service
        </a>
    </div>

    <!-- Services Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM services ORDER BY id DESC";
                        $result = mysqli_query($con, $sql);
                        $sr_no = 1;

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?= $sr_no++; ?></td>
                                    <td>
                                        <i class="<?= $row['icon']; ?> fs-1 text-success"></i>
                                    </td>
                                    <td><?= $row['title']; ?></td>
                                    <td><?= $row['description']; ?></td>
                                    <td>
                                        <a href="edit_service.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-info me-1">Edit</a>

                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="deleteService" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No services found</td></tr>";
                        }

                        if (isset($_POST['deleteService'])) {
                            $serviceId = $_POST['id'];
                            $delete_query = "DELETE FROM services WHERE id = $serviceId";
                            if (mysqli_query($con, $delete_query)) {
                            ?>
                                <script>
                                    alert('Service deleted successfully.');
                                    window.location.href = 'admin_service.php';
                                </script>
                            <?php
                            } else {
                            ?>
                                <script>
                                    alert('Failed to delete service.');
                                    window.location.href = 'admin_service.php';
                                </script>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include_once('admin_footer.php'); ?>