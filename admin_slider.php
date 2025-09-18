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
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Slider Management</h2>
        <a href="add_slider.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New Slider
        </a>
    </div>

    <!-- Sliders Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM slider ORDER BY id DESC";
                        $result = mysqli_query($con, $sql);

                        $sr_no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $sr_no++; ?></td>
                                    <td>
                                        <img src="images/<?= $row['slider_image']; ?>"
                                            height="100px" width="200px"
                                            class="rounded shadow-sm">
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 'active') { ?>
                                            <span class="badge badge-status badge-active">Active</span>
                                        <?php } else { ?>
                                            <span class="badge badge-status badge-inactive">Inactive</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_slider.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info me-1">
                                            Edit
                                        </a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteSlider"
                                                class="btn btn-sm btn-outline-danger"
                                                value="Delete"
                                                onclick="return confirm('Are you sure you want to delete this slider?');">
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No sliders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                if (isset($_POST['deleteSlider'])) {
                    $sliderId = $_POST['id'];

                    $result = mysqli_query($con, "SELECT slider_image FROM slider WHERE id = $sliderId");
                    $slider = mysqli_fetch_assoc($result);

                    $delete_query = "DELETE FROM slider WHERE id = $sliderId";
                    if (mysqli_query($con, $delete_query)) {
                        if (!empty($slider['slider_image'])) {
                            if (file_exists("images/" . $slider['slider_image'])) {
                                unlink("images/" . $slider['slider_image']);
                            }
                        }
                        echo "<script>alert('Slider deleted successfully');</script>";
                    } else {
                        echo "<script>alert('Error deleting slider');</script>";
                    }
                    echo "<script>window.location.href='admin_slider.php';</script>";
                }
                ?>

            </div>
        </div>
    </div>

</div>
<?php include_once('admin_footer.php') ?>