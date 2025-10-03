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
</style>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Contact Inquiries</h2>
    </div>

    <!-- Contact Table -->
    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Sr. No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once('db_connect.php');
                        $sql = "SELECT * FROM contact_inquiry ORDER BY id DESC";
                        $result = mysqli_query($con, $sql);

                        $sr_no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $sr_no++; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['subject']; ?></td>
                                    <td><?php echo $row['message']; ?></td>
                                    <td>
                                        <!-- Delete -->
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <input type="submit" name="deleteQuery" class="btn btn-sm btn-outline-danger" value="Delete"
                                                onclick="return confirm('Are you sure to delete this inquiry?');">
                                        </form>


                                        <?php if (empty($row['reply'])): ?>
                                            <!-- Show Send Response only if no reply -->
                                            <a href="reply_contact.php?id=<?= $row['id']; ?>"
                                                class="btn btn-sm btn-outline-success">
                                                Send Response
                                            </a>
                                        <?php else: ?>
                                            <!-- Already responded -->
                                            <span class="badge bg-success">Responded</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No inquiries found</td></tr>";
                        }

                        // Delete Logic
                        if (isset($_POST['deleteQuery'])) {
                            $queryId = $_POST['id'];
                            $delete_query = "DELETE FROM contact_inquiry WHERE id = $queryId";
                            if (mysqli_query($con, $delete_query)) {
                            ?>
                                <script>
                                    alert("Inquiry deleted successfully.");
                                    window.location.href = 'admin_contact_query.php';
                                </script>
                            <?php
                            } else {
                                setcookie('error', 'Failed to delete inquiry.', time() + 2, '/');
                            ?>
                                <script>
                                    window.location.href = 'admin_contact.php';
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