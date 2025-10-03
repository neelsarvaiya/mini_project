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
        background-color: rgba(13, 110, 253, 0.07);
    }

    .table td {
        vertical-align: middle;
    }

    .stars {
        color: #f1c40f;
        font-size: 1.2rem;
    }

    .btn-sm {
        border-radius: 50px;
        font-weight: 500;
        padding: 0.4rem 1rem;
    }

    .btn-outline-danger {
        transition: all 0.3s ease;
    }

    .btn-outline-danger:hover {
        background: linear-gradient(135deg, #ff4b2b, #ff416c);
        color: #fff;
    }

    .review-text {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Review & Rating Management</h2>
    </div>

    <!-- Reviews Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>User Email</th>
                            <th>Product</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Join reviews with registration (users) and products
                        $sql = "SELECT r.id, r.review_text, r.rating, u.email, p.product_name 
                                FROM reviews r
                                JOIN registration u ON r.user_id = u.id
                                JOIN products p ON r.product_id = p.id
                                ORDER BY r.id DESC";

                        $result = mysqli_query($con, $sql);

                        $sr_no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $sr_no++; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td class="review-text" title="<?php echo $row['review_text']; ?>">
                                        <?php echo $row['review_text']; ?>
                                    </td>
                                    <td>
                                        <span class="stars">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                echo $i <= $row['rating'] ? "★" : "☆";
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteReview" class="btn btn-sm btn-outline-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No reviews found</td></tr>";
                        }

                        if (isset($_POST['deleteReview'])) {
                            $reviewId = $_POST['id'];
                            $delete_query = "DELETE FROM reviews WHERE id = $reviewId";
                            if (mysqli_query($con, $delete_query)) {
                            ?>
                                <script>
                                    alert('Review Deleted successfully.');
                                    window.location.href = 'admin_review_rating.php';
                                </script>
                            <?php
                            } else {
                            ?>
                                <script>
                                    alert('Failed to Delete Review.');
                                    window.location.href = 'admin_review_rating.php';
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
<?php include_once('admin_footer.php') ?>