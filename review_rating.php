<?php include_once('header.php');


if (!isset($_SESSION['user'])) {
    setcookie('error', 'Please Login first...', time() + 2, '/');
?>
    <script>
        window.location.href = 'login.php';
    </script>
<?php
}


?>
<style>
    .review-container {
        max-width: 950px;
        margin: 50px auto;
        padding: 20px;
    }

    .review-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        animation: fadeInUp 0.7s ease-in-out;
    }

    .review-card h3 {
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .star-rating {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .star-rating i:hover {
        transform: scale(1.2);
    }

    .star-rating .bi-star-fill {
        color: #ffb400;
        text-shadow: 0 0 10px rgba(255, 180, 0, 0.6);
    }

    textarea {
        resize: none;
        border-radius: 1rem !important;
        padding: 14px;
        border: 1px solid #ddd;
        transition: 0.3s;
    }

    textarea:focus {
        border-color: #fcb69f !important;
        box-shadow: 0 0 12px rgba(252, 182, 159, 0.5);
    }

    .btn-submit {
        background: linear-gradient(90deg, #ff7e5f, #feb47b);
        border: none;
        border-radius: 50px;
        padding: 14px 35px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.5px;
        transition: all 0.3s ease-in-out;
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 25px rgba(255, 126, 95, 0.5);
    }

    .review-list {
        margin-top: 2.5rem;
    }

    .review-item {
        background: #fff;
        border-radius: 1.2rem;
        padding: 1.5rem;
        margin-bottom: 1.2rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        animation: fadeIn 0.8s ease-in-out;
    }

    .review-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
    }

    .review-item h6 {
        font-weight: 600;
        margin-bottom: 0.4rem;
        color: #333;
    }

    .review-item .stars {
        color: #ffb400;
        margin-bottom: 0.7rem;
        font-size: 1.1rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

<div class="review-container">
    <div class="review-card">
        <h3 class="text-center">⭐ Give Your Review</h3>
        <form method="post" action="save_review.php">
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
                <textarea class="form-control" name="review" rows="4" placeholder="Share your experience..." data-validation="required"></textarea>
                <div class="error" id="reviewError"></div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-submit">Post Review</button>
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
<?php include_once('footer.php') ?>