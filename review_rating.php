<?php
include_once('header.php');
include_once('db_connect.php');

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
    exit();
}

if (!isset($_GET['p_id'])) {
    die("Product ID missing.");
}

$p_id = intval($_GET['p_id']);


$query = "SELECT product_name, main_image FROM products WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $p_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Invalid Product ID.");
}
?>

<style>
    body {
        background: #d0e7d8;
        font-family: 'Poppins', sans-serif;
    }

    .review-container {
        max-width: 950px;
        margin: 60px auto;
        padding: 25px;
    }

    .review-card {
        background: #ffffffcc;
        backdrop-filter: blur(16px);
        border-radius: 1.8rem;
        padding: 3rem;
        animation: fadeInUp 0.8s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .review-card::before {
        content: "";
        position: absolute;
        top: -50%;
        right: -50%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 126, 95, 0.4) 0%, transparent 70%);
        border-radius: 50%;
        animation: floatAnim 6s infinite alternate;
    }

    .review-card h3 {
        font-weight: 800;
        color: #222;
        margin-bottom: 1.8rem;
        text-align: center;
        letter-spacing: 0.5px;
    }

    /* Product Info */
    .product-details {
        text-align: center;
        margin-bottom: 2rem;
    }

    .product-details img {
        max-width: 180px;
        border-radius: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease-in-out;
    }

    .product-details img:hover {
        transform: scale(1.08) rotate(-2deg);
    }

    .product-details h4 {
        font-weight: 700;
        color: #444;
        margin-top: 0.5rem;
    }

    /* Stars */
    .star-rating {
        font-size: 2.3rem;
        color: #ddd;
        cursor: pointer;
        transition: transform 0.25s ease-in-out;
    }

    .star-rating i:hover {
        transform: scale(1.25) rotate(-5deg);
    }

    .star-rating .bi-star-fill {
        color: #ff9800;
        text-shadow: 0 0 12px rgba(255, 152, 0, 0.7);
    }

    /* Textarea */
    textarea {
        resize: none;
        border-radius: 1.2rem !important;
        padding: 16px;
        border: 1px solid #ddd;
        transition: all 0.3s ease-in-out;
    }

    textarea:focus {
        border-color: #ff7e5f !important;
        box-shadow: 0 0 14px rgba(255, 126, 95, 0.4);
    }

    /* Button */
    .btn-submit {
        background: #2f8f3c;
        border: none;
        border-radius: 60px;
        padding: 14px 40px;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
        letter-spacing: 0.7px;
        transition: all 0.35s ease-in-out;
    }

    .btn-submit:hover {
        transform: translateY(-4px) scale(1.07);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floatAnim {
        from {
            transform: translateY(0px);
        }

        to {
            transform: translateY(20px);
        }
    }
</style>

<div class="review-container">
    <div class="review-card">

        <!-- Product Info -->
        <div class="product-details">
            <img src="images/products/<?php echo htmlspecialchars($product['main_image']); ?>" alt="Product Image">
            <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
        </div>

        <!-- Review Form -->
        <h3>⭐ Share Your Experience</h3>
        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $p_id; ?>">

            <div class="mb-3 text-center">
                <span class="star-rating" id="stars">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </span>
                <input type="hidden" name="rating" id="rating" data-validation="required">
                <div class="error" id="ratingError"></div>
            </div>

            <div class="mb-3">
                <textarea class="form-control shadow-sm" name="review" rows="4" placeholder="Tell us what you think..." data-validation="required"></textarea>
                <div class="error" id="reviewError"></div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-submit" name="review_save">🚀 Post Review</button>
            </div>
        </form>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('#stars i');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = star.getAttribute('data-value');
            ratingInput.value = value;

            stars.forEach(s => {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
            });

            for (let i = 0; i < value; i++) {
                stars[i].classList.remove('bi-star');
                stars[i].classList.add('bi-star-fill');
            }
        });
    });
</script>

<?php include_once('footer.php');

if (isset($_POST['review_save'])) {
    $rating     = intval($_POST['rating']);
    $review     = mysqli_real_escape_string($con, $_POST['review']);
    $product_id = intval($_POST['product_id']);
    $user_email = $_SESSION['user']; 

    $user_query = "SELECT id FROM registration WHERE email = ?";
    $stmtUser = $con->prepare($user_query);
    $stmtUser->bind_param("s", $user_email);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    $userRow = $resultUser->fetch_assoc();

    if (!$userRow) {
        setcookie('error', 'User not found in registration table', time() + 2, '/');
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }

    $user_id = $userRow['id'];

    $query = "INSERT INTO reviews (user_id, product_id, rating, review_text) 
              VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review);

    if ($stmt->execute()) {
        setcookie('success', 'Review & Rating saved...', time() + 2, '/');
    } else {
        setcookie('error', 'Error saving Review & Rating', time() + 2, '/');
    }
?>
    <script>
        window.location.href = "order_history.php";
    </script>
<?php
}


?>