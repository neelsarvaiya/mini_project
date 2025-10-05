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
        <h2 class="mb-0">Offer Management</h2>
        <a href="add_offer.php" class="btn btn-danger btn-custom">
            <i class="bi bi-plus-circle"></i> Add New Offer
        </a>
    </div>

    <!-- Offers Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sr. No</th>
                            <th>Category</th>
                            <th>Offer Title</th>
                            <th>Discount (%)</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch all offers with category name
                        $sql = "SELECT o.*, c.category_name 
                                FROM offers o
                                JOIN categories c ON o.category_id = c.id";
                        $result = mysqli_query($con, $sql);

                        $sr_no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $sr_no++; ?></td>
                                    <td><?= $row['category_name']; ?></td>
                                    <td><?= $row['title']; ?></td>
                                    <td><?= $row['discount']; ?>%</td>
                                    <td>
                                        <img src="images/products/<?= $row['image']; ?>"
                                            height="80px" width="80px"
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
                                        <a href="edit_offer.php?id=<?= $row['id']; ?>"
                                            class="btn btn-sm btn-outline-info me-1">Edit</a>

                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteOffer" class="btn btn-sm btn-outline-danger" value="Delete">
                                        </form>

                                        <?php
                                        if (isset($_POST['deleteOffer'])) {
                                            $offerId = $_POST['id'];

                                            // First, fetch the offer details to get the image name
                                            $select_query = "SELECT image FROM offers WHERE id = $offerId";
                                            $result = mysqli_query($con, $select_query);
                                            $offer = mysqli_fetch_assoc($result);

                                            $delete_query = "DELETE FROM offers WHERE id = $offerId";
                                            if (mysqli_query($con, $delete_query)) {

                                                if (!empty($offer['image'])) {
                                                    $imagePath = "images/products/" . $offer['image'];
                                                    if (file_exists($imagePath)) {
                                                        unlink($imagePath);
                                                    }
                                                }
                                        ?>
                                                <script>
                                                    alert('Offer Deleted Successfully.');
                                                    window.location.href = 'admin_offer.php';
                                                </script>
                                            <?php
                                            } else {
                                            ?>
                                                <script>
                                                    alert('Failed to Delete Offer.');
                                                    window.location.href = 'admin_offer.php';
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
                            echo "<tr><td colspan='6' class='text-center'>No offers found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include_once('admin_footer.php') ?>