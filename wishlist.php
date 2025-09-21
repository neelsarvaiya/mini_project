<?php include_once('header.php');

if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}

$email = $_SESSION['user'];
$wishlist = "select * from wishlist where email='$email'";
$wishlist_result1 = mysqli_query($con, $wishlist);
$wishlist_rows = mysqli_num_rows($wishlist_result1);
?>

<style>
    body {
        background: #f6f9fc;
        font-family: 'Poppins', sans-serif;
    }

    .wishlist-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 15px;
    }

    .wishlist-title {
        font-weight: 700;
        text-align: center;
        font-size: 2.2rem;
        margin-bottom: 2rem;
        color: #6c4ed2;
    }

    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .wishlist-card {
        background: #fff;
        border-radius: 1.2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .wishlist-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.12);
    }

    .wishlist-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 1.2rem;
        border-top-right-radius: 1.2rem;
        transition: 0.3s ease-in-out;
    }

    .wishlist-card:hover .wishlist-image {
        transform: scale(1.05);
    }

    .wishlist-body {
        padding: 1.5rem;
    }

    .wishlist-body h5 {
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .wishlist-body p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .price {
        font-weight: 700;
        font-size: 1.1rem;
        color: #6c4ed2;
        /* theme purple */
        margin-bottom: 1rem;
    }

    .wishlist-actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .wishlist-actions button {
        flex: 1;
        border: none;
        padding: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .btn-cart {
        background: linear-gradient(90deg, #667eea, #6c4ed2);
        color: #fff;
    }

    .btn-cart:hover {
        background: linear-gradient(90deg, #6c4ed2, #667eea);
        transform: scale(1.05);
    }

    .btn-remove {
        background: #f8d7da;
        color: #a71d2a;
    }

    .btn-remove:hover {
        background: #f5c6cb;
        transform: scale(1.05);
    }
</style>

<div class="wishlist-container">
    <h2 class="wishlist-title">My Wishlist</h2>
    <div class="wishlist-grid">
        <div class="row">
            <?php
            if ($wishlist_rows > 0) {

                while ($wishlist_result = $wishlist_result1->fetch_assoc()) {
                    $product_id = $wishlist_result['product_id'];
                    $product_data = "select * from products where id='$product_id'";
                    $product_result = mysqli_fetch_assoc(mysqli_query($con, $product_data));
            ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="wishlist-card">
                            <img src="img/products/<?= $product_result['main_image'] ?>" alt="Product" class="wishlist-image">
                            <div class="wishlist-body">
                                <h5><?= $product_result['product_name'] ?></h5>
                                <p><?= $product_result['description'] ?></p>
                                <div class="price">₹<?= round($product_result['price']); ?><?= $product_result['unit']; ?></div>
                                <div class="wishlist-actions d-flex gap-2 mt-2">
                                    <a href="add_to_cart.php?id=<?= $product_result['id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus me-1"></i> Move to Cart
                                    </a>
                                    <a href="remove_from_wishlist.php?id=<?= $product_result['id'] ?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash me-1"></i> Remove
                                    </a>
                                </div>


                                <style>
                                    .wishlist-actions .btn {
                                        border-radius: 8px;
                                        font-weight: 500;
                                        text-decoration: none !important;
                                        transition: all 0.2s ease-in-out;
                                    }

                                    .wishlist-actions .btn:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                                    }
                                </style>
                            </div>
                        </div>
                    </div>

            <?php
                }
            }
            else {
                ?>
                   <h2>No Product Fond in Whishlist</h2> 
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>