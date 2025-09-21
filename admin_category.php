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

    /* Badge styles */
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

    /* Icon column */
    .category-icon {
        font-size: 1.8rem;
        color: #6610f2;
        transition: transform 0.3s;
    }
    .category-icon:hover {
        transform: scale(1.2);
        color: #0d6efd;
    }
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Category Management</h2>
        <a href="add_category.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New Category
        </a>
    </div>

    <!-- Category Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM categories";
                        $result = mysqli_query($con, $sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td>
                                        <?php if (!empty($row['icon'])) { ?>
                                            <i class="<?= $row['icon']; ?> category-icon"></i>
                                        <?php } else { ?>
                                            <span class="text-muted">No Icon</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td>
                                        <?php if ($row['category_status'] == 'active') { ?>
                                            <span class="badge badge-status badge-active">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-inactive">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_category.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info me-1">
                                            Edit
                                        </a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteCategory" class="btn btn-sm btn-outline-danger" value="Delete">
                                        </form>

                                        <?php
                                        if (isset($_POST['deleteCategory'])) {
                                            $categoryId = $_POST['id'];

                                            $delete_query = "DELETE FROM categories WHERE id = $categoryId";
                                            if (mysqli_query($con, $delete_query)) {
                                        ?>
                                                <script>
                                                    alert('Category deleted successfully.');
                                                    window.location.href = 'admin_category.php';
                                                </script>
                                            <?php
                                            } else {
                                            ?>
                                                <script>
                                                    alert('Failed to delete Category.');
                                                    window.location.href = 'admin_category.php';
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
                            echo "<tr><td colspan='5' class='text-center'>No categories found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php include_once('admin_footer.php') ?>
